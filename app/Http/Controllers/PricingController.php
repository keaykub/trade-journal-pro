<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\PublicPage\PaymentManage;
use App\Models\PublicPage\SubscriptionManage;
use App\Services\EasySlipService;
use App\Services\HelperService;

class PricingController extends Controller
{
    protected $easySlipService;
    protected $helperService;
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

        $path = $request->file('slip_image')->store('slips', 'public');
        $plan_id = $request->input('plan_id');
        $payment_method = $request->input('payment_method');

        if (!$path || !$plan_id || !$payment_method) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        $fullPath = storage_path('app/public/' . $path);
        $base64 = $this->helperService->imageToBase64($fullPath);

        if (!$base64) {
            return response()->json(['error' => 'Failed to convert image to base64'], 500);
        }

        $data = [
            'user_id' => $user->id,
            'plan_id' => $plan_id,
            'slip_path' => $path,
            'status' => 'pending',
        ];
        $resultdata = paymentManage::storeSlipData($data);

        $verify_result = $this->easySlipService->verifySlip($base64);
        if (!$verify_result || ($verify_result['status'] ?? 0) !== 200) {
            //show error message to users
            Log::warning('EasySlip verification failed', [
                'user_id' => $user->id,
                'slip_path' => $path,
                'base64_length' => strlen($base64),
            ]);
        }else {
            $result = $this->easySlipService->isValidSlip($verify_result);
            $data = [
                'id'            => $resultdata->id,
                'user_id'       => $user->id,
                'plan_id'       => $plan_id,
                'amount'        => $result['amount'] ?? 0.0,
                'note'          => $verify_result['note'] ?? '',
                'status'        => 'verified',
                'ref_id'        => $result['transRef'] ?? null,
                'slip_url'      => $path,
                'verified_by'   => null,
                'verified_at'   => now(),
            ];

            $result = paymentManage::updateSlipData($data);
            $result = SubscriptionManage::storeSubscriptionData($data);
            if (!$result) {
                return response()->json([
                    'success' => false,
                    'message' => 'repeat slip upload',
                    'data' => 'error',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Slip verified successfully',
                'data' => 'success',
            ], 200);
        }
    }
}
