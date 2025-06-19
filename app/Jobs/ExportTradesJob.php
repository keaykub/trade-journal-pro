<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Trade;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ExportTradesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300;
    public $tries = 3;

    public function __construct(public User $user, public ?array $filters = []){}

    public function handle(): void
    {
        try {
            \Log::info('Starting export job', ['user_id' => $this->user->id]);

            // สร้าง query สำหรับดึงข้อมูล trades
            $query = Trade::where('user_id', $this->user->id);

            // Apply filters ถ้ามี
            if (!empty($this->filters['date_from'])) {
                $query->whereDate('entry_date', '>=', $this->filters['date_from']);
            }

            if (!empty($this->filters['date_to'])) {
                $query->whereDate('entry_date', '<=', $this->filters['date_to']);
            }

            if (!empty($this->filters['status'])) {
                $query->where('status', $this->filters['status']);
            }

            if (!empty($this->filters['trade_type'])) {
                $query->where('trade_type', $this->filters['trade_type']);
            }

            if (!empty($this->filters['pair'])) {
                $query->where('pair', 'like', '%' . $this->filters['pair'] . '%');
            }

            if (isset($this->filters['is_demo'])) {
                $query->where('is_demo', $this->filters['is_demo']);
            }

            if (!empty($this->filters['pnl_min'])) {
                $query->where('pnl', '>=', $this->filters['pnl_min']);
            }

            if (!empty($this->filters['pnl_max'])) {
                $query->where('pnl', '<=', $this->filters['pnl_max']);
            }

            // ดึงข้อมูล
            $trades = $query->orderBy('entry_date', 'desc')
                           ->orderBy('entry_time', 'desc')
                           ->get();

            \Log::info('Trades found', ['count' => $trades->count(), 'user_id' => $this->user->id]);

            if ($trades->isEmpty()) {
                \Log::info('No trades found for export', ['user_id' => $this->user->id]);

                // สร้างไฟล์ว่างเปล่าเพื่อแจ้งว่าไม่มีข้อมูล
                $fileName = 'trades_export_empty_' . $this->user->id . '_' . Carbon::now()->format('Y-m-d_H-i-s') . '.csv';
                $filePath = 'exports/' . $fileName;

                $emptyContent = "\xEF\xBB\xBF" . "No trades found for the selected criteria\n";
                Storage::disk('public')->put($filePath, $emptyContent);

                Cache::put("user:{$this->user->id}:export_ready", $filePath, now()->addMinutes(30));
                \Log::info('Empty export file created', ['path' => $filePath]);

                return;
            }

            // สร้าง CSV content
            $csvContent = $this->generateCsvContent($trades);

            // สร้างชื่อไฟล์
            $fileName = 'trades_export_' . $this->user->id . '_' . Carbon::now()->format('Y-m-d_H-i-s') . '.csv';
            $filePath = 'exports/' . $fileName;

            // ตรวจสอบว่า directory มีอยู่ไหม
            $directory = dirname($filePath);
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            // บันทึกไฟล์
            Storage::disk('public')->put($filePath, $csvContent);

            // ตรวจสอบว่าไฟล์ถูกสร้างจริงไหม
            if (!Storage::disk('public')->exists($filePath)) {
                throw new \Exception('Failed to create export file');
            }

            // เก็บ path ลง cache พร้อมเวลาที่ยาวขึ้น
            Cache::put("user:{$this->user->id}:export_ready", $filePath, now()->addMinutes(30));

            \Log::info('Export completed successfully', [
                'user_id' => $this->user->id,
                'file_path' => $filePath,
                'file_size' => Storage::disk('public')->size($filePath)
            ]);

        } catch (\Exception $e) {
            \Log::error('Export trades job failed', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // สร้างไฟล์ error message
            $fileName = 'trades_export_error_' . $this->user->id . '_' . Carbon::now()->format('Y-m-d_H-i-s') . '.txt';
            $filePath = 'exports/' . $fileName;

            $errorContent = "Export failed: " . $e->getMessage();
            Storage::disk('public')->put($filePath, $errorContent);

            Cache::put("user:{$this->user->id}:export_error", $e->getMessage(), now()->addMinutes(10));

            throw $e;
        }
    }

    private function generateCsvContent($trades): string
    {
        $csv = [];

        // Header
        $csv[] = [
            'Trade ID',
            'Pair',
            'Trade Type',
            'Entry Date',
            'Entry Time',
            'Exit Date',
            'Exit Time',
            'Entry Price',
            'Exit Price',
            'Stop Loss',
            'Take Profit',
            'Lot Size',
            'Pips',
            'P&L',
            'Risk/Reward',
            'Commission',
            'Swap',
            'Account Type',
            'Status',
            'Tags',
            'Notes',
            'Created At'
        ];

        // Data rows
        foreach ($trades as $trade) {
            $csv[] = [
                $trade->id,
                $trade->pair ?? '',
                $trade->trade_type ?? '',
                $trade->formatted_entry_date ?? ($trade->entry_date ? $trade->entry_date->format('Y-m-d') : ''),
                $trade->entry_time ?? '',
                $trade->formatted_exit_date ?? ($trade->exit_date ? $trade->exit_date->format('Y-m-d') : ''),
                $trade->exit_time ?? '',
                $trade->entry_price ?? 0,
                $trade->exit_price ?? 0,
                $trade->stop_loss ?? 0,
                $trade->take_profit ?? 0,
                $trade->lot_size ?? 0,
                $trade->pips ?? 0,
                $trade->pnl ?? 0,
                $trade->risk_reward ?? 0,
                $trade->commission ?? 0,
                $trade->swap ?? 0,
                $trade->is_demo ? 'Demo' : 'Real',
                $trade->status ?? '',
                is_array($trade->tags) ? implode(', ', $trade->tags) : ($trade->tags ?? ''),
                $trade->notes ?? '',
                $trade->created_at ? $trade->created_at->format('Y-m-d H:i:s') : ''
            ];
        }

        // Convert array to CSV string
        $output = fopen('php://temp', 'r+');
        foreach ($csv as $row) {
            fputcsv($output, $row);
        }
        rewind($output);
        $csvString = stream_get_contents($output);
        fclose($output);

        // Add BOM for UTF-8
        return "\xEF\xBB\xBF" . $csvString;
    }

    public function failed(\Throwable $exception): void
    {
        \Log::error('Export trades job failed permanently', [
            'user_id' => $this->user->id,
            'error' => $exception->getMessage()
        ]);

        Cache::put("user:{$this->user->id}:export_error", $exception->getMessage(), now()->addMinutes(10));
    }
}
