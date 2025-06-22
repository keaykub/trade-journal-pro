<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\URL;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class SubscriptionController extends Controller
{
    /* public function redirectToStripeCheckout(Request $request)
    {
        $user = $request->user();
        $plan = $request->input('plan');

        // ถ้ามี subscription และยัง active → ส่งไป dashboard เลย
        if ($user->subscribed('default') && $user->subscription('default')->valid()) {
            return response()->json([
                'error' => 'คุณมีการสมัครสมาชิกอยู่แล้ว',
                'redirect' => route('dashboard')
            ], 200);
        }

        $priceId = match ($plan) {
            'pro' => 'price_1RaIueCZi1bmUwYslJWl6shH',
            default => abort(400, 'Invalid plan'),
        };

        $checkout = $user->newSubscription('default', $priceId)
            ->checkout([
                'success_url' => route('dashboard') . '?checkout=success',
                'cancel_url' => url()->previous(),
            ]);

        return response()->json(['url' => $checkout->url]);
    } */

    public function redirectToStripeCheckout(Request $request)
    {
        $user = $request->user();
        $plan = $request->input('plan');

        // ถ้ามี subscription และยัง active → ส่งไป dashboard เลย
        if ($user->subscribed('default') && $user->subscription('default')->valid()) {
            return response()->json([
                'error' => 'คุณมีการสมัครสมาชิกอยู่แล้ว',
                'redirect' => route('dashboard')
            ], 200);
        }

        $priceId = match ($plan) {
            'pro' => 'price_1RaIueCZi1bmUwYslJWl6shH',
            default => abort(400, 'Invalid plan'),
        };

        // ตั้งค่า API key ของ Stripe
        Stripe::setApiKey(config('cashier.secret'));

        // สร้าง Checkout Session แบบกำหนด allow_promotion_codes
        $session = StripeSession::create([
            'customer' => $user->stripe_id, // ถ้ายังไม่มี สามารถไม่ใส่ได้
            'mode' => 'subscription',
            'line_items' => [[
                'price' => $priceId,
                'quantity' => 1,
            ]],
            'allow_promotion_codes' => true, // ✅ เปิดให้ใส่โค้ดลดราคาที่หน้า Checkout
            'success_url' => route('dashboard') . '?checkout=success',
            'cancel_url' => URL::previous(),
        ]);

        return response()->json(['url' => $session->url]);
    }
}
