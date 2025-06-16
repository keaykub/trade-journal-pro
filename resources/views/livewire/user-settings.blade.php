<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 transition-colors">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">ตั้งค่าบัญชี</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-300">จัดการข้อมูลส่วนตัวและการตั้งค่าการใช้งาน</p>
        </div>

        <!-- Success/Error Messages -->
        @if (session()->has('message'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400 dark:text-green-300"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400 dark:text-red-300"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200 dark:border-gray-700 mb-8">
            <nav class="-mb-px flex space-x-8">
                <button wire:click="$set('activeTab', 'profile')"
                        class="py-2 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'profile' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                    <i class="fas fa-user mr-2"></i>ข้อมูลส่วนตัว
                </button>
                <button wire:click="$set('activeTab', 'trading')"
                        class="py-2 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'trading' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                    <i class="fas fa-chart-line mr-2"></i>การเทรด
                </button>
                <button wire:click="$set('activeTab', 'notifications')"
                        class="py-2 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'notifications' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                    <i class="fas fa-bell mr-2"></i>การแจ้งเตือน
                </button>
                <button wire:click="$set('activeTab', 'security')"
                        class="py-2 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'security' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                    <i class="fas fa-shield-alt mr-2"></i>ความปลอดภัย
                </button>
                <button wire:click="$set('activeTab', 'subscriptions')"
                        class="py-2 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'subscriptions' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                    <i class="fas fa-credit-card mr-2"></i>การสมัครสมาชิก
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">

            <!-- Profile Tab -->
            @if($activeTab === 'profile')
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">ข้อมูลส่วนตัว</h2>

                    <!-- Avatar Section (Read-only) -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">รูปโปรไฟล์</label>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <img src="{{ $user->avatar_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?: 'User') . '&color=7F9CF5&background=EBF4FF&size=128' }}"
                                     alt="Profile"
                                     class="w-20 h-20 rounded-full object-cover border-4 border-gray-100 dark:border-gray-600">
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">รูปโปรไฟล์ (ยังไม่สามารถแก้ไขได้)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Editable Fields -->
                    <form wire:submit.prevent="save">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ชื่อจริง <span class="text-red-500">*</span></label>
                                <input type="text"
                                       wire:model.defer="first_name"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 @error('first_name') border-red-500 @enderror"
                                       placeholder="กรอกชื่อจริง">
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">นามสกุล <span class="text-red-500">*</span></label>
                                <input type="text"
                                       wire:model.defer="last_name"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 @error('last_name') border-red-500 @enderror"
                                       placeholder="กรอกนามสกุล">
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Read-only Fields -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">อีเมล</label>
                                <input type="email"
                                       value="{{ $user->email }}"
                                       disabled
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">ไม่สามารถแก้ไขได้</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">เบอร์โทรศัพท์</label>
                                <input type="tel"
                                       value="{{ $user->phone ?: 'ยังไม่ได้กรอก' }}"
                                       disabled
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">ยังไม่สามารถแก้ไขได้</p>
                            </div>
                        </div>

                        <!-- Preferences (Read-only) -->
                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">เขตเวลา</label>
                                <input type="text"
                                       value="{{ $user->timezone }}"
                                       disabled
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ภาษา</label>
                                <input type="text"
                                       value="{{ $user->language === 'th' ? 'ไทย (TH)' : 'English (EN)' }}"
                                       disabled
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">รูปแบบวันที่</label>
                                <input type="text"
                                       value="{{ $user->date_format }}"
                                       disabled
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">รูปแบบเวลา</label>
                                <input type="text"
                                       value="{{ $user->time_format === '24h' ? '24 ชั่วโมง' : '12 ชั่วโมง (AM/PM)' }}"
                                       disabled
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                            </div>
                        </div>

                        <!-- Save Buttons -->
                        <div class="mt-8 flex justify-end space-x-4">
                            <button type="button"
                                    wire:click="cancel"
                                    class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                ยกเลิก
                            </button>
                            <button type="submit"
                                    wire:loading.attr="disabled"
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                <span wire:loading.remove>บันทึกการเปลี่ยนแปลง</span>
                                <span wire:loading>
                                    <i class="fas fa-spinner fa-spin mr-2"></i>กำลังบันทึก...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Trading Tab (Read-only for now) -->
            @if($activeTab === 'trading')
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">การตั้งค่าการเทรด</h2>

                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-yellow-400 dark:text-yellow-300"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-800 dark:text-yellow-200">การตั้งค่าส่วนนี้จะเปิดให้แก้ไขในอนาคต</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">สกุลเงินหลัก</label>
                            <input type="text"
                                   value="{{ $user->base_currency }}"
                                   disabled
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ขนาด Lot เริ่มต้น</label>
                            <input type="text"
                                   value="{{ $user->default_lot_size }}"
                                   disabled
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">เปอร์เซ็นต์ความเสี่ยง (%)</label>
                            <input type="text"
                                   value="{{ $user->risk_percentage }}%"
                                   disabled
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                        </div>
                    </div>
                </div>
            @endif

            <!-- Notifications Tab (Read-only for now) -->
            @if($activeTab === 'notifications')
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">การแจ้งเตือน</h2>

                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-yellow-400 dark:text-yellow-300"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-800 dark:text-yellow-200">การตั้งค่าส่วนนี้จะเปิดให้แก้ไขในอนาคต</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div>
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">การแจ้งเตือนทางอีเมล</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">รับการแจ้งเตือนสำคัญทางอีเมล</p>
                            </div>
                            <div class="text-sm {{ $user->email_notifications ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $user->email_notifications ? 'เปิดใช้งาน' : 'ปิดใช้งาน' }}
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div>
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">เตือนความจำรายวัน</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">เตือนให้บันทึกการเทรดประจำวัน</p>
                            </div>
                            <div class="text-sm {{ $user->daily_reminder ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $user->daily_reminder ? 'เปิดใช้งาน' : 'ปิดใช้งาน' }}
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div>
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">รายงานสรุปรายสัปดาห์</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">ส่งรายงานสรุปผลการเทรดทุกสัปดาห์</p>
                            </div>
                            <div class="text-sm {{ $user->weekly_report ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $user->weekly_report ? 'เปิดใช้งาน' : 'ปิดใช้งาน' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Security Tab (Read-only for now) -->
            @if($activeTab === 'security')
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">ความปลอดภัย</h2>

                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-yellow-400 dark:text-yellow-300"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-800 dark:text-yellow-200">การตั้งค่าส่วนนี้จะเปิดให้แก้ไขในอนาคต</p>
                            </div>
                        </div>
                    </div>

                    <!-- Two Factor Authentication Status -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">การยืนยันตัวตนสองขั้นตอน</h3>
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Two-Factor Authentication</span>
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $user->two_factor_enabled ? 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400' }}">
                                        {{ $user->two_factor_enabled ? 'เปิดใช้งาน' : 'ปิดใช้งาน' }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">เพิ่มความปลอดภัยให้กับบัญชีของคุณ</p>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Visibility -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">การมองเห็นโปรไฟล์</h3>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-sm font-medium text-gray-700 dark:text-gray-300">สถานะปัจจุบัน:
                                <span class="text-blue-600 dark:text-blue-400">
                                    @if($user->profile_visibility === 'private')
                                        ส่วนตัว
                                    @elseif($user->profile_visibility === 'friends')
                                        เฉพาะเพื่อน
                                    @else
                                        สาธารณะ
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Subscriptions Tab -->
            @if($activeTab === 'subscriptions')
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">การสมัครสมาชิก</h2>
                        <button wire:click="loadSubscriptions"
                                wire:loading.attr="disabled"
                                class="px-4 py-2 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors disabled:opacity-50">
                            <i class="fas fa-sync-alt mr-2" wire:loading.class="fa-spin"></i>รีเฟรช
                        </button>
                    </div>

                    @if($isLoadingSubscriptions)
                        <div class="flex items-center justify-center py-12">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-spinner fa-spin text-blue-500"></i>
                                <span class="text-gray-600 dark:text-gray-400">กำลังโหลดข้อมูล...</span>
                            </div>
                        </div>
                    @elseif(empty($subscriptions))
                        <div class="text-center py-12">
                            <i class="fas fa-credit-card text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">ยังไม่มีการสมัครสมาชิก</h3>
                            <p class="text-gray-600 dark:text-gray-400">คุณยังไม่ได้สมัครแพ็กเกจใดๆ</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($subscriptions as $subscription)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-2">
                                                <span class="inline-flex items-center bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300 px-2 py-0.5 rounded text-md font-semibold">
                                                    <i class="fas fa-crown mr-1"></i> {{  $this->getPlanDisplayName($subscription) ?? ucfirst($subscription['name']) . ' Plan' }}
                                                </span>
                                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $this->getSubscriptionStatusClass($subscription) }}">
                                                    {{ $this->getSubscriptionStatusText($subscription) }}
                                                </span>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600 dark:text-gray-400">
                                                <div>
                                                    <span class="font-medium">ราคา:</span> {{ $this->getPriceSubscription($subscription) }}
                                                </div>
                                                <div>
                                                    <span class="font-medium">จำนวน:</span> {{ $subscription['quantity'] }}
                                                </div>
                                                <div>
                                                    <span class="font-medium">วันที่สมัคร:</span>
                                                    {{ \Carbon\Carbon::parse($subscription['created_at'])->locale('th')->format('j M Y') }}
                                                </div>

                                                @if($subscription['trial_ends_at'])
                                                    <div>
                                                        <span class="font-medium">ทดลองใช้ถึง:</span>
                                                        {{ \Carbon\Carbon::parse($subscription['trial_ends_at'])->locale('th')->format('j M Y H:i') }}
                                                    </div>
                                                @endif

                                                @if($subscription['ends_at'])
                                                    <div>
                                                        <span class="font-medium">
                                                            @if($subscription['on_grace_period'])
                                                                วันหมดอายุ:
                                                            @else
                                                                ยกเลิกเมื่อ:
                                                            @endif
                                                        </span>
                                                        {{ \Carbon\Carbon::parse($subscription['ends_at'])->locale('th')->format('j M Y H:i') }}
                                                    </div>
                                                @endif
                                            </div>

                                            @if($subscription['on_grace_period'])
                                                <div class="mt-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-info-circle text-yellow-500 mr-2"></i>
                                                        <span class="text-sm text-yellow-800 dark:text-yellow-200">
                                                            การสมัครสมาชิกนี้จะสิ้นสุดวันที่ {{ \Carbon\Carbon::parse($subscription['ends_at'])->locale('th')->format('j M Y H:i') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex flex-col space-y-2 ml-4">
                                            @if($subscription['active'] && !$subscription['on_grace_period'])
                                                <button wire:click="cancelSubscription({{ $subscription['id'] }})"
                                                        wire:loading.attr="disabled"
                                                        class="px-4 py-2 text-sm bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors disabled:opacity-50"
                                                        onclick="return confirm('คุณแน่ใจหรือไม่ที่จะยกเลิกการสมัครสมาชิกนี้?')">
                                                    <i class="fas fa-times mr-1"></i>ยกเลิก
                                                </button>
                                            @elseif($subscription['on_grace_period'])
                                                <button wire:click="resumeSubscription({{ $subscription['id'] }})"
                                                        wire:loading.attr="disabled"
                                                        class="px-4 py-2 text-sm bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors disabled:opacity-50">
                                                    <i class="fas fa-undo mr-1"></i>กู้คืน
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
