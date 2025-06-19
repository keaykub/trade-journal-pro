<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

<div class="w-full max-w-md">
    <!-- Login Card -->
    <div class="login-card rounded-2xl shadow-2xl p-8">
        <!-- Header with Logo -->
        <div class="text-center mb-8">
            <div class="inline-block">
                <a href="{{ route('home') }}">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <img src="{{ asset('logo/logo-40-40.png') }}" alt="WickFill Logo" class="w-12 h-12 object-contain" />
                    </div>
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">ยินดีต้อนรับกลับ</h1>
            <p class="text-gray-600">เข้าสู่ระบบเพื่อจัดการบัญชีของคุณ</p>
        </div>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Social Login -->
        <div class="space-y-3 mb-6">
            <a href="{{ route('login.google') }}"
            class="w-full flex items-center justify-center gap-3 bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 font-medium hover:bg-gray-100">
                <img src="https://developers.google.com/identity/images/g-logo.png"
                    alt="Google logo"
                    class="w-5 h-5" />
                เข้าสู่ระบบด้วย Google
            </a>
        </div>

        <!-- Divider -->
        <div class="relative mb-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">หรือ</span>
            </div>
        </div>

        <!-- Login Form -->
        <form wire:submit="login" class="space-y-6">
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">อีเมล</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input
                        wire:model="form.email"
                        type="email"
                        id="email"
                        autocomplete="username"
                        required
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all"
                        placeholder="Email"
                    />
                </div>
                <x-input-error :messages="$errors->get('form.email')" class="mt-1 text-sm text-red-500" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">รหัสผ่าน</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input
                        wire:model="form.password"
                        type="password"
                        id="password"
                        autocomplete="current-password"
                        required
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all"
                        placeholder="Password"
                    />
                </div>
                <x-input-error :messages="$errors->get('form.password')" class="mt-1 text-sm text-red-500" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input
                        wire:model="form.remember"
                        type="checkbox"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    />
                    <span class="ml-2 text-sm text-gray-600">จดจำฉัน</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" wire:navigate
                       class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        ลืมรหัสผ่าน?
                    </a>
                @endif
            </div>

            <!-- Login Button with Loading Animation -->
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3 px-4 rounded-lg transition-all transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none"
            >
                <!-- Default State -->
                <span wire:loading.remove wire:target="login" class="flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i>
                    เข้าสู่ระบบ
                </span>

                <!-- Loading State -->
                <span wire:loading wire:target="login" class="flex items-center justify-center gap-2">
                    <i class="fas fa-spinner fa-spin text-white"></i>
                    กำลังเข้าสู่ระบบ...
                </span>
            </button>
        </form>

        <!-- Sign Up Link -->
        <div class="mt-8 text-center">
            <p class="text-gray-600">
                ยังไม่มีบัญชี?
                <a href="{{ route('register') }}" wire:navigate class="text-blue-600 hover:text-blue-700 font-semibold">
                    สมัครใช้งานฟรี
                </a>
            </p>
        </div>
    </div>
</div>
