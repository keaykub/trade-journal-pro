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

    // 🆕 Helper method สำหรับจำกัดจำนวนรูป
    public function getMaxImagesProperty()
    {
        return auth()->user()->isFree() ? 3 : 10;
    }

    public function getMaxImageSizeProperty()
    {
        return auth()->user()->isFree() ? 1024 : 2048; // 1MB vs 2MB
    }

    protected function rules()
    {
        return [
            // Step 1
            'symbol'      => 'required|string|max:20',
            'orderType'   => 'required|in:buy,sell',
            'entryDate'   => 'required|date',
            // Step 2
            'entryPrice'  => 'required|numeric',
            // Step 3
            'strategy'    => 'required|string',
            // Manual P&L validation - จำกัดค่าที่สมเหตุสมผล
            'manualPnlValue' => 'nullable|numeric|between:-999999,999999',
            // Upload - Dynamic validation ตาม plan
            'uploadedImages' => 'nullable|array|max:' . $this->maxImages,
            'uploadedImages.*' => 'image|mimes:jpg,jpeg,png,webp|max:' . $this->maxImageSize,
        ];
    }

    protected function messages()
    {
        $planName = auth()->user()->isFree() ? 'Free' : 'Pro/Premium';

        return [
            'manualPnlValue.between' => 'P&L ต้องอยู่ระหว่าง -$999,999 ถึง $999,999',
            'manualPnlValue.numeric' => 'P&L ต้องเป็นตัวเลขเท่านั้น',
            'uploadedImages.max' => "แผน {$planName} อัพโหลดได้สูงสุด {$this->maxImages} รูป",
            'uploadedImages.*.max' => "แผน {$planName} ไฟล์ขนาดสูงสุด " . ($this->maxImageSize / 1024) . "MB",
        ];
    }

    public function mount()
    {
        $this->entryDate = now()->format('Y-m-d');
        $this->entryTime = now()->format('H:i');
        $this->exitDate = now()->format('Y-m-d');
        $this->exitTime = now()->format('H:i');
        $this->orderCategory = 'market';
    }

    // Real-time validation สำหรับ manual P&L
    public function updatedManualPnlValue()
    {
        // ตรวจสอบช่วงค่าที่ยอมรับได้
        if ($this->manualPnlValue !== null && $this->manualPnlValue !== '') {
            if (abs($this->manualPnlValue) > 999999) {
                $this->manualPnlValue = $this->manualPnlValue > 0 ? 999999 : -999999;
                $this->addError('manualPnlValue', 'P&L ถูกปรับเป็นค่าสูงสุดที่ยอมรับได้');
            }
        }
    }

    public function updatedUploadedImages()
    {
        // 🆕 เช็คจำนวนรูปตาม plan ก่อน
        if (count($this->uploadedImages) > $this->maxImages) {
            $this->addError('uploadedImages', "แผน " . (auth()->user()->isFree() ? 'Free' : 'Pro/Premium') . " อัพโหลดได้สูงสุด {$this->maxImages} รูป");

            // ตัดรูปส่วนเกินออก
            $this->uploadedImages = array_slice($this->uploadedImages, 0, $this->maxImages);
            return;
        }

        // Real-time validation เมื่อมีการอัพโหลดรูป
        $this->validateOnly('uploadedImages');
        $this->validateOnly('uploadedImages.*');

        // ตรวจสอบขนาดไฟล์ตาม plan
        if ($this->uploadedImages) {
            foreach ($this->uploadedImages as $index => $image) {
                if ($image && $image->getSize() > $this->maxImageSize * 1024) {
                    $maxMB = $this->maxImageSize / 1024;
                    $this->addError("uploadedImages.{$index}", "แผน " . (auth()->user()->isFree() ? 'Free' : 'Pro/Premium') . " ไฟล์ขนาดสูงสุด {$maxMB}MB");
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

        if (!$entry || !$exit || !$lots || !$this->symbol) {
            return 0;
        }

        // แยกประเภทคู่เงิน
        $pairInfo = $this->getCurrencyPairInfo($this->symbol);

        // คำนวณ pip difference
        $pipDifference = $this->orderType === 'buy'
            ? ($exit - $entry) / $pairInfo['pip_size']
            : ($entry - $exit) / $pairInfo['pip_size'];

        // คำนวณ P&L
        $pnl = $pipDifference * $pairInfo['pip_value'] * $lots;

        return $pnl;
    }

    private function getCurrencyPairInfo($symbol)
    {
        $symbol = strtoupper($symbol);

        // Major Pairs (USD เป็น Quote Currency)
        $majorPairs = [
            'EURUSD' => ['pip_size' => 0.0001, 'pip_value' => 10],
            'GBPUSD' => ['pip_size' => 0.0001, 'pip_value' => 10],
            'AUDUSD' => ['pip_size' => 0.0001, 'pip_value' => 10],
            'NZDUSD' => ['pip_size' => 0.0001, 'pip_value' => 10],
        ];

        // USD เป็น Base Currency
        $usdBasePairs = [
            'USDCAD' => ['pip_size' => 0.0001, 'pip_value' => 7.5], // ประมาณ
            'USDCHF' => ['pip_size' => 0.0001, 'pip_value' => 11],
            'USDJPY' => ['pip_size' => 0.01, 'pip_value' => 9.5],   // JPY ใช้ 0.01
        ];

        // Cross Currency Pairs
        $crossPairs = [
            'EURJPY' => ['pip_size' => 0.01, 'pip_value' => 9.5],
            'GBPJPY' => ['pip_size' => 0.01, 'pip_value' => 9.5],
            'EURGBP' => ['pip_size' => 0.0001, 'pip_value' => 13],
        ];

        return $majorPairs[$symbol]
            ?? $usdBasePairs[$symbol]
            ?? $crossPairs[$symbol]
            ?? ['pip_size' => 0.0001, 'pip_value' => 10]; // default
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
        return $this->manualPnl ? floatval($this->manualPnlValue) : $this->pnl;
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

    // ปรับปรุง helper methods สำหรับการแสดงผล - รองรับตัวเลขใหญ่
    public function getFormattedPnlProperty()
    {
        $pnl = $this->finalPnl;

        // ถ้าค่าใหญ่มาก ให้แสดงในรูปแบบย่อ
        $absPnl = abs($pnl);

        if ($absPnl >= 1000000) {
            // 1M+ แสดงเป็น M
            $formatted = number_format($pnl / 1000000, 1) . 'M';
        } elseif ($absPnl >= 10000) {
            // 10K+ แสดงเป็น K
            $formatted = number_format($pnl / 1000, 1) . 'K';
        } else {
            // ต่ำกว่า 10K แสดงเต็ม
            $formatted = number_format($pnl, 2);
        }

        return $formatted;
    }

    // เพิ่ม method สำหรับแสดงเต็ม (ใช้ใน tooltip หรือ detail)
    public function getFullFormattedPnlProperty()
    {
        return number_format($this->finalPnl, 2);
    }

    // เพิ่ม method สำหรับตรวจสอบว่าค่าถูกย่อหรือไม่
    public function getIsPnlAbbreviatedProperty()
    {
        return abs($this->finalPnl) >= 10000;
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
                'uploadedImages' => 'nullable|array|max:' . $this->maxImages,
                'uploadedImages.*' => 'image|max:' . ($this->maxImageSize * 1024),
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
