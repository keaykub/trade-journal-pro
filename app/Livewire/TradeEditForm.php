<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Trade;

class TradeEditForm extends Component
{
    use WithFileUploads;

    public $trade; // Trade model instance
    public $tradeId; // Trade ID
    public $step = 1;
    public $totalSteps = 3;

    // Form fields
    public $symbol, $orderType = 'buy', $entryDate, $entryTime, $exitDate, $exitTime;
    public $entryPrice, $exitPrice, $stopLoss, $takeProfit, $lotSize, $orderCategory = 'market';
    public $strategy, $customStrategy, $emotionBefore, $emotionAfter, $notes;

    // Manual input toggles and values
    public $manualPnl = false;
    public $manualPnlValue = 0;
    public $manualResult = false;
    public $manualResultValue = 'pending';

    // Images
    public $uploadedImages = [];
    public $imageNotes = [];
    public $existingImages = []; // สำหรับรูปที่มีอยู่แล้ว
    public $imagesToDelete = []; // รูปที่จะลบ

    // Helper method สำหรับจำกัดจำนวนรูป
    public function getMaxImagesProperty()
    {
        return auth()->user()->isFree() ? 3 : 10;
    }

    public function getMaxImageSizeProperty()
    {
        return auth()->user()->isFree() ? 1024 : 2048;
    }

