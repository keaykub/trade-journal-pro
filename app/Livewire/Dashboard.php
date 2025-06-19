<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Trade;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Jobs\ExportTradesJob;
use Illuminate\Support\Facades\Storage;


class Dashboard extends Component
{
    use WithPagination;

    // Search and Filter Properties
    public bool $exporting = false;
    public $search = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $statusFilter = '';
    public $strategyFilter = '';

    public $showShareModal = false;             //new
    public $shareUrl = '';                      //new
    public $sharingTradeId = null;              //new

    // Pagination
    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        // Set default date range to current month
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = now()->endOfMonth()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedStrategyFilter()
    {
        $this->resetPage();
    }

    public function shareTrade($tradeId)
    {
        $trade = Trade::where('id', $tradeId)
                     ->where('user_id', auth()->id())
                     ->firstOrFail();

        // เปิดการแชร์
        $trade->update(['is_shared' => true]);

        // เก็บข้อมูลสำหรับ modal
        $this->sharingTradeId = $tradeId;
        $this->shareUrl = route('trades.public', $trade->id);
        $this->showShareModal = true;

        // แจ้งเตือน
        session()->flash('success', 'Trade shared successfully!');
    }

    public function closeShareModal()
    {
        $this->showShareModal = false;
        $this->shareUrl = '';
        $this->sharingTradeId = null;
    }

    // Method สำหรับยกเลิกการแชร์
    public function unshareTrade($tradeId)
    {
        $trade = Trade::where('id', $tradeId)
                     ->where('user_id', auth()->id())
                     ->firstOrFail();

        $trade->update(['is_shared' => false]);

        session()->flash('info', 'Trade unshared successfully!');
    }
    public function resetFilters()
    {
        $this->search = '';
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = now()->endOfMonth()->format('Y-m-d');
        $this->statusFilter = '';
        $this->strategyFilter = '';
        $this->resetPage();
    }

