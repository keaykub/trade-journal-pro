<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Trade;

class TradeForm extends Component
{
    use WithFileUploads;

    public $step = 1;
    public $totalSteps = 3;

    // Form fields
    public $symbol, $orderType = 'buy', $entryDate, $entryTime, $exitDate, $exitTime;
    public $entryPrice, $exitPrice, $stopLoss, $takeProfit, $lotSize, $orderCategory = 'market';
    public $strategy, $customStrategy, $emotionBefore, $emotionAfter, $notes;

    // Manual input toggles and values
    public $manualPnl = false; // toggle สำหรับ manual P&L input
    public $manualPnlValue = 0; // ค่า P&L ที่ user กรอกเอง
    public $manualResult = false; // toggle สำหรับ manual result selection
    public $manualResultValue = 'pending'; // ค่า result ที่ user เลือกเอง

    // Images - กลับมาใช้ multiple upload แบบเดิม
    public $uploadedImages = [];
    public $imageNotes = []; // เพิ่ม array สำหรับ note ของแต่ละรูป

    protected $rules = [
        // Step 1
        'symbol'      => 'required|string|max:20',
        'orderType'   => 'required|in:buy,sell',
        'entryDate'   => 'required|date',
        // Step 2
        'entryPrice'  => 'required|numeric',
        // Step 3
        'strategy'    => 'required|string',
        // Upload - ลดขนาดไฟล์
        'uploadedImages' => 'nullable|array|max:10',
        'uploadedImages.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048', // ลดเหลือ 2MB
    ];

    public function mount()
    {
        $this->entryDate = now()->format('Y-m-d');
        $this->entryTime = now()->format('H:i');
        $this->exitDate = now()->format('Y-m-d');
        $this->exitTime = now()->format('H:i');
        $this->orderCategory = 'market';
    }

    public function updatedUploadedImages()
    {
        // Real-time validation เมื่อมีการอัพโหลดรูป
        $this->validateOnly('uploadedImages');
        $this->validateOnly('uploadedImages.*');

        // ตรวจสอบขนาดไฟล์
        if ($this->uploadedImages) {
            foreach ($this->uploadedImages as $index => $image) {
                if ($image && $image->getSize() > 2048 * 1024) { // 2MB
                    $this->addError("uploadedImages.{$index}", 'รูปภาพต้องมีขนาดไม่เกิน 2MB');
                }
            }
        }
    }

    // Computed Properties สำหรับ Real-time Calculation
    public function getPnlProperty()
    {
        $entry = floatval($this->entryPrice);
        $exit = floatval($this->exitPrice);
        $lots = floatval($this->lotSize);

        if ($entry && $exit && $lots) {
            $pnl = ($this->orderType === 'buy')
                ? ($exit - $entry) * $lots * 100000
                : ($entry - $exit) * $lots * 100000;
            return $pnl; // ส่งค่าตัวเลขดิบ ไม่ format ที่นี่
        }
        return 0;
    }

    public function getRiskRewardProperty()
    {
        $entry = floatval($this->entryPrice);
        $sl = floatval($this->stopLoss);
        $tp = floatval($this->takeProfit);

        if ($entry && $sl && $tp) {
            $risk = abs($entry - $sl);
            $reward = abs($tp - $entry);
            return $risk > 0 ? round($reward / $risk, 2) : null;
        }
        return null;
    }

    // Final values - ใช้ manual หรือ auto ตามที่ user เลือก
    public function getFinalPnlProperty()
    {
        return $this->manualPnl ? $this->manualPnlValue : $this->pnl;
    }

    public function getFinalResultProperty()
    {
        return $this->manualResult ? $this->manualResultValue : $this->result;
    }

    public function getResultProperty()
    {
        $pnl = $this->finalPnl;
        return $pnl > 0 ? 'win' : ($pnl < 0 ? 'loss' : 'breakeven');
    }

    // เพิ่ม helper methods สำหรับการแสดงผล
    public function getFormattedPnlProperty()
    {
        return number_format($this->finalPnl, 2);
    }

    public function getPnlPercentageProperty()
    {
        $entry = floatval($this->entryPrice);
        $lots = floatval($this->lotSize);

        if ($entry && $lots && $this->finalPnl) {
            $investment = $entry * $lots * 100000; // ประมาณการเงินลงทุน
            return $investment > 0 ? round(($this->finalPnl / $investment) * 100, 2) : 0;
        }
        return 0;
    }

    public function getRiskRewardColorProperty()
    {
        if (!$this->riskReward) return 'slate';

        return match (true) {
            $this->riskReward >= 3 => 'green',
            $this->riskReward >= 2 => 'blue',
            $this->riskReward >= 1 => 'yellow',
            default => 'red'
        };
    }

    public function nextStep()
    {
        $this->validate($this->stepValidationRules());

        if ($this->step < $this->totalSteps) {
            $this->step++;
        }
    }

