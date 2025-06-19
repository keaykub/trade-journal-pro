<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9ก-๙]+$/' // อนุญาตเฉพาะตัวอักษรภาษาอังกฤษ, ตัวเลข, ตัวอักษรไทย (ห้ามช่องว่าง)
            ],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.regex' => 'ชื่อผู้ใช้งานสามารถใช้ได้เฉพาะตัวอักษรและตัวเลขเท่านั้น'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        // ส่งอีเมลยืนยันทันทีหลัง create user
        $user->sendEmailVerificationNotification();

        event(new Registered($user));
        Auth::login($user);

        // ไปหน้า verification เสมอ (เพราะ user ใหม่ยังไม่ได้ verify)
        $this->redirect(route('verification.notice'), navigate: true);
    }
}; ?>
<div class="w-full max-w-sm">
    <!-- Register Card -->
    <div class="login-card rounded-2xl shadow-2xl p-6">
        <!-- Header with Logo -->
        <div class="text-center mb-8">
            <div class="inline-block">
                <a href="{{ route('home') }}">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <img src="{{ asset('logo/logo-40-40.png') }}" alt="WickFill Logo" class="w-12 h-12 object-contain" />
                    </div>
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">สร้างบัญชีใหม่</h1>
            <p class="text-gray-600">เริ่มต้นการเทรดอย่างมืออาชีพ</p>
        </div>

        <div class="space-y-3 mb-6">
            <a href="{{ route('login.google') }}"
            class="w-full flex items-center justify-center gap-3 bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 font-medium hover:bg-gray-100 shadow-sm">
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

        <!-- Registration Form -->
        <form wire:submit="register" class="space-y-4">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">ชื่อผู้ใช้</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400 text-sm"></i>
                    </div>
                    <input
                        wire:model="name"
                        type="text"
                        id="name"
                        name="name"
                        autocomplete="name"
                        required
                        autofocus
                        class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all text-sm"
                        placeholder="ชื่อผู้ใช้"
                    />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-500" />
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">อีเมล</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400 text-sm"></i>
                    </div>
                    <input
                        wire:model="email"
                        type="email"
                        id="email"
                        name="email"
                        autocomplete="username"
                        required
                        class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all text-sm"
                        placeholder="Email"
                    />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-500" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">รหัสผ่าน</label>
                <div class="relative" x-data="{ showPassword: false }">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400 text-sm"></i>
                    </div>
                    <input
                        wire:model="password"
                        :type="showPassword ? 'text' : 'password'"
                        id="password"
                        name="password"
                        autocomplete="new-password"
                        required
                        class="w-full pl-9 pr-10 py-2.5 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all text-sm"
                        placeholder="รหัสผ่าน"
                    />
                    <button type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-gray-400 hover:text-gray-600 text-sm"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-500" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">ยืนยันรหัสผ่าน</label>
                <div class="relative" x-data="{ showConfirmPassword: false }">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-shield-alt text-gray-400 text-sm"></i>
                    </div>
                    <input
                        wire:model="password_confirmation"
                        :type="showConfirmPassword ? 'text' : 'password'"
                        id="password_confirmation"
                        name="password_confirmation"
                        autocomplete="new-password"
                        required
                        class="w-full pl-9 pr-10 py-2.5 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all text-sm"
                        placeholder="ยืนยันรหัสผ่าน"
                    />
                    <button type="button"
                            @click="showConfirmPassword = !showConfirmPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-gray-400 hover:text-gray-600 text-sm"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-500" />
            </div>

            <!-- Terms and Privacy -->
            <div class="flex items-start">
                <input type="checkbox"
                       id="terms"
                       required
                       class="h-3.5 w-3.5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-0.5">
                <label for="terms" class="ml-2 text-xs text-gray-600">
                    ฉันยอมรับ
                    <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">เงื่อนไขการใช้งาน</a>
                    และ
                    <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">นโยบายความเป็นส่วนตัว</a>
                </label>
            </div>

            <!-- Register Button -->
            <button
                type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-2.5 px-4 rounded-lg transition-all transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:opacity-70 disabled:transform-none disabled:hover:scale-100 disabled:cursor-not-allowed"
                wire:loading.attr="disabled"
                wire:loading.class="loading-pulse"
            >
                <!-- Default State -->
                <span class="flex items-center justify-center gap-2 text-sm" wire:loading.remove wire:target="register">
                    <i class="fas fa-user-plus"></i>
                    สร้างบัญชี
                </span>

                <!-- Loading State -->
                <span class="flex items-center justify-center gap-2 text-sm" wire:loading wire:target="register">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>
        </form>

        <!-- Login Link -->
        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">
                มีบัญชีอยู่แล้ว?
                <a href="{{ route('login') }}" wire:navigate class="text-blue-600 hover:text-blue-700 font-semibold">
                    เข้าสู่ระบบ
                </a>
            </p>
        </div>
    </div>
</div>
