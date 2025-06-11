<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\PublicPage\PaymentManage;
use App\Models\PublicPage\SubscriptionManage;
use App\Models\Payment; // เพิ่มบรรทัดนี้
use App\Models\Plan;    // เพิ่มบรรทัดนี้
use App\Services\EasySlipService;
use App\Services\HelperService;

class PricingController extends Controller
{
    protected $easySlipService;
    protected $helperService;
    protected $paymentManage;
    protected $SubscriptionManage;

    public function __construct(EasySlipService $easySlipService, HelperService $helperService)
    {
        $this->easySlipService      = $easySlipService;
        $this->helperService        = $helperService;
        $this->paymentManage        = new PaymentManage();
        $this->SubscriptionManage   = new SubscriptionManage();
    }

    public function checkSlip(Request $request)
    {
        if (!$request->isMethod('post')) {
            abort(405, 'Method Not Allowed');
        }

        $user = auth()->user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Validate request inputs
        $request->validate([
            'slip_image' => 'required|image|max:10240', // max 10MB
            'plan_id' => 'required|uuid|exists:plans,id',
            'payment_method' => 'required|string'
        ]);

        try {
            // Store slip image
            $path = $request->file('slip_image')->store('slips', 'public');
            $plan_id = $request->input('plan_id');
            $payment_method = $request->input('payment_method');

            if (!$path || !$plan_id || !$payment_method) {
                return response()->json(['error' => 'Invalid input'], 400);
            }

            $fullPath = storage_path('app/public/' . $path);
            $base64 = $this->helperService->imageToBase64($fullPath);

            if (!$base64) {
                // Clean up uploaded file if base64 conversion fails
                Storage::disk('public')->delete($path);
                return response()->json(['error' => 'Failed to convert image to base64'], 500);
            }

            // สร้างข้อมูล payment เบื้องต้น
            $data = [
                'user_id' => $user->id,
                'plan_id' => $plan_id,
                'slip_url' => $path,
                'status' => 'pending',
            ];
            $resultdata = $this->paymentManage->storeSlipData($data); // เพิ่ม $this->

            // ตรวจสอบสลิปกับ EasySlip
            $verify_result = $this->easySlipService->verifySlip($base64);

            if (!$verify_result || ($verify_result['status'] ?? 0) !== 200) {
                Log::warning('EasySlip verification failed', [
                    'user_id' => $user->id,
                    'slip_url' => $path,
                    'payment_id' => $resultdata->id,
                    'base64_length' => strlen($base64),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'ไม่สามารถตรวจสอบสลิปได้ กรุณาลองใหม่หรือติดต่อผู้ดูแลระบบ',
                    'data' => 'verification_failed',
                ], 400);
            }

            // ตรวจสอบความถูกต้องของสลิป
            $slipValidation = $this->easySlipService->isValidSlip($verify_result);

            // ดึงข้อมูล plan เพื่อเช็คจำนวนเงิน
            $plan = Plan::find($plan_id); // แก้จาก \App\Models\Plan เป็น Plan
            if (!$plan) {
                return response()->json(['error' => 'Plan not found'], 404);
            }

            // เช็คจำนวนเงินตรงกับ plan หรือไม่
            $slipAmount = $slipValidation['amount'] ?? 0;
            if (abs($slipAmount - $plan->price) > 0.01) { // ใช้ abs เพื่อเช็คผลต่าง
                return response()->json([
                    'success' => false,
                    'message' => "จำนวนเงินในสลิป ({$slipAmount} บาท) ไม่ตรงกับราคาแผน ({$plan->price} บาท)",
                    'data' => 'amount_mismatch',
                ], 400);
            }

            // เช็คเลขบัญชีปลายทาง (ถ้ามี setting)
            $expectedAccountNumber = 'XXX-X-XX657-7'; // หรือดึงจาก database
            $slipAccountNumber = $slipValidation['receiver_account_number'] ?? '';

            if ($expectedAccountNumber && $slipAccountNumber !== $expectedAccountNumber) {
                return response()->json([
                    'success' => false,
                    'message' => 'เลขบัญชีปลายทางไม่ถูกต้อง กรุณาโอนเงินไปยังบัญชีที่ระบุ',
                    'data' => 'wrong_account',
                ], 400);
            }

            // เช็ค ref_id ซ้ำ (ถ้ามี)
            $refId = $slipValidation['transRef'] ?? null;
            if ($refId) {
                $existingRef = Payment::where('ref_id', $refId)->where('id', '!=', $resultdata->id)->first();
                if ($existingRef) {
                    return response()->json([
                        'success' => false,
                        'message' => 'รหัสอ้างอิงนี้เคยถูกใช้แล้ว',
                        'data' => 'duplicate_ref',
                    ], 400);
                }
            }

            // อัปเดตข้อมูล payment หลังตรวจสอบสำเร็จ
            $updateData = [
                'id' => $resultdata->id,
                'user_id' => $user->id,
                'plan_id' => $plan_id,
                'amount' => $slipAmount,
                'note' => $verify_result['data']['note'] ?? '',
                'status' => 'verified',
                'ref_id' => $refId,
                'slip_url' => $path,
                'verified_by' => null, // auto verified
                'verified_at' => now(),
            ];

            $updateResult = $this->paymentManage->updateSlipData($updateData); // เพิ่ม $this->

            // สร้าง subscription
            $subscriptionResult = $this->SubscriptionManage->storeSubscriptionData($updateData); // เพิ่ม $this->

            if (!$subscriptionResult) {
                return response()->json([
                    'success' => false,
                    'message' => 'ไม่สามารถสร้างการสมัครสมาชิกได้ กรุณาติดต่อผู้ดูแลระบบ',
                    'data' => 'subscription_failed',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'ตรวจสอบสลิปสำเร็จ บัญชีของคุณได้รับการอัปเกรดแล้ว',
                'data' => [
                    'payment_id' => $resultdata->id,
                    'amount' => $slipAmount,
                    'plan_name' => $plan->name,
                    'status' => 'verified'
                ],
            ], 200);

        } catch (\Exception $e) {
            Log::error('CheckSlip error', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // ลบไฟล์ที่อัปโหลดถ้ามี error
            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในระบบ กรุณาลองใหม่',
                'data' => 'system_error',
            ], 500);
        }
    }
}
