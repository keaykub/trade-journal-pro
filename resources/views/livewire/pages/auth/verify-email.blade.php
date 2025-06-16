<?php

use App\Livewire\Actions\Logout;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public int $cooldownTime = 0;
    public bool $isLoading = false;

    public function mount()
    {
        // ตรวจสอบ cooldown จาก session
        $lastSent = Session::get('email_verification_last_sent');
        if ($lastSent) {
            $timePassed = now()->diffInSeconds($lastSent);
            $this->cooldownTime = max(0, 60 - $timePassed);
        }
    }

    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        // ตรวจสอบว่ายังอยู่ในช่วง cooldown หรือไม่
        if ($this->cooldownTime > 0) {
            return;
        }

        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);
            return;
        }

        $this->isLoading = true;

        try {
            Auth::user()->sendEmailVerificationNotification();
            Session::flash('status', 'verification-link-sent');

            // บันทึกเวลาที่ส่งล่าสุด
            Session::put('email_verification_last_sent', now());

            // เริ่ม cooldown 60 วินาที
            $this->cooldownTime = 60;

            // ⭐ เพิ่มบรรทัดนี้ - dispatch event เพื่อเริ่ม countdown
            $this->dispatch('email-sent');

        } catch (\Exception $e) {
            Session::flash('error', 'เกิดข้อผิดพลาดในการส่งอีเมล กรุณาลองใหม่อีกครั้ง');
        }

        $this->isLoading = false;
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }

    public function decrementCooldown(): void
    {
        if ($this->cooldownTime > 0) {
            $this->cooldownTime--;
        }
    }
}; ?>

<div class="w-full max-w-md mx-auto" x-data="{
    cooldownInterval: null,
    startCountdown() {
        if (this.cooldownInterval) clearInterval(this.cooldownInterval);
        this.cooldownInterval = setInterval(() => {
            if ($wire.cooldownTime > 0) {
                $wire.call('decrementCooldown');
            } else {
                clearInterval(this.cooldownInterval);
                this.cooldownInterval = null;
            }
        }, 1000);
    }
}" x-init="
    if ($wire.cooldownTime > 0) {
        startCountdown();
    }

    $wire.on('email-sent', () => {
        console.log('Email sent, starting countdown...');
        startCountdown();
    });
">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="login-card rounded-2xl shadow-2xl p-6">
        <!-- Header -->
        <div class="text-center mb-6">
            <div class="inline-block">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-envelope-circle-check text-white text-lg"></i>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-1">ยืนยันอีเมลของคุณ</h1>
            <p class="text-gray-600 text-sm">กรุณาตรวจสอบอีเมลของคุณ</p>
        </div>

        <!-- Message -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400 text-lg"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        ขอบคุณที่สมัครสมาชิก! ก่อนเริ่มใช้งาน กรุณายืนยันที่อยู่อีเมลของคุณโดยคลิกลิงก์ที่เราส่งไปให้ที่
                    </p>
                    <p class="font-medium text-blue-800 mt-1">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 font-medium">
                            ส่งลิงก์ยืนยันใหม่แล้ว! กรุณาตรวจสอบอีเมลของคุณ
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-medium">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="space-y-4">
            <button wire:click="sendVerification"
                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-2.5 px-4 rounded-lg transition-all transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:opacity-50 disabled:transform-none disabled:hover:scale-100 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled"
                    :disabled="$wire.cooldownTime > 0">

                <!-- Default State -->
                <span class="flex items-center justify-center gap-2 text-sm"
                      wire:loading.remove wire:target="sendVerification"
                      x-show="$wire.cooldownTime === 0">
                    <i class="fas fa-paper-plane"></i>
                    ส่งอีเมลยืนยันอีกครั้ง
                </span>

                <!-- Loading State -->
                <span class="flex items-center justify-center gap-2 text-sm"
                      wire:loading wire:target="sendVerification">
                    <i class="fas fa-spinner fa-spin text-white"></i>
                    กำลังส่งอีเมล...
                </span>

                <!-- Cooldown State -->
                <span class="flex items-center justify-center gap-2 text-sm"
                      x-show="$wire.cooldownTime > 0"
                      x-cloak>
                    <i class="fas fa-clock"></i>
                    ส่งอีกครั้งได้ในอีก <span x-text="$wire.cooldownTime"></span> วินาที
                </span>
            </button>

            <!-- Cooldown Message -->
            <div x-show="$wire.cooldownTime > 0"
                 x-cloak
                 class="text-center">
                <p class="text-xs text-gray-500">
                    เพื่อป้องกันการส่งซ้ำ กรุณารอ <span x-text="$wire.cooldownTime" class="font-semibold text-gray-700"></span> วินาที
                </p>
            </div>

            <div class="text-center">
                <button wire:click="logout"
                        class="text-sm text-gray-500 hover:text-gray-700 underline">
                    ออกจากระบบ
                </button>
            </div>
        </div>

        <!-- Tips -->
        <div class="mt-6 bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-600">
                <strong>เคล็ดลับ:</strong> ถ้าไม่เจออีเมล กรุณาตรวจสอบในโฟลเดอร์ Spam หรือ Junk Mail ด้วยครับ
            </p>
        </div>
    </div>
</div>
