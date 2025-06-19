<div class="min-h-screen dark:from-slate-900 dark:via-slate-800 dark:to-slate-900"
    x-data="{
    showStats: window.innerWidth >= 1024,
    showFilters: window.innerWidth >= 1024,
    isMobile: window.innerWidth < 1024
    }"
    x-init="
    $watch('isMobile', value => {
        if (!value) {
            // Desktop: แสดงทั้งคู่
            showStats = true;
            showFilters = true;
        } else {
            // Mobile: ซ่อนทั้งคู่
            showStats = false;
            showFilters = false;
        }
    });
    window.addEventListener('resize', () => {
        const newIsMobile = window.innerWidth < 1024;
        if (newIsMobile !== isMobile) {
            isMobile = newIsMobile;
        }
    });
    ">
    <div class="max-w-7xl mx-auto px-4 py-4">
        <!-- Mobile Toggle Buttons -->
        <div class="lg:hidden mb-6 flex space-x-3">
            <button @click="showStats = !showStats"
                    class="flex-1 flex items-center justify-center px-4 py-3 rounded-xl transition-all duration-300"
                    :class="showStats ? 'bg-blue-600 text-white shadow-lg' : 'bg-white/70 dark:bg-slate-800/70 text-slate-700 dark:text-slate-300'">
                <i class="fas fa-chart-bar mr-2"></i>
                <span>สถิติ</span>
                <i class="fas fa-chevron-down ml-2 transition-transform duration-300" :class="showStats ? 'rotate-180' : ''"></i>
            </button>

            <button @click="showFilters = !showFilters"
                    class="flex-1 flex items-center justify-center px-4 py-3 rounded-xl transition-all duration-300"
                    :class="showFilters ? 'bg-purple-600 text-white shadow-lg' : 'bg-white/70 dark:bg-slate-800/70 text-slate-700 dark:text-slate-300'">
                <i class="fas fa-filter mr-2"></i>
                <span>ฟิลเตอร์</span>
                <i class="fas fa-chevron-down ml-2 transition-transform duration-300" :class="showFilters ? 'rotate-180' : ''"></i>
            </button>
        </div>

        <!-- Stats Cards -->
        <div x-show="showStats"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-5">

            <!-- Total Trades Card -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-3 border border-white/20 dark:border-slate-700/50 shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fas fa-chart-bar text-white text-sm"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-full">Total</span>
                </div>
                <div class="text-xl font-bold text-slate-800 dark:text-white mb-0.5">{{ number_format($totalTrades) }}</div>
                <div class="text-xs text-slate-600 dark:text-slate-400">รายการเทรดทั้งหมด</div>
            </div>

            <!-- Win Rate Card -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-3 border border-white/20 dark:border-slate-700/50 shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-gradient-to-r from-emerald-600 to-green-600 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-trophy text-white text-sm"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-full">Win Rate</span>
                </div>
                <div class="text-xl font-bold text-emerald-600 dark:text-emerald-400 mb-0.5">{{ $winRate }}%</div>
                <div class="text-xs text-slate-600 dark:text-slate-400">อัตราชนะ</div>
            </div>

            <!-- Total P&L Card -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-3 border border-white/20 dark:border-slate-700/50 shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-gradient-to-r {{ $totalPnl >= 0 ? 'from-emerald-600 to-green-600' : 'from-red-600 to-rose-600' }} rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fas fa-dollar-sign text-white text-sm"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-full">P&L</span>
                </div>
                <div class="text-xl font-bold {{ $totalPnl >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }} mb-0.5">
                    {{ $totalPnl >= 0 ? '+' : '' }}${{ number_format($totalPnl, 2) }}
                </div>
                <div class="text-xs text-slate-600 dark:text-slate-400">กำไรขาดทุนรวม</div>
            </div>

            <!-- Best Strategy Card -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-3 border border-white/20 dark:border-slate-700/50 shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fas fa-chess text-white text-sm"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-full">Strategy</span>
                </div>
                <div class="text-base font-bold text-slate-800 dark:text-white mb-0.5 truncate">{{ ucfirst($bestStrategy) }}</div>
                <div class="text-xs text-slate-600 dark:text-slate-400">กลยุทธ์ที่ดีที่สุด</div>
            </div>
        </div>

        <!-- Search and Filters Section -->
        <div x-show="showFilters || !isMobile"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-4"
            class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-3xl p-4 sm:p-6 border border-white/20 dark:border-slate-700/50 shadow-xl mb-8">

            <!-- Enhanced Search Section -->
            <div class="mb-5">
                <!-- Grid Layout - Responsive -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 xl:grid-cols-12 gap-4 items-end">

                    <!-- Enhanced Search -->
                    <div class="sm:col-span-2 lg:col-span-2 xl:col-span-3">
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            <i class="fas fa-search mr-2 text-blue-600"></i>ค้นหา
                        </label>
                        <div class="relative">
                            <input type="text" wire:model.live="search"
                                placeholder="Symbol, กลยุทธ์, หรือ custom strategy..."
                                class="w-full px-4 py-3 pl-10 pr-10 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 text-sm">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400">
                                <i class="fas fa-search text-sm"></i>
                            </div>
                            @if($search)
                            <button wire:click="$set('search', '')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Date From with Flatpickr -->
                    <div class="lg:col-span-1 xl:col-span-2"
                        x-data="{
                            instance: null,
                            init() {
                                this.instance = flatpickr($refs.input, {
                                    locale: 'th',
                                    dateFormat: 'Y-m-d',
                                    defaultDate: $wire.dateFrom,
                                    onChange: function(selectedDates, dateStr) {
                                        $wire.set('dateFrom', dateStr);
                                    }
                                });
                            }
                        }"
                        x-init="init()"
                        x-effect="instance.setDate($wire.dateFrom, false)"
                    >
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            <i class="fas fa-calendar-alt mr-2 text-emerald-600"></i>
                            <span class="hidden sm:inline">วันที่เริ่มต้น</span>
                            <span class="sm:hidden">เริ่มต้น</span>
                        </label>

                        <div class="relative">
                            <!-- Icon calendar (ตกแต่งด้วย Tailwind + absolute) -->
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar text-emerald-600"></i>
                            </div>

                            <!-- Flatpickr input -->
                            <input x-ref="input"
                                type="text"
                                class="w-full pl-10 pr-3 py-3 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 dark:text-white text-sm"
                                placeholder="เลือกวันที่เริ่มต้น">
                        </div>
                    </div>

                    <!-- Date To with Flatpickr -->
                    <div class="lg:col-span-1 xl:col-span-2"
                        x-data="{
                            instance: null,
                            init() {
                                this.instance = flatpickr($refs.inputTo, {
                                    locale: 'th',
                                    dateFormat: 'Y-m-d',
                                    defaultDate: $wire.dateTo,
                                    onChange: function(selectedDates, dateStr) {
                                        $wire.set('dateTo', dateStr);
                                    }
                                });
                            }
                        }"
                        x-init="init()"
                        x-effect="instance.setDate($wire.dateTo, false)"
                    >
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            <i class="fas fa-calendar-check mr-2 text-orange-600"></i>
                            <span class="hidden sm:inline">วันที่สิ้นสุด</span>
                            <span class="sm:hidden">สิ้นสุด</span>
                        </label>

                        <div class="relative">
                            <!-- Icon calendar -->
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar text-orange-500"></i>
                            </div>

                            <!-- Flatpickr input -->
                            <input x-ref="inputTo"
                                type="text"
                                class="w-full pl-10 pr-3 py-3 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 dark:text-white text-sm"
                                placeholder="เลือกวันที่สิ้นสุด">
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="lg:col-span-1 xl:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            <i class="fas fa-flag mr-2 text-purple-600"></i>สถานะ
                        </label>
                        <select wire:model.live="statusFilter"
                                class="w-full px-3 py-3 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 text-slate-800 dark:text-white text-sm">
                            <option value="">ทั้งหมด</option>
                            <option value="win">Win</option>
                            <option value="loss">Loss</option>
                            <option value="breakeven">Break Even</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>

                    <!-- Strategy Filter -->
                    <div class="lg:col-span-1 xl:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            <i class="fas fa-chess mr-2 text-indigo-600"></i>กลยุทธ์
                        </label>
                        <select wire:model.live="strategyFilter"
                                class="w-full px-3 py-3 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 text-slate-800 dark:text-white text-sm">
                            <option value="">ทั้งหมด</option>
                            @foreach($uniqueStrategies as $strategy)
                                <option value="{{ $strategy }}">{{ ucfirst($strategy) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="sm:col-span-2 lg:col-span-6 xl:col-span-1 flex flex-col sm:flex-row gap-2 lg:justify-end">
                        <button wire:click="resetFilters"
                                class="flex-1 lg:flex-none lg:w-auto px-3 py-3 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-xl transition-all duration-300 font-medium flex items-center justify-center text-sm min-w-0">
                            <i class="fas fa-undo text-sm mr-2 lg:mr-0"></i>
                            <span class="lg:hidden truncate">รีเซ็ต</span>
                        </button>
                        <button wire:click="exportTrades"
                                wire:loading.attr="disabled"
                                wire:target="exportTrades"
                                class="relative flex-1 lg:flex-none lg:w-auto px-3 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl transition-all duration-300 font-medium flex items-center justify-center text-sm min-w-0 overflow-hidden">

                            {{-- Spinner ตอน loading --}}
                            <svg wire:loading wire:target="exportTrades"
                                class="animate-spin h-4 w-4 text-white absolute left-4"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>

                            {{-- ไอคอน + ข้อความปกติ --}}
                            <i class="fas fa-download text-sm mr-2 lg:mr-0"
                            wire:loading.remove wire:target="exportTrades"></i>
                            <span class="lg:hidden truncate" wire:loading.remove wire:target="exportTrades">Export</span>
                            <span class="lg:hidden truncate" wire:loading wire:target="exportTrades">กำลังโหลด...</span>
                        </button>
                    </div>
                </div>

                <!-- Quick Filter Tags -->
                @if($search || $statusFilter || $strategyFilter || $dateFrom !== now()->startOfMonth()->format('Y-m-d') || $dateTo !== now()->endOfMonth()->format('Y-m-d'))
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="text-sm text-slate-600 dark:text-slate-400 mr-2 flex-shrink-0">ฟิลเตอร์ที่ใช้:</span>

                    @if($search)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 max-w-48">
                        <i class="fas fa-search mr-1 flex-shrink-0"></i>
                        <span class="truncate">{{ $search }}</span>
                        <button wire:click="$set('search', '')" class="ml-2 hover:text-blue-600 flex-shrink-0">
                            <i class="fas fa-times"></i>
                        </button>
                    </span>
                    @endif

                    @if($statusFilter)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                        <i class="fas fa-flag mr-1"></i>{{ ucfirst($statusFilter) }}
                        <button wire:click="$set('statusFilter', '')" class="ml-2 hover:text-purple-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </span>
                    @endif

                    @if($strategyFilter)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                        <i class="fas fa-chess mr-1"></i>{{ ucfirst($strategyFilter) }}
                        <button wire:click="$set('strategyFilter', '')" class="ml-2 hover:text-indigo-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </span>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <!-- Trades Table -->
        <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-3xl border border-white/20 dark:border-slate-700/50 shadow-xl overflow-hidden">
            <!-- Table Header -->
            <div class="p-6 border-b border-slate-200/50 dark:border-slate-700/50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white">รายการเทรด</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">แสดง {{ $trades->count() }} รายการจากทั้งหมด {{ $trades->total() }} รายการ</p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('trade') }}"
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-plus mr-2"></i>
                            เพิ่มเทรด
                        </a>
                    </div>
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50/50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 dark:text-slate-300">วันที่</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 dark:text-slate-300">Symbol</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 dark:text-slate-300">จุดเข้า</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 dark:text-slate-300">จุดออก</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 dark:text-slate-300">P&L</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 dark:text-slate-300">R:R</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 dark:text-slate-300">กลยุทธ์</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 dark:text-slate-300">สถานะ</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 dark:text-slate-300">การดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200/50 dark:divide-slate-700/50">
                        @forelse($trades as $trade)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-all duration-200">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-slate-800 dark:text-white">
                                    {{ \Carbon\Carbon::parse($trade->entry_date)->format('d/m/Y') }}
                                </div>
                                @if($trade->entry_time)
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ \Carbon\Carbon::parse($trade->entry_time)->format('H:i') }}
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-r {{ $trade->order_type === 'buy' ? 'from-emerald-500 to-green-500' : 'from-red-500 to-rose-500' }} rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-arrow-{{ $trade->order_type === 'buy' ? 'up' : 'down' }} text-white text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-800 dark:text-white">{{ $trade->symbol }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ ucfirst($trade->order_type) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-mono text-sm text-slate-800 dark:text-white">
                                    {{ number_format($trade->entry_price, 5) }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($trade->exit_price)
                                <div class="font-mono text-sm text-slate-800 dark:text-white">
                                    {{ number_format($trade->exit_price, 5) }}
                                </div>
                                @else
                                <span class="text-xs text-slate-400 dark:text-slate-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($trade->pnl)
                                <div class="font-semibold {{ $trade->pnl > 0 ? 'text-emerald-600 dark:text-emerald-400' : ($trade->pnl < 0 ? 'text-red-600 dark:text-red-400' : 'text-slate-600 dark:text-slate-400') }}">
                                    {{ $trade->pnl > 0 ? '+' : '' }}${{ number_format($trade->pnl, 2) }}
                                </div>
                                @else
                                <span class="text-xs text-slate-400 dark:text-slate-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($trade->risk_reward)
                                <div class="text-sm font-medium text-blue-600 dark:text-blue-400">
                                    1:{{ $trade->risk_reward }}
                                </div>
                                @else
                                <span class="text-xs text-slate-400 dark:text-slate-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $displayStrategy = $trade->strategy === 'other' ? $trade->custom_strategy : $trade->strategy;
                                @endphp
                                @if($displayStrategy)
                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                                    {{ ucfirst($displayStrategy) }}
                                </span>
                                @else
                                <span class="text-xs text-slate-400 dark:text-slate-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($trade->result === 'win')
                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                    <i class="fas fa-trophy mr-1"></i>Win
                                </span>
                                @elseif($trade->result === 'loss')
                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                    <i class="fa-solid fa-circle mr-1"></i>Loss
                                </span>
                                @elseif($trade->result === 'breakeven')
                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                    <i class="fas fa-equals mr-1"></i>Break Even
                                </span>
                                @else
                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-1 flex items-center space-x-1">
                                        <!-- ปุ่มดู - แก้จาก wire:click เป็น href -->
                                        <a href="{{ route('trades.show', $trade->id) }}"
                                           class="p-1.5 text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded transition-colors duration-200"
                                           title="ดู">
                                            <i class="fas fa-eye text-xs"></i>
                                        </a>

                                        <button wire:click="shareTrade('{{ $trade->id }}')"
                                                class="p-1.5 text-emerald-600 hover:bg-emerald-100 dark:hover:bg-emerald-900/50 rounded transition-colors duration-200"
                                                title="แชร์">
                                            <i class="fas fa-share-alt text-xs"></i>
                                        </button>

                                        <a href="{{ route('trades.edit', $trade->id) }}"
                                        class="p-1.5 text-amber-600 hover:bg-amber-100 dark:hover:bg-amber-900/50 rounded transition-colors duration-200"
                                        title="แก้ไข">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>

                                        <div class="w-px h-4 bg-gray-300 dark:bg-gray-600 mx-1"></div>

                                        <button wire:click="deleteTrade('{{ $trade->id }}')"
                                                wire:confirm="คุณต้องการลบข้อมูลการเทรดนี้หรือไม่?"
                                                class="p-1.5 text-red-600 hover:bg-red-100 dark:hover:bg-red-900/50 rounded transition-colors duration-200"
                                                title="ลบ">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-chart-line text-slate-400 dark:text-slate-500 text-2xl"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-2">ไม่พบข้อมูลการเทรด</h3>
                                    <p class="text-slate-600 dark:text-slate-400 mb-4">ยังไม่มีข้อมูลการเทรดในช่วงเวลาที่เลือก</p>
                                    <a href="{{ route('trade') }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200">
                                        <i class="fas fa-plus mr-2"></i>
                                        เพิ่มการเทรดแรก
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

            <!-- Pagination -->
            @if($trades->hasPages())
            <div class="px-6 py-4 border-t border-slate-200/50 dark:border-slate-700/50">
                {{ $trades->links() }}
            </div>
            @endif
        </div>

        <!-- Success/Error Messages -->
        @if (session()->has('success'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 5000)"
                x-show="show"
                x-transition
                class="fixed top-6 right-6 z-50 max-w-sm"
            >
                <div class="bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-xl flex items-center space-x-3 animate-slide-in-right">
                    <i class="fas fa-check-circle text-xl"></i>
                    <div>
                        <p class="font-semibold">สำเร็จ!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
        <div class="fixed top-6 right-6 z-50 max-w-sm">
            <div class="bg-red-500 text-white px-6 py-4 rounded-2xl shadow-xl flex items-center space-x-3 animate-slide-in-right">
                <i class="fas fa-exclamation-circle text-xl"></i>
                <div>
                    <p class="font-semibold">เกิดข้อผิดพลาด!</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if (session()->has('info'))
        <div class="fixed top-6 right-6 z-50 max-w-sm">
            <div class="bg-blue-500 text-white px-6 py-4 rounded-2xl shadow-xl flex items-center space-x-3 animate-slide-in-right">
                <i class="fas fa-info-circle text-xl"></i>
                <div>
                    <p class="font-semibold">แจ้งเตือน</p>
                    <p class="text-sm">{{ session('info') }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    @if($showShareModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        x-data="{ copied: false }"
        wire:click.self="closeShareModal">
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-green-500 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-share-alt text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white">แชร์การเทรด</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">แชร์ให้เพื่อนๆ ดูผลงานของคุณ</p>
                    </div>
                </div>
                <button wire:click="closeShareModal"
                        class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Share URL Section -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                    <i class="fas fa-link mr-2 text-blue-500"></i>ลิงก์แชร์
                </label>
                <div class="flex bg-slate-50 dark:bg-slate-700 rounded-xl border border-slate-200 dark:border-slate-600 overflow-hidden">
                    <input type="text"
                        value="{{ $shareUrl }}"
                        readonly
                        id="shareUrlInput"
                        class="flex-1 px-4 py-3 bg-transparent text-sm text-slate-700 dark:text-slate-300 font-mono focus:outline-none">
                    <button onclick="copyShareUrl()"
                            @click="copied = true; setTimeout(() => copied = false, 2000)"
                            class="px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white transition-all duration-200 font-medium">
                        <span x-show="!copied" class="flex items-center">
                            <i class="fas fa-copy"></i>
                        </span>
                        <span x-show="copied" class="flex items-center text-blue-100">
                            <i class="fas fa-check"></i>
                        </span>
                    </button>
                </div>
            </div>

            <!-- Share Options -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                    <i class="fas fa-share mr-2 text-purple-500"></i>แชร์ผ่าน
                </label>
                <div class="flex justify-center space-x-3">
                    <!-- Facebook -->
                    <button onclick="shareToFacebook()"
                            class="w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg flex items-center justify-center"
                            title="Facebook">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </button>

                    <!-- Twitter -->
                    <button onclick="shareToTwitter()"
                            class="w-10 h-10 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg flex items-center justify-center"
                            title="Twitter">
                        <i class="fab fa-twitter text-sm"></i>
                    </button>

                    <!-- Line -->
                    <button onclick="shareToLine()"
                            class="w-10 h-10 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg flex items-center justify-center"
                            title="Line">
                        <i class="fab fa-line text-sm"></i>
                    </button>

                    <!-- WhatsApp -->
                    <button onclick="shareToWhatsApp()"
                            class="w-10 h-10 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg flex items-center justify-center"
                            title="WhatsApp">
                        <i class="fab fa-whatsapp text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3">
                <button wire:click="closeShareModal"
                        class="flex-1 px-6 py-3 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-xl transition-all duration-300 font-medium">
                    ปิด
                </button>
                <button onclick="window.open('{{ $shareUrl }}', '_blank')"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white rounded-xl transition-all duration-300 font-medium shadow-lg hover:shadow-xl">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    ดูตัวอย่าง
                </button>
            </div>
        </div>
    </div>
@endif
@if (session('message'))
    <div class="bg-yellow-100 text-yellow-800 p-3 rounded mb-4">
        {{ session('message') }}
    </div>
@endif

<script>
    window.addEventListener('toast', event => {
        const { message, type } = event.detail;

        Toastify({
            text: message,
            duration: 3000,
            gravity: 'top',
            position: 'right',
            backgroundColor:
                type === 'success' ? '#10b981' :
                type === 'error' ? '#ef4444' :
                '#3b82f6',
        }).showToast();
    });

    window.addEventListener('download-file', event => {
        const url = event.detail.url;

        const a = document.createElement('a');
        a.href = url;
        a.setAttribute('download', '');
        a.style.display = 'none';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });
</script>
<!-- Export Polling -->
<div wire:poll.5s="checkExportReady"></div>
</div>
