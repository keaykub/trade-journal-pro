<div class="relative" x-data="{ open: false }" @click.outside="open = false">
    <!-- Notification Button -->
    <button
        @click="open = !open; $wire.fetchNotifications()"
        class="relative p-3 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-all duration-200 group"
        :class="open ? 'bg-slate-100 dark:bg-slate-700/50' : ''"
    >
        <!-- Bell Icon with Animation -->
        <i class="fas fa-bell text-lg transition-transform duration-200 group-hover:scale-110"
           :class="open ? 'text-blue-600 dark:text-blue-400' : ''"></i>

        <!-- Notification Badge -->
        @if(auth()->user()->isFree())
            <span class="absolute -top-1 -right-1 flex h-5 w-5">
                {{-- <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-5 w-5 bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-xs font-bold items-center justify-center shadow-lg">
                    3
                </span> --}}
            </span>
        @endif
    </button>

    <!-- Notification Dropdown -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 translate-y-1"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-1"
        class="absolute right-0 mt-3 w-80 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl z-50 overflow-hidden backdrop-blur-lg">

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-700/50 dark:to-slate-600/50 px-6 py-4 border-b border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <h4 class="font-bold text-slate-800 dark:text-white flex items-center">
                    <i class="fas fa-bell mr-2 text-blue-600 dark:text-blue-400"></i>
                    การแจ้งเตือน
                </h4>
                <span class="text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-2 py-1 rounded-full font-medium">
                    ใหม่ 3
                </span>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto">
            @forelse($notifications as $index => $note)
                <div class="group hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-all duration-200 {{ $index === 0 ? '' : 'border-t border-slate-100 dark:border-slate-700' }}">
                    <div class="p-4">
                        <div class="flex items-start gap-3">
                            <!-- Icon -->
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center shadow-lg">
                                    <i class="fas fa-rocket text-white text-sm"></i>
                                    {{-- @if($note['type'] === 'upgrade')
                                        <i class="fas fa-crown text-white text-sm"></i>
                                    @elseif($note['type'] === 'feature')
                                        <i class="fas fa-star text-white text-sm"></i>
                                    @elseif($note['type'] === 'update')
                                        <i class="fas fa-rocket text-white text-sm"></i>
                                    @else
                                        <i class="fas fa-bell text-white text-sm"></i>
                                    @endif --}}
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between mb-1">
                                    <h5 class="font-semibold text-slate-800 dark:text-white text-sm leading-5">
                                        {{ $note['title'] }}
                                    </h5>
                                    @if($note['new'] ?? false)
                                        <span class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full"></span>
                                    @endif
                                </div>

                                <p class="text-sm text-slate-600 dark:text-slate-300 mb-2 leading-relaxed">
                                    {{ $note['message'] ?? 'ข้อความแจ้งเตือน' }}
                                </p>

                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-slate-500 dark:text-slate-400 flex items-center">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $note['time'] }}
                                    </span>

                                    @if($note['action'] ?? false)
                                        <button class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium transition-colors duration-200">
                                            {{ $note['action'] }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bell-slash text-2xl text-slate-400"></i>
                    </div>
                    <h5 class="font-semibold text-slate-600 dark:text-slate-300 mb-2">ยังไม่มีการแจ้งเตือน</h5>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        เมื่อมีข้อมูลใหม่จะแสดงที่นี่
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Footer -->
        @if($notifications && count($notifications) > 0)
            <div class="bg-slate-50 dark:bg-slate-700/30 px-6 py-3 border-t border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <button class="text-sm text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors duration-200">
                        ทำเครื่องหมายว่าอ่านทั้งหมด
                    </button>
                    <button class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium transition-colors duration-200">
                        ดูทั้งหมด
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