    public function exportTrades()
    {
        $user = auth()->user();

        $key = "export_count_user_{$user->id}";
        $limit = 3;
        $count = Cache::get($key, 0);

        if ($count >= $limit) {
            $this->js(<<<'JS'
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: {
                        message: "คุณสามารถ export ได้ไม่เกิน 3 ครั้งต่อชั่วโมง",
                        type: "error"
                    }
                }));
            JS);
            return;
        }

        Cache::put($key, $count + 1, now()->addHour());

        // ลบ cache เก่าก่อน (ถ้ามี)
        Cache::forget("user:{$user->id}:export_ready");

        $this->exporting = true;
        ExportTradesJob::dispatch($user);

        $this->js(<<<'JS'
            window.dispatchEvent(new CustomEvent('toast', {
                detail: {
                    message: "ระบบกำลังจัดเตรียมไฟล์ export กรุณารอสักครู่...",
                    type: "info"
                }
            }));

            // เริ่มตรวจสอบไฟล์ทุก 2 วินาที
            window.exportCheckInterval = setInterval(() => {
                $wire.checkExportReady();
            }, 2000);
        JS);
    }

    public function checkExportReady()
    {
        if (! $this->exporting) return;

        $user = auth()->user();
        $cacheKey = "user:{$user->id}:export_ready";
        $path = Cache::get($cacheKey);

        if ($path && Storage::disk('public')->exists($path)) {
            Cache::forget($cacheKey);

            $this->exporting = false; // หยุดเช็ก
            $downloadUrl = asset('storage/' . $path);

            $this->js(<<<JS
                (function() {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            message: "ไฟล์พร้อมดาวน์โหลดแล้ว!",
                            type: "success"
                        }
                    }));
                    window.dispatchEvent(new CustomEvent('download-file', {
                        detail: {
                            url: "{$downloadUrl}"
                        }
                    }));
                })();
            JS);
        }
    }

    public function deleteTrade($tradeId)
    {
        try {
            $trade = Trade::where('user_id', auth()->id())->findOrFail($tradeId);
            $trade->delete();

            session()->flash('success', 'ลบการเทรดเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            session()->flash('error', 'เกิดข้อผิดพลาดในการลบข้อมูล');
        }
    }

    public function getTradesProperty()
    {
        $query = Trade::where('user_id', auth()->id())
            ->when($this->search, function($q) {
                $q->where(function($query) {
                    $search = $this->search;
                    // ค้นหาใน symbol, strategy, และ custom_strategy
                    $query->where('symbol', 'like', '%' . $search . '%')
                          ->orWhere('strategy', 'like', '%' . $search . '%')
                          ->orWhere('custom_strategy', 'like', '%' . $search . '%');
                });
            })
            ->when($this->dateFrom, function($q) {
                $q->whereDate('entry_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function($q) {
                $q->whereDate('entry_date', '<=', $this->dateTo);
            })
            ->when($this->statusFilter, function($q) {
                $q->where('result', $this->statusFilter);
            })
            ->when($this->strategyFilter, function($q) {
                // Filter โดยพิจารณาทั้ง strategy และ custom_strategy
                $q->where(function($query) {
                    $strategy = $this->strategyFilter;
                    $query->where('strategy', $strategy)
                          ->orWhere('custom_strategy', $strategy);
                });
            })
            ->orderBy('entry_date', 'desc')
            ->orderBy('entry_time', 'desc');

        return $query->paginate(5);
    }

    // Stats Methods (UI only for now)
    public function getTotalTradesProperty()
    {
        return Trade::where('user_id', auth()->id())
            ->when($this->dateFrom, function($q) {
                $q->whereDate('entry_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function($q) {
                $q->whereDate('entry_date', '<=', $this->dateTo);
            })
            ->count();
    }

    public function getWinRateProperty()
    {
        $totalTrades = $this->totalTrades;
        if ($totalTrades == 0) return 0;

        $winTrades = Trade::where('user_id', auth()->id())
            ->where('result', 'win')
            ->when($this->dateFrom, function($q) {
                $q->whereDate('entry_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function($q) {
                $q->whereDate('entry_date', '<=', $this->dateTo);
            })
            ->count();

        return round(($winTrades / $totalTrades) * 100, 1);
    }

    public function getTotalPnlProperty()
    {
        return Trade::where('user_id', auth()->id())
            ->when($this->dateFrom, function($q) {
                $q->whereDate('entry_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function($q) {
                $q->whereDate('entry_date', '<=', $this->dateTo);
            })
            ->sum('pnl') ?? 0;
    }

    public function getBestStrategyProperty()
    {
        $trades = Trade::where('user_id', auth()->id())
            ->when($this->dateFrom, function($q) {
                $q->whereDate('entry_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function($q) {
                $q->whereDate('entry_date', '<=', $this->dateTo);
            })
            ->get();

        // Group by final strategy (use custom_strategy if strategy is 'other')
        $strategies = $trades->groupBy(function($trade) {
            return $trade->strategy === 'other' ? $trade->custom_strategy : $trade->strategy;
        })->map(function($group) {
            return $group->sum('pnl');
        })->sortDesc();

        return $strategies->keys()->first() ?? 'N/A';
    }

    public function getUniqueStrategiesProperty()
    {
        $trades = Trade::where('user_id', auth()->id())
            ->whereNotNull('strategy')
            ->get();

        // Collect all unique strategies (use custom_strategy if strategy is 'other')
        $strategies = $trades->map(function($trade) {
            return $trade->strategy === 'other' ? $trade->custom_strategy : $trade->strategy;
        })->filter()->unique()->values()->toArray();

        return $strategies;
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'trades' => $this->trades,
            'totalTrades' => $this->totalTrades,
            'winRate' => $this->winRate,
            'totalPnl' => $this->totalPnl,
            'bestStrategy' => $this->bestStrategy,
            'uniqueStrategies' => $this->uniqueStrategies,
        ])->layout('layouts.main');
    }
}
