<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Subscription;
use Stripe\Stripe;
use Stripe\Subscription as StripeSubscription;

class UserSettings extends Component
{
    public $activeTab = 'profile';

    // Editable fields
    public $first_name;
    public $last_name;

    // Read-only display fields
    public $user;
    public $isLoading = false;

    // Subscription related
    public $subscriptions = [];
    public $isLoadingSubscriptions = false;

    protected $rules = [
        'first_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'first_name.max' => 'ชื่อจริงต้องมีความยาวไม่เกิน 255 ตัวอักษร',
        'last_name.max' => 'นามสกุลต้องมีความยาวไม่เกิน 255 ตัวอักษร',
    ];

    public function mount()
    {
        if (!auth()->user()?->hasVerifiedEmail()) {
            redirect()->route('verification.notice');
        }

        $this->user = Auth::user();
        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;

        // Load subscriptions when component mounts
        $this->loadSubscriptions();
    }

    public function save()
    {
        $this->isLoading = true;

        try {
            $this->validate();

            $this->user->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
            ]);

            // Refresh user data
            $this->user->refresh();

            session()->flash('message', 'บันทึกข้อมูลเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            session()->flash('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล กรุณาลองใหม่อีกครั้ง');
        } finally {
            $this->isLoading = false;
        }
    }

    public function cancel()
    {
        // Reset to original values
        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;

        // Clear validation errors
        $this->resetErrorBag();
    }

    public function loadSubscriptions()
    {
        $this->isLoadingSubscriptions = true;

        try {
            // Get all subscriptions for the user
            $this->subscriptions = $this->user->subscriptions()
                ->with(['items'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($subscription) {
                    return [
                        'id' => $subscription->id,
                        'stripe_id' => $subscription->stripe_id,
                        'name' => $subscription->name,
                        'stripe_status' => $subscription->stripe_status,
                        'stripe_price' => $subscription->stripe_price,
                        'quantity' => $subscription->quantity,
                        'trial_ends_at' => $subscription->trial_ends_at,
                        'ends_at' => $subscription->ends_at,
                        'created_at' => $subscription->created_at,
                        'updated_at' => $subscription->updated_at,
                        'canceled_at' => $subscription->ends_at && !$subscription->onGracePeriod() ? $subscription->ends_at : null,
                        'on_grace_period' => $subscription->onGracePeriod(),
                        'active' => $subscription->active(),
                        'canceled' => $subscription->canceled(),
                        'on_trial' => $subscription->onTrial(),
                        'past_due' => $subscription->pastDue(),
                    ];
                })->toArray();

        } catch (\Exception $e) {
            session()->flash('error', 'ไม่สามารถโหลดข้อมูลการสมัครสมาชิกได้');
            $this->subscriptions = [];
        } finally {
            $this->isLoadingSubscriptions = false;
        }
    }

    public function cancelSubscription($subscriptionId)
    {
        try {
            $subscription = $this->user->subscriptions()->where('id', $subscriptionId)->first();

            if (!$subscription) {
                session()->flash('error', 'ไม่พบการสมัครสมาชิกนี้');
                return;
            }

            if ($subscription->canceled()) {
                session()->flash('error', 'การสมัครสมาชิกนี้ถูกยกเลิกแล้ว');
                return;
            }

            // Cancel the subscription (will continue until period ends)
            $subscription->cancel();

            session()->flash('message', 'ยกเลิกการสมัครสมาชิกเรียบร้อยแล้ว คุณสามารถใช้งานได้จนถึงวันหมดอายุ');

            // Reload subscriptions
            $this->loadSubscriptions();

        } catch (\Exception $e) {
            session()->flash('error', 'เกิดข้อผิดพลาดในการยกเลิกการสมัครสมาชิก: ' . $e->getMessage());
        }
    }

    public function resumeSubscription($subscriptionId)
    {
        try {
            $subscription = $this->user->subscriptions()->where('id', $subscriptionId)->first();

            if (!$subscription) {
                session()->flash('error', 'ไม่พบการสมัครสมาชิกนี้');
                return;
            }

            if (!$subscription->onGracePeriod()) {
                session()->flash('error', 'ไม่สามารถกู้คืนการสมัครสมาชิกนี้ได้');
                return;
            }

            // Resume the subscription
            $subscription->resume();

            session()->flash('message', 'กู้คืนการสมัครสมาชิกเรียบร้อยแล้ว');

            // Reload subscriptions
            $this->loadSubscriptions();

        } catch (\Exception $e) {
            session()->flash('error', 'เกิดข้อผิดพลาดในการกู้คืนการสมัครสมาชิก: ' . $e->getMessage());
        }
    }

    public function getSubscriptionStatusText($subscription)
    {
        if ($subscription['on_trial']) {
            return 'ทดลองใช้';
        } elseif ($subscription['past_due']) {
            return 'ค้างชำระ';
        } elseif ($subscription['canceled']) {
            return 'ยกเลิกแล้ว';
        } elseif ($subscription['on_grace_period']) {
            return 'กำลังยกเลิก';
        } elseif ($subscription['active']) {
            return 'กำลังใช้งาน';
        } else {
            return 'ไม่ทราบสถานะ';
        }
    }

    public function getSubscriptionStatusClass($subscription)
    {
        if ($subscription['on_trial']) {
            return 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400';
        } elseif ($subscription['past_due']) {
            return 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400';
        } elseif ($subscription['canceled']) {
            return 'bg-gray-100 dark:bg-gray-900/30 text-gray-600 dark:text-gray-400';
        } elseif ($subscription['on_grace_period']) {
            return 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400';
        } elseif ($subscription['active']) {
            return 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400';
        } else {
            return 'bg-gray-100 dark:bg-gray-900/30 text-gray-600 dark:text-gray-400';
        }
    }

    public function getPlanDisplayName($subscription)
    {
        $priceId = $subscription['stripe_price'] ?? '';

        $planNames = [
            'price_1RaIueCZi1bmUwYslJWl6shH' => 'ProPlan รายเดือน',
            'price_yyy' => 'Premium Plan รายปี',
        ];

        return $planNames[$priceId] ?? 'แผนการสมัครสมาชิก';
    }

    public function getPriceSubscription($subscription)
    {
        $priceId = $subscription['stripe_price'] ?? '';

        $prices = [
            'price_1RaIueCZi1bmUwYslJWl6shH' => '249 บาท/ เดือน', // ProPlan รายเดือน
            'price_yyy' => 2990, // Premium Plan รายปี
        ];

        return $prices[$priceId] ?? 0;
    }

    public function render()
    {
        view()->share([
            'title' => 'การตั้งค่าผู้ใช้',
            'description' => 'ปรับแต่งการตั้งค่าบัญชีของคุณ',
        ]);

        return view('livewire.user-settings')
            ->layout('layouts.main');
    }
}