    protected function rules()
    {
        return [
            'symbol'      => 'required|string|max:20',
            'orderType'   => 'required|in:buy,sell',
            'entryDate'   => 'required|date',
            'entryPrice'  => 'required|numeric',
            'strategy'    => 'required|string',
            'manualPnlValue' => 'nullable|numeric|between:-999999,999999',
            'notes'      => 'nullable|string|max:500',
            'uploadedImages' => 'nullable|array|max:' . $this->maxImages,
            'uploadedImages.*' => 'image|mimes:jpg,jpeg,png,webp|max:' . $this->maxImageSize,
            'imageNotes.*' => 'nullable|string|max:255',
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

    public function mount($id)
    {
        $this->tradeId = $id;
        $this->trade = Trade::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $this->loadTradeData();

        // Debug: ตรวจสอบข้อมูลรูป
        \Log::info('Raw images from DB: ' . $this->trade->images);
        \Log::info('Parsed existing images: ', $this->existingImages);
        \Log::info('Image notes: ', $this->imageNotes);
    }

    private function loadTradeData()
    {
        // Basic Information
        $this->symbol = $this->trade->symbol;
        $this->orderType = $this->trade->order_type;
        $this->entryDate = $this->trade->formatted_entry_date;
        $this->entryTime = $this->trade->entry_time;
        $this->exitDate = $this->trade->formatted_exit_date;
        $this->exitTime = $this->trade->exit_time;
        $this->orderCategory = $this->trade->order_category ?? 'market';

        // Trade Details
        $this->entryPrice = $this->trade->entry_price;
        $this->exitPrice = $this->trade->exit_price;
        $this->stopLoss = $this->trade->stop_loss;
        $this->takeProfit = $this->trade->take_profit;
        $this->lotSize = $this->trade->lot_size;

        // Strategy & Psychology
        $this->strategy = $this->trade->strategy;
        $this->customStrategy = $this->trade->custom_strategy;
        $this->emotionBefore = $this->trade->emotion_before;
        $this->emotionAfter = $this->trade->emotion_after;
        $this->notes = $this->trade->notes;

        // Manual values - ตรวจสอบว่าเป็น manual หรือ auto
        if ($this->trade->pnl !== null) {
            // ถ้ามี P&L บันทึกไว้ ให้ใช้ manual mode
            $this->manualPnl = true;
            $this->manualPnlValue = $this->trade->pnl;
        }

        if ($this->trade->result) {
            // ถ้ามี result บันทึกไว้ ให้ใช้ manual mode
            $this->manualResult = true;
            $this->manualResultValue = $this->trade->result;
        }

        // Load existing images
        $this->loadExistingImages();
    }

    private function loadExistingImages()
    {
        if ($this->trade->images) {
            $imageData = json_decode($this->trade->images, true, 512, JSON_UNESCAPED_UNICODE);

            if (is_array($imageData)) {
                $this->existingImages = [];
                $this->imageNotes = [];

                foreach ($imageData as $index => $image) {
                    // แก้ไข URL ให้เป็น full URL
                    $imageUrl = $image['url'] ?? '';

                    // ถ้า URL ไม่มี domain ให้เพิ่ม
                    if (!str_starts_with($imageUrl, 'http')) {
                        $imageUrl = env('AWS_URL') . '/' . ltrim($imageUrl, '/');
                    }

                    $this->existingImages[] = [
                        'id' => $index,
                        'url' => $imageUrl, // ← ใช้ URL ที่แก้ไขแล้ว
                        'filename' => $image['filename'] ?? '',
                        'note' => $image['note'] ?? '',
                        'path' => $image['path'] ?? '',
                        'uploaded_at' => $image['uploaded_at'] ?? null,
                        'size' => $image['size'] ?? null,
                        'mime_type' => $image['mime_type'] ?? null
                    ];

                    $this->imageNotes[$index] = $image['note'] ?? '';
                }

                // Debug: ตรวจสอบ URL ใหม่
                \Log::info('Fixed first image URL: ' . ($this->existingImages[0]['url'] ?? 'none'));
            }
        }
    }

    // เพิ่ม method สำหรับ validate ข้อมูลก่อน submit
    private function validateTradeData()
    {
        // ตรวจสอบว่า Symbol มีการเปลี่ยนแปลงหรือไม่
        if ($this->symbol !== $this->trade->symbol) {
            // Validate symbol format
            if (!preg_match('/^[A-Z0-9]{3,12}$/', strtoupper($this->symbol))) {
                throw new \Exception('Symbol format ไม่ถูกต้อง กรุณาใช้ตัวอักษรภาษาอังกฤษและตัวเลขเท่านั้น');
            }
        }

        // ตรวจสอบ Entry Date ไม่ควรเป็นอนาคต
        if ($this->entryDate && \Carbon\Carbon::parse($this->entryDate)->isFuture()) {
            throw new \Exception('วันที่เข้าเทรดไม่ควรเป็นวันในอนาคต');
        }

        // ตรวจสอบ Exit Date ไม่ควรเป็นก่อน Entry Date
        if ($this->exitDate && $this->entryDate) {
            $entryDate = \Carbon\Carbon::parse($this->entryDate);
            $exitDate = \Carbon\Carbon::parse($this->exitDate);

            if ($exitDate->lt($entryDate)) {
                throw new \Exception('วันที่ออกจากเทรดไม่ควรเป็นก่อนวันที่เข้าเทรด');
            }
        }

        // ตรวจสอบราคา
        if ($this->entryPrice <= 0) {
            throw new \Exception('ราคาเข้าต้องมากกว่า 0');
        }

        if ($this->exitPrice && $this->exitPrice <= 0) {
            throw new \Exception('ราคาออกต้องมากกว่า 0');
        }

        // ตรวจสอบ Lot Size
        if ($this->lotSize && $this->lotSize <= 0) {
            throw new \Exception('ขนาดโพซิชันต้องมากกว่า 0');
        }

        // ตรวจสอบ Manual P&L
        if ($this->manualPnl && $this->manualPnlValue !== null) {
            if (!is_numeric($this->manualPnlValue)) {
                throw new \Exception('P&L ต้องเป็นตัวเลข');
            }
        }
    }

    // เพิ่ม method สำหรับ backup ข้อมูลเดิมก่อน update
    private function backupOriginalData()
    {
        return [
            'original_images' => $this->trade->images,
            'original_data' => $this->trade->toArray()
        ];
    }

    // เพิ่ม method สำหรับ rollback ถ้ามี error
    private function rollbackChanges($backup, $uploadedFiles = [])
    {
        try {
            // ลบไฟล์ที่อัพโหลดใหม่ถ้ามี error
            foreach ($uploadedFiles as $filePath) {
                if (Storage::disk('s3')->exists($filePath)) {
                    Storage::disk('s3')->delete($filePath);
                }
            }

            // คืนค่าข้อมูลเดิม (ถ้าจำเป็น)
            // สำหรับกรณีที่ต้องการ rollback database transaction

        } catch (\Exception $e) {
            \Log::error('Rollback failed: ' . $e->getMessage());
        }
    }

    // Real-time validation
    public function updatedManualPnlValue()
    {
        if ($this->manualPnlValue !== null && $this->manualPnlValue !== '') {
            if (abs($this->manualPnlValue) > 999999) {
                $this->manualPnlValue = $this->manualPnlValue > 0 ? 999999 : -999999;
                $this->addError('manualPnlValue', 'P&L ถูกปรับเป็นค่าสูงสุดที่ยอมรับได้');
            }
        }
    }

    public function updatedUploadedImages()
    {
        // เช็คจำนวนรูปรวม (existing + new)
        $totalImages = count($this->existingImages) + count($this->uploadedImages);

        if ($totalImages > $this->maxImages) {
            $this->addError('uploadedImages', "แผน " . (auth()->user()->isFree() ? 'Free' : 'Pro/Premium') . " อัพโหลดได้สูงสุด {$this->maxImages} รูป (รวมรูปเดิม)");
            return;
        }

        $this->validateOnly('uploadedImages');
        $this->validateOnly('uploadedImages.*');
    }

    // Computed Properties (เหมือนเดิม)
    public function getPnlProperty()
    {
        $entry = floatval($this->entryPrice);
        $exit = floatval($this->exitPrice);
        $lots = floatval($this->lotSize);

        if (!$entry || !$exit || !$lots || !$this->symbol) {
            return 0;
        }

        $pairInfo = $this->getCurrencyPairInfo($this->symbol);
        $pipDifference = $this->orderType === 'buy'
            ? ($exit - $entry) / $pairInfo['pip_size']
            : ($entry - $exit) / $pairInfo['pip_size'];

        return $pipDifference * $pairInfo['pip_value'] * $lots;
    }

    private function getCurrencyPairInfo($symbol)
    {
        $symbol = strtoupper($symbol);

        $majorPairs = [
            'EURUSD' => ['pip_size' => 0.0001, 'pip_value' => 10],
            'GBPUSD' => ['pip_size' => 0.0001, 'pip_value' => 10],
            'AUDUSD' => ['pip_size' => 0.0001, 'pip_value' => 10],
            'NZDUSD' => ['pip_size' => 0.0001, 'pip_value' => 10],
        ];

        $usdBasePairs = [
            'USDCAD' => ['pip_size' => 0.0001, 'pip_value' => 7.5],
            'USDCHF' => ['pip_size' => 0.0001, 'pip_value' => 11],
            'USDJPY' => ['pip_size' => 0.01, 'pip_value' => 9.5],
        ];

        $crossPairs = [
            'EURJPY' => ['pip_size' => 0.01, 'pip_value' => 9.5],
            'GBPJPY' => ['pip_size' => 0.01, 'pip_value' => 9.5],
            'EURGBP' => ['pip_size' => 0.0001, 'pip_value' => 13],
        ];

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
            ?? ['pip_size' => 0.0001, 'pip_value' => 10];
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

    public function getFormattedPnlProperty()
    {
        $pnl = $this->finalPnl;
        $absPnl = abs($pnl);

        if ($absPnl >= 1000000) {
            return number_format($pnl / 1000000, 1) . 'M';
        } elseif ($absPnl >= 10000) {
            return number_format($pnl / 1000, 1) . 'K';
        } else {
            return number_format($pnl, 2);
        }
    }

    public function getFullFormattedPnlProperty()
    {
        return number_format($this->finalPnl, 2);
    }

    public function getIsPnlAbbreviatedProperty()
    {
        return abs($this->finalPnl) >= 10000;
    }

    public function getPnlPercentageProperty()
    {
        $entry = floatval($this->entryPrice);
        $lots = floatval($this->lotSize);

        if ($entry && $lots && $this->finalPnl) {
            $investment = $entry * $lots * 100000;
            return $investment > 0 ? round(($this->finalPnl / $investment) * 100, 2) : 0;
        }
        return 0;
    }

    // Navigation
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

    // Image management
    public function removeNewImage($index)
    {
        unset($this->uploadedImages[$index]);
        $this->uploadedImages = array_values($this->uploadedImages);

        // อัพเดท imageNotes สำหรับรูปใหม่
        if (isset($this->imageNotes[$index + count($this->existingImages)])) {
            unset($this->imageNotes[$index + count($this->existingImages)]);
            $this->imageNotes = array_values($this->imageNotes);
        }
    }

    public function removeExistingImage($index)
    {
        if (isset($this->existingImages[$index])) {
            // เพิ่มลงใน list ที่จะลบ
            $this->imagesToDelete[] = $this->existingImages[$index]['path'];

            // ลบออกจาก existing images
            unset($this->existingImages[$index]);
            $this->existingImages = array_values($this->existingImages);

            // ลบ note ที่เกี่ยวข้อง
            if (isset($this->imageNotes[$index])) {
                unset($this->imageNotes[$index]);
                $this->imageNotes = array_values($this->imageNotes);
            }
        }
    }

    public function submit()
    {
        $this->validate();

        // Backup ข้อมูลเดิมก่อน update
        $backup = $this->backupOriginalData();
        $uploadedNewFiles = []; // เก็บ path ของไฟล์ใหม่ที่อัพโหลด

        try {
            // ตรวจสอบข้อมูลเพิ่มเติม
            $this->validateTradeData();

            // เริ่ม Database Transaction
            \DB::beginTransaction();

            // เตรียมข้อมูลรูปภาพ
            $finalImageData = [];

            // 1. เก็บรูปเดิมที่ไม่ถูกลบ
            foreach ($this->existingImages as $index => $existingImage) {
                $finalImageData[] = [
                    'filename' => $existingImage['filename'],
                    'url' => $existingImage['url'],
                    'path' => $existingImage['path'],
                    'note' => $this->imageNotes[$index] ?? $existingImage['note'],
                    'uploaded_at' => $existingImage['uploaded_at'] ?? now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(), // บันทึกเวลาที่แก้ไข note
                ];
            }

            // 2. อัพโหลดรูปใหม่
            foreach ($this->uploadedImages as $index => $image) {
                try {
                    // สร้างชื่อไฟล์ที่ unique
                    $filename = 'edit_' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $s3Path = 'trade-images/' . $filename;

                    // อัพโหลดไป S3
                    Storage::disk('s3')->put($s3Path, $image->get(), 'public');
                    $publicUrl = env('AWS_URL') . '/' . $s3Path;

                    // เก็บ path ไว้สำหรับ rollback ถ้ามี error
                    $uploadedNewFiles[] = $s3Path;

                    $existingCount = count($this->existingImages);
                    $noteIndex = $existingCount + $index;

                    $finalImageData[] = [
                        'filename' => $filename,
                        'url' => $publicUrl,
                        'path' => $s3Path,
                        'note' => $this->imageNotes[$noteIndex] ?? null,
                        'uploaded_at' => now()->toDateTimeString(),
                        'size' => $image->getSize(),
                        'mime_type' => $image->getMimeType(),
                        'is_new' => true, // Flag สำหรับรูปใหม่
                    ];

                } catch (\Exception $e) {
                    \Log::error('Failed to upload new image during edit: ' . $e->getMessage());
                    throw new \Exception('ไม่สามารถอัพโหลดรูปภาพได้ กรุณาลองใหม่อีกครั้ง');
                }
            }

            // 3. อัพเดทข้อมูลในฐานข้อมูล
            $updateData = [
                'symbol' => strtoupper($this->symbol),
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
                'risk_reward' => $this->riskReward ?: null,
                'result' => $this->finalResult ?: null,
                'strategy' => $this->strategy ?: null,
                'custom_strategy' => ($this->strategy === 'other') ? $this->customStrategy : null,
                'emotion_before' => $this->emotionBefore ?: null,
                'emotion_after' => $this->emotionAfter ?: null,
                'notes' => $this->notes ?: null,
                'images' => !empty($finalImageData) ? json_encode($finalImageData) : null,
                'updated_at' => now(),
            ];

            $this->trade->update($updateData);

            // 4. ลบรูปที่ไม่ต้องการออกจาก S3 (หลังจาก database update สำเร็จ)
            foreach ($this->imagesToDelete as $imagePath) {
                try {
                    if ($imagePath && Storage::disk('s3')->exists($imagePath)) {
                        Storage::disk('s3')->delete($imagePath);
                        \Log::info('Deleted old image from S3: ' . $imagePath);
                    }
                } catch (\Exception $e) {
                    \Log::error('Failed to delete old image from S3: ' . $e->getMessage());
                    // ไม่ throw error เพราะข้อมูลใน database update สำเร็จแล้ว
                }
            }

            // Commit transaction
            \DB::commit();

            // สร้างข้อความสำเร็จ
            $imageCount = count($finalImageData);
            $newImageCount = count($this->uploadedImages);
            $deletedImageCount = count($this->imagesToDelete);

            $successMessage = 'แก้ไขข้อมูลการเทรดสำเร็จ!';

            if ($imageCount > 0) {
                $successMessage .= ' รูปภาพทั้งหมด: ' . $imageCount . ' รูป';

                if ($newImageCount > 0) {
                    $successMessage .= ' (เพิ่มใหม่: ' . $newImageCount . ' รูป)';
                }

                if ($deletedImageCount > 0) {
                    $successMessage .= ' (ลบ: ' . $deletedImageCount . ' รูป)';
                }
            }

            session()->flash('success', $successMessage);

            // กลับไปหน้าดูข้อมูล trade
            return redirect()->route('trades.show', $this->trade->id);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Rollback transaction
            \DB::rollback();

            // Rollback uploaded files
            $this->rollbackChanges($backup, $uploadedNewFiles);

            // Re-throw validation exception เพื่อให้ Livewire จัดการ
            throw $e;

        } catch (\Exception $e) {
            // Rollback transaction
            \DB::rollback();

            // Rollback uploaded files
            $this->rollbackChanges($backup, $uploadedNewFiles);

            \Log::error('Failed to update trade: ' . $e->getMessage(), [
                'trade_id' => $this->trade->id,
                'user_id' => auth()->id(),
                'error' => $e->getTraceAsString()
            ]);

            // แสดงข้อความ error ที่เป็นมิตร
            $errorMessage = 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล: ' . $e->getMessage();
            session()->flash('error', $errorMessage);

            return;
        }
    }

    // เพิ่ม method ใน TradeEditForm.php สำหรับตรวจสอบการเปลี่ยนแปลงที่สำคัญ

public function checkCriticalChanges()
{
    $warnings = [];

    // ตรวจสอบการเปลี่ยนแปลง Symbol
    if ($this->symbol !== $this->trade->symbol) {
        $warnings[] = "คุณกำลังเปลี่ยน Symbol จาก '{$this->trade->symbol}' เป็น '{$this->symbol}'";
    }

    // ตรวจสอบการเปลี่ยนแปลง Order Type
    if ($this->orderType !== $this->trade->order_type) {
        $oldType = $this->trade->order_type === 'buy' ? 'Long' : 'Short';
        $newType = $this->orderType === 'buy' ? 'Long' : 'Short';
        $warnings[] = "คุณกำลังเปลี่ยนทิศทางการเทรดจาก {$oldType} เป็น {$newType}";
    }

    // ตรวจสอบการเปลี่ยนแปลง Entry Price มากกว่า 5%
    if ($this->entryPrice && $this->trade->entry_price) {
        $priceChange = abs($this->entryPrice - $this->trade->entry_price) / $this->trade->entry_price * 100;
        if ($priceChange > 5) {
            $warnings[] = "ราคาเข้าเปลี่ยนแปลงมากกว่า 5% (" . number_format($priceChange, 2) . "%)";
        }
    }

    // ตรวจสอบการเปลี่ยนแปลง P&L อย่างมีนัยสำคัญ
    if ($this->manualPnl && $this->trade->pnl) {
            $pnlChange = abs($this->manualPnlValue - $this->trade->pnl);
            if ($pnlChange > 1000) {
                $warnings[] = "P&L เปลี่ยนแปลงมากกว่า $1,000 (เปลี่ยนแปลง: $" . number_format($pnlChange, 2) . ")";
            }
        }

        return $warnings;
    }

    // เพิ่ม method สำหรับแสดง confirmation dialog ใน Livewire
    public function showCriticalChangesModal()
    {
        $warnings = $this->checkCriticalChanges();

        if (!empty($warnings)) {
            // ส่ง warnings ไปยัง frontend เพื่อแสดง modal
            $this->dispatch('show-critical-changes-modal', warnings: $warnings);
            return false; // หยุดการ submit
        }

        return true; // ไม่มีการเปลี่ยนแปลงที่สำคัญ
    }

    // เพิ่ม method สำหรับ submit หลังจาก confirm
    public function submitWithConfirmation()
    {
        // Submit โดยไม่ต้องเช็ค critical changes อีก
        $this->submit();
    }

    public function render()
    {
        view()->share([
            'title' => 'แก้ไขการเทรด - ' . $this->trade->symbol,
            'description' => 'แก้ไขข้อมูลการเทรดของคุณ'
        ]);

        return view('livewire.trade-edit-form')
            ->layout('layouts.main');
    }
}
