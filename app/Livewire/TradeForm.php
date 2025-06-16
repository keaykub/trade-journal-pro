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

    // Images - แก้ไขเป็น separate property สำหรับการจัดการ
    public $uploadedImages = [];
    public $newImages = []; // เพิ่ม property ใหม่สำหรับรูปที่อัพโหลดใหม่
    public $imageNotes = []; // เพิ่ม array สำหรับ note ของแต่ละรูป

    // 🆕 Helper method สำหรับจำกัดจำนวนรูป
    public function getMaxImagesProperty()
    {
        $user = auth()->user();

        // Cache subscription data for 5 minutes
        $cacheKey = "user_subscription_limits_{$user->id}";

        $subscriptionData = cache()->remember($cacheKey, 300, function () use ($user) {
            $activeSubscription = $user->subscriptions()
                ->where('stripe_status', 'active')
                ->first();

            return [
                'has_subscription' => (bool) $activeSubscription,
                'price_id' => $activeSubscription->stripe_price ?? null,
                'plan_type' => $this->determinePlanType($activeSubscription),
            ];
        });

        if (!$subscriptionData['has_subscription']) {
            return 3; // Free plan
        }

        $limits = [
            'price_1RaIueCZi1bmUwYslJWl6shH' => 10, // ProPlan รายเดือน
            'price_basic_monthly' => 10,
            'price_pro_monthly' => 10,
            'price_premium_monthly' => 10,
        ];

        return $limits[$subscriptionData['price_id']] ?? 10;
    }

    public function getMaxImageSizeProperty()
    {
        $user = auth()->user();
        $cacheKey = "user_subscription_limits_{$user->id}";

        $subscriptionData = cache()->get($cacheKey);

        // ถ้าไม่มีใน cache ให้ดึงใหม่
        if (!$subscriptionData) {
            $activeSubscription = $user->subscriptions()
                ->where('stripe_status', 'active')
                ->first();

            $subscriptionData = [
                'has_subscription' => (bool) $activeSubscription,
                'price_id' => $activeSubscription->stripe_price ?? null,
            ];

            cache()->put($cacheKey, $subscriptionData, 300);
        }

        if (!$subscriptionData['has_subscription']) {
            return 1024; // Free plan - 1MB
        }

        $limits = [
            'price_1RaIueCZi1bmUwYslJWl6shH' => 3072, // ProPlan - 3MB
            'price_basic_monthly' => 2048,            // Basic - 2MB
            'price_pro_monthly' => 5120,              // Pro - 5MB
            'price_premium_monthly' => 10240,         // Premium - 10MB
        ];

        return $limits[$subscriptionData['price_id']] ?? 2048;
    }

    private function determinePlanType($subscription)
    {
        if (!$subscription) {
            return 'free';
        }

        $priceId = $subscription->stripe_price;

        $planTypes = [
            'price_1RaIueCZi1bmUwYslJWl6shH' => 'pro',
            'price_basic_monthly' => 'basic',
            'price_pro_monthly' => 'pro',
            'price_premium_monthly' => 'premium',
        ];

        return $planTypes[$priceId] ?? 'basic';
    }

    // Method สำหรับ clear cache เมื่อ subscription เปลี่ยนแปลง
    public function clearSubscriptionCache()
    {
        $user = auth()->user();
        $cacheKey = "user_subscription_limits_{$user->id}";
        cache()->forget($cacheKey);
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
            // Note
            'notes' => 'nullable|string|max:500',
            // Upload - Dynamic validation ตาม plan
            'newImages' => 'nullable|array|max:' . $this->maxImages,
            'newImages.*' => 'image|mimes:jpg,jpeg,png,webp|max:' . $this->maxImageSize,
            // Image notes - ถ้ามีรูป ต้องมี note ด้วย
            'imageNotes.*' => 'nullable|string|max:255',
        ];
    }

    protected function messages()
    {
        $planName = auth()->user()->isFree() ? 'Free' : 'Pro/Premium';

        return [
            'manualPnlValue.between' => 'P&L ต้องอยู่ระหว่าง -$999,999 ถึง $999,999',
            'manualPnlValue.numeric' => 'P&L ต้องเป็นตัวเลขเท่านั้น',
            'newImages.max' => "แผน {$planName} อัพโหลดได้สูงสุด {$this->maxImages} รูป",
            'newImages.*.max' => "แผน {$planName} ไฟล์ขนาดสูงสุด " . ($this->maxImageSize / 1024) . "MB",
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

    // แก้ไข method นี้เป็น newImages แทน
    public function updatedNewImages()
    {
        // Append รูปใหม่เข้ากับรูปเก่า
        if ($this->newImages) {
            // เช็คจำนวนรูปรวมแล้ว
            $totalImages = count($this->uploadedImages) + count($this->newImages);

            if ($totalImages > $this->maxImages) {
                $allowedNew = $this->maxImages - count($this->uploadedImages);
                $this->addError('newImages', "สามารถอัพโหลดได้อีก {$allowedNew} รูปเท่านั้น (ขีดจำกัด: {$this->maxImages} รูป)");

                // ตัดรูปส่วนเกินออก
                $this->newImages = array_slice($this->newImages, 0, $allowedNew);
                return;
            }

            // Validation รูปใหม่
            $this->validateOnly('newImages');
            $this->validateOnly('newImages.*');

            // ตรวจสอบขนาดไฟล์
            foreach ($this->newImages as $index => $image) {
                if ($image && $image->getSize() > $this->maxImageSize * 1024) {
                    $maxMB = $this->maxImageSize / 1024;
                    $this->addError("newImages.{$index}", "แผน " . (auth()->user()->isFree() ? 'Free' : 'Pro/Premium') . " ไฟล์ขนาดสูงสุด {$maxMB}MB");
                }
            }

            // เพิ่มรูปใหม่เข้าไปใน array หลัก
            foreach ($this->newImages as $newImage) {
                $this->uploadedImages[] = $newImage;
            }

            // Clear newImages หลังจาก append แล้ว
            $this->newImages = [];
        }
    }

    // เพิ่ม method สำหรับลบรูป
    public function removeImage($index)
    {
        unset($this->uploadedImages[$index]);
        unset($this->imageNotes[$index]);

        // Re-index arrays
        $this->uploadedImages = array_values($this->uploadedImages);
        $this->imageNotes = array_values($this->imageNotes);
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

        // Commodities and Metals
        $commodities = [
            'XAUUSD' => ['pip_size' => 0.01, 'pip_value' => 1],     // ทองคำ - $1 per 0.01 movement
            'GOLD' => ['pip_size' => 0.01, 'pip_value' => 1],       // ทองคำ (ถ้าต้องการเพิ่ม)
            'XAGUSD' => ['pip_size' => 0.001, 'pip_value' => 5],    // เงิน (ถ้าต้องการเพิ่ม)
            'USOIL' => ['pip_size' => 0.01, 'pip_value' => 10],     // น้ำมันดิบ (WTI)
            'UKOIL' => ['pip_size' => 0.01, 'pip_value' => 10],     // น้ำมันดิบ (Brent)
        ];

        return $majorPairs[$symbol]
            ?? $usdBasePairs[$symbol]
            ?? $crossPairs[$symbol]
            ?? $commodities[$symbol]
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
                'newImages' => 'nullable|array|max:' . $this->maxImages,
                'newImages.*' => 'image|max:' . ($this->maxImageSize * 1024),
            ],
            default => [],
        };
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

    public function resetStep1()
    {
        // Reset ข้อมูลพื้นฐาน
        $this->symbol = '';
        $this->orderType = 'buy';
        $this->entryDate = now()->format('Y-m-d');
        $this->entryTime = now()->format('H:i');
        $this->exitDate = now()->format('Y-m-d');
        $this->exitTime = now()->format('H:i');

        // Clear errors
        $this->resetErrorBag(['symbol', 'orderType', 'entryDate']);

        session()->flash('info', 'ล้างข้อมูลพื้นฐานแล้ว');
    }

    public function resetStep2()
    {
        // Reset ข้อมูลการเทรด
        $this->entryPrice = '';
        $this->exitPrice = '';
        $this->stopLoss = '';
        $this->takeProfit = '';
        $this->lotSize = '';

        // Reset manual inputs
        $this->manualPnl = false;
        $this->manualPnlValue = 0;
        $this->manualResult = false;
        $this->manualResultValue = 'pending';

        // Clear errors
        $this->resetErrorBag(['entryPrice', 'exitPrice', 'stopLoss', 'takeProfit', 'lotSize', 'manualPnlValue']);

        session()->flash('info', 'ล้างข้อมูลการเทรดแล้ว');
    }

    public function resetStep3()
    {
        // Reset กลยุทธ์และจิตวิทยา
        $this->strategy = '';
        $this->customStrategy = '';
        $this->emotionBefore = '';
        $this->emotionAfter = '';
        $this->notes = '';

        // Reset รูปภาพ
        $this->uploadedImages = [];
        $this->newImages = [];
        $this->imageNotes = [];

        // Clear errors
        $this->resetErrorBag(['strategy', 'customStrategy', 'notes', 'uploadedImages', 'newImages']);

        session()->flash('info', 'ล้างข้อมูลกลยุทธ์และรูปภาพแล้ว');
    }

    public function resetAllForm()
    {
        // Reset ทุกอย่าง
        $this->reset([
            'symbol', 'orderType', 'entryDate', 'entryTime', 'exitDate', 'exitTime',
            'entryPrice', 'exitPrice', 'stopLoss', 'takeProfit', 'lotSize',
            'strategy', 'customStrategy', 'emotionBefore', 'emotionAfter', 'notes',
            'uploadedImages', 'newImages', 'imageNotes',
            'manualPnl', 'manualPnlValue', 'manualResult', 'manualResultValue'
        ]);

        // Reset เป็นค่าเริ่มต้น
        $this->mount();

        // กลับไปหน้าแรก
        $this->step = 1;

        session()->flash('success', 'ล้างข้อมูลทั้งหมดและเริ่มต้นใหม่แล้ว');
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