    public function prevStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function stepValidationRules()
    {
        return match ($this->step) {
            1 => [
                'symbol'    => 'required|string|max:20',
                'orderType' => 'required|in:buy,sell',
                'entryDate' => 'required|date',
            ],
            2 => [
                'entryPrice' => 'required|numeric',
            ],
            3 => [
                'strategy'       => 'required|string',
                'uploadedImages' => 'nullable|array|max:10',
                'uploadedImages.*' => 'image|max:5120',
            ],
            default => [],
        };
    }

    public function removeImage($index)
    {
        unset($this->uploadedImages[$index]);
        unset($this->imageNotes[$index]); // ลบ note ด้วย
        $this->uploadedImages = array_values($this->uploadedImages); // reset index
        $this->imageNotes = array_values($this->imageNotes); // reset index
    }

    public function submit()
    {
        $this->validate();

        try {
            $imageData = [];

            // อัพโหลดรูปภาพไป S3 และเก็บข้อมูลรูป + notes
            foreach ($this->uploadedImages as $index => $image) {
                try {
                    // สร้างชื่อไฟล์ที่ unique
                    $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();

                    // อัพโหลดตรงไป S3/R2
                    $s3Path = 'trade-images/' . $filename;
                    Storage::disk('s3')->put($s3Path, $image->get(), 'public');

                    // สร้าง public URL
                    $publicUrl = env('AWS_URL') . '/' . $s3Path;

                    // เก็บข้อมูลรูปและ note ในรูปแบบ JSON structure
                    $imageData[] = [
                        'filename' => $filename,
                        'url' => $publicUrl, // เก็บ full URL ไว้เลย
                        'path' => $s3Path,
                        'note' => $this->imageNotes[$index] ?? null,
                        'uploaded_at' => now()->toDateTimeString(),
                        'size' => $image->getSize(),
                        'mime_type' => $image->getMimeType()
                    ];

                } catch (\Exception $e) {
                    \Log::error('Failed to upload image to S3: ' . $e->getMessage());
                    // ถ้ารูปใดรูปหนึ่งอัพโหลดไม่ได้ ข้ามไป
                    continue;
                }
            }

            // บันทึกข้อมูลลง Database
            $trade = Trade::create([
                'id' => \Str::uuid(),
                'user_id' => auth()->id(),
                'symbol' => $this->symbol,
                'order_type' => $this->orderType,
                'order_category' => $this->orderCategory,
                'entry_date' => $this->entryDate,
                'entry_time' => $this->entryTime ?: null,
                'exit_date' => $this->exitDate ?: null,
                'exit_time' => $this->exitTime ?: null,
                'entry_price' => $this->entryPrice,
                'exit_price' => $this->exitPrice ?: null,
                'stop_loss' => $this->stopLoss ?: null,
                'take_profit' => $this->takeProfit ?: null,
                'lot_size' => $this->lotSize ?: null,
                'pnl' => $this->finalPnl ?: null,
                'pips' => property_exists($this, 'pips') ? $this->pips : null,
                'risk_reward' => $this->riskReward ?: null,
                'commission' => 0, // จะเพิ่มฟิลด์นี้ภายหลัง
                'swap' => 0, // จะเพิ่มฟิลด์นี้ภายหลัง
                'result' => $this->finalResult ?: null,
                'strategy' => $this->strategy ?: null,
                'custom_strategy' => ($this->strategy === 'other') ? $this->customStrategy : null,
                'emotion_before' => $this->emotionBefore ?: null,
                'emotion_after' => $this->emotionAfter ?: null,
                'notes' => $this->notes ?: null,
                'images' => !empty($imageData) ? json_encode($imageData) : null,
                'tags' => null, // จะเพิ่มฟีเจอร์นี้ภายหลัง
                'is_demo' => false, // จะเพิ่มฟีเจอร์นี้ภายหลัง
                'is_shared' => false, // จะเพิ่มฟีเจอร์นี้ภายหลัง
            ]);

            // แสดงข้อความสำเร็จ
            $imageCount = count($imageData);
            $successMessage = 'บันทึกการเทรดสำเร็จ!';

            if ($imageCount > 0) {
                $successMessage .= ' อัพโหลดรูปภาพ: ' . $imageCount . ' รูป';
            }

            session()->flash('success', $successMessage);

            // ล้างข้อมูลฟอร์ม
            $this->reset();
            $this->step = 1;

            // Redirect ไปหน้าดูข้อมูล Trade หรือ Dashboard
            return redirect()->route('dashboard')->with('trade_created', $trade->id);

        } catch (\Exception $e) {
            \Log::error('Failed to save trade: ' . $e->getMessage());

            session()->flash('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล กรุณาลองใหม่อีกครั้ง');

            // ไม่ reset ฟอร์ม เพื่อให้ user สามารถแก้ไขและส่งใหม่ได้
            return;
        }
    }


    public function render()
    {
        // Set ผ่าน View::share แทน
        view()->share([
            'title' => 'บันทึกการเทรด',
            'description' => 'กรอกข้อมูลการเทรดของคุณที่นี่'
        ]);

        return view('livewire.trade-form')
            ->layout('layouts.main');
    }
}
