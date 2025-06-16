<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
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

        $checkout = $user->newSubscription('default', $priceId)
            ->checkout([
                'success_url' => route('dashboard') . '?checkout=success',
                'cancel_url' => url()->previous(),
            ]);

        return response()->json(['url' => $checkout->url]);
    }
}
