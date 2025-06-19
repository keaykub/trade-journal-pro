<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';
    public bool $isLoading = false;

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->isLoading = true;

        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            $this->isLoading = false;
            return;
        }

        $this->reset('email');
        $this->isLoading = false;
        session()->flash('status', __($status));
    }
}; ?>

<div class="w-full max-w-md mx-auto">
    <div class="login-card rounded-2xl shadow-2xl p-8 transform transition-all duration-300 hover:shadow-3xl">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="mx-auto w-16 h-16 bg-gradient-to-r from-purple-500 to-blue-500 rounded-full flex items-center justify-center mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">ลืมรหัสผ่าน?</h2>
            <p class="text-gray-600 text-sm leading-relaxed">
                ไม่ต้องกังวล! เพียงกรอกอีเมลของคุณ<br>
                และเราจะส่งลิงก์รีเซ็ตรหัสผ่านให้คุณ
            </p>
        </div>

        <!-- Success Message -->
        @if (session('status'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-green-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-green-800 text-sm font-medium">ส่งลิงก์เรียบร้อยแล้ว!</p>
                    <p class="text-green-700 text-xs mt-1">
                        กรุณาตรวจสอบอีเมลของคุณและคลิกลิงก์เพื่อรีเซ็ตรหัสผ่าน
                    </p>
                </div>
            </div>
        @endif

        <form wire:submit="sendPasswordResetLink" class="space-y-6">
            <!-- Email Input -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-semibold text-gray-700 flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </svg>
                    อีเมล
                </label>
                <div class="relative">
                    <input
                        wire:model="email"
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        placeholder="กรอกอีเมลของคุณ"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200 bg-white bg-opacity-80 backdrop-blur-sm text-gray-800 placeholder-gray-400 hover:border-gray-400 transform hover:-translate-y-0.5"
                        :class="@error('email') 'border-red-500 focus:ring-red-500 focus:border-red-500' @enderror"
                    />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                @error('email')
                    <div class="flex items-center space-x-2 text-red-600 text-sm mt-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none disabled:hover:shadow-none flex items-center justify-center space-x-2"
            >
                <div wire:loading.remove wire:target="sendPasswordResetLink" class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                    </svg>
                    <span>ส่งลิงก์รีเซ็ตรหัสผ่าน</span>
                </div>
                <div wire:loading wire:target="sendPasswordResetLink" class="flex items-center space-x-2">
                    <svg class="animate-spin w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </button>
        </form>

        <!-- Divider -->
        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500">หรือ</span>
            </div>
        </div>

        <!-- Back to Login -->
        <div class="text-center space-y-4">
            <a
                href="{{ route('login') }}"
                class="inline-flex items-center space-x-2 text-purple-600 hover:text-purple-800 font-medium text-sm transition duration-200 hover:underline group"
            >
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                </svg>
                <span>กลับไปหน้าเข้าสู่ระบบ</span>
            </a>

            <div class="text-xs text-gray-500">
                ยังไม่มีบัญชี?
                <a href="{{ route('register') }}" class="text-purple-600 hover:text-purple-800 font-medium hover:underline transition duration-200">
                    สมัครสมาชิก
                </a>
            </div>
        </div>

        <!-- Help Section -->
        <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <div class="flex items-start space-x-3">
                <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div class="text-xs text-blue-800">
                    <p class="font-medium mb-1">ไม่ได้รับอีเมล?</p>
                    <ul class="space-y-1 text-blue-700">
                        <li class="flex items-center space-x-2">
                            <span class="w-1 h-1 bg-blue-600 rounded-full"></span>
                            <span>ตรวจสอบโฟลเดอร์ Spam/Junk</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="w-1 h-1 bg-blue-600 rounded-full"></span>
                            <span>ตรวจสอบว่าอีเมลถูกต้อง</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="w-1 h-1 bg-blue-600 rounded-full"></span>
                            <span>รอสักครู่แล้วลองใหม่</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
