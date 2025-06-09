<div class="max-w-5xl mx-auto">
    <!-- Status Bar - Fixed at top -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 py-4">
            <div class="relative flex items-center justify-between w-full">

                @for($i = 1; $i <= $totalSteps; $i++)
                    <div class="flex-1 relative flex flex-col items-center text-center">
                        <!-- เส้นเชื่อม - เชื่อมจากจุดกลางของวงกลมแต่ละจุด -->
                        @if($i > 1)
                            <div class="absolute top-5 h-0.5 z-0
                                        {{ $i <= $step ? 'bg-blue-500' : 'bg-gray-300 dark:bg-gray-700' }}"
                                style="right: 50%; left: -50%; transform: translateY(-50%);"></div>
                        @endif
                        <!-- วงกลม -->
                        <div class="relative z-10 flex items-center justify-center w-10 h-10 rounded-full text-sm font-semibold border-2
                            {{ $i < $step ? 'bg-blue-500 text-white border-blue-500' :
                            ($i === $step ? 'bg-white text-blue-600 border-blue-500 dark:bg-gray-800' :
                            'bg-gray-100 text-gray-400 border-gray-300 dark:bg-gray-700 dark:border-gray-600') }}">
                            @if($i < $step)
                                <i class="fas fa-check text-xs"></i>
                            @else
                                {{ $i }}
                            @endif
                        </div>
                        <!-- Label -->
                        <span class="mt-2 text-xs font-medium whitespace-nowrap
                            {{ $i === $step ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
                            @if($i === 1) ข้อมูลพื้นฐาน
                            @elseif($i === 2) รายละเอียดเทรด
                            @elseif($i === 3) กลยุทธ์ & จิตวิทยา
                            @endif
                        </span>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Form Content with top margin -->
    <div class="pt-6">
        <form wire:submit.prevent="submit" enctype="multipart/form-data">
            <!-- Step 1: Basic Information -->
            @if($step === 1)
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/20 dark:border-slate-700/50 overflow-hidden">
                <!-- Header Section -->
                <div class="relative bg-gradient-to-r from-blue-600/10 via-indigo-600/10 to-purple-600/10 dark:from-blue-600/20 dark:via-indigo-600/20 dark:to-purple-600/20 px-8 py-6 border-b border-slate-200/50 dark:border-slate-700/50">
                    <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
                    <div class="relative">
                        <div class="flex items-center space-x-4 mb-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/25">
                                <i class="fas fa-database text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-slate-800 dark:text-white">Trade Information</h3>
                                <p class="text-slate-600 dark:text-slate-400">กรอกข้อมูลพื้นฐานสำหรับการวิเคราะห์ผลงาน</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        <!-- Trading Pair -->
                        <div class="group">
                            <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                <div class="w-6 h-6 bg-gradient-to-r from-amber-100 to-yellow-100 dark:from-amber-900/30 dark:to-yellow-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-coins text-amber-600 dark:text-amber-400 text-sm"></i>
                                </div>
                                Trading Pair
                                <span class="text-red-500 ml-2 font-bold">*</span>
                                <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Required</div>
                            </label>
                            <div class="relative">
                                <input type="text" wire:model.defer="symbol" required
                                    placeholder="EURUSD, GBPJPY, XAUUSD, BTCUSDT..."
                                    class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white dark:focus:bg-slate-700 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 font-medium shadow-sm hover:shadow-md pl-12"/>
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
                                    <i class="fas fa-search text-sm"></i>
                                </div>
                            </div>
                            @error('symbol')
                            <div class="mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-400 text-sm flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                            </div>
                            @enderror
                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">กรอก Symbol ที่คุณเทรด เช่น คู่สกุลเงิน, ทองคำ, หุ้น, Crypto</p>
                        </div>

                        <!-- Position Direction -->
                        <div class="group">
                            <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                <div class="w-6 h-6 bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-exchange-alt text-emerald-600 dark:text-emerald-400 text-sm"></i>
                                </div>
                                Position Direction
                                <span class="text-red-500 ml-2 font-bold">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <!-- Long Button -->
                                <button type="button"
                                    wire:click="$set('orderType', 'buy')"
                                    class="relative p-4 transition-all duration-300 rounded-2xl border-2 transform hover:scale-105
                                    {{ $orderType === 'buy'
                                        ? 'bg-gradient-to-r from-emerald-500 to-green-500 border-emerald-600 shadow-lg shadow-emerald-500/25'
                                        : 'bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 border-emerald-200 dark:border-emerald-800 hover:from-emerald-100 hover:to-green-100 dark:hover:from-emerald-900/30 dark:hover:to-green-900/30' }}">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors duration-300
                                            {{ $orderType === 'buy'
                                                ? 'bg-white/20 backdrop-blur-sm'
                                                : 'bg-emerald-600' }}">
                                            <i class="fas fa-arrow-up text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold transition-colors duration-300
                                                {{ $orderType === 'buy'
                                                    ? 'text-white'
                                                    : 'text-emerald-700 dark:text-emerald-300' }}">
                                                Long
                                            </div>
                                            <div class="text-xs transition-colors duration-300
                                                {{ $orderType === 'buy'
                                                    ? 'text-emerald-100'
                                                    : 'text-emerald-600 dark:text-emerald-400' }}">
                                                Buy Position
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Selected Indicator -->
                                    @if($orderType === 'buy')
                                    <div class="absolute top-2 right-2">
                                        <div class="w-5 h-5 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                    </div>
                                    @endif
                                </button>

                                <!-- Short Button -->
                                <button type="button"
                                    wire:click="$set('orderType', 'sell')"
                                    class="relative p-4 transition-all duration-300 rounded-2xl border-2 transform hover:scale-105
                                    {{ $orderType === 'sell'
                                        ? 'bg-gradient-to-r from-red-500 to-rose-500 border-red-600 shadow-lg shadow-red-500/25'
                                        : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-red-50 dark:hover:bg-red-900/20 hover:border-red-200 dark:hover:border-red-800' }}">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors duration-300
                                            {{ $orderType === 'sell'
                                                ? 'bg-white/20 backdrop-blur-sm'
                                                : 'bg-slate-400 hover:bg-red-500' }}">
                                            <i class="fas fa-arrow-down text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold transition-colors duration-300
                                                {{ $orderType === 'sell'
                                                    ? 'text-white'
                                                    : 'text-slate-600 hover:text-red-700 dark:text-slate-400 dark:hover:text-red-300' }}">
                                                Short
                                            </div>
                                            <div class="text-xs transition-colors duration-300
                                                {{ $orderType === 'sell'
                                                    ? 'text-red-100'
                                                    : 'text-slate-500 hover:text-red-600 dark:text-slate-500 dark:hover:text-red-400' }}">
                                                Sell Position
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Selected Indicator -->
                                    @if($orderType === 'sell')
                                    <div class="absolute top-2 right-2">
                                        <div class="w-5 h-5 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                    </div>
                                    @endif
                                </button>
                            </div>
                            @error('orderType')
                            <div class="mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-400 text-sm flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Entry Date & Time -->
                        <div class="group">
                            <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                <div class="w-6 h-6 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-calendar-plus text-blue-600 dark:text-blue-400 text-sm"></i>
                                </div>
                                Entry Date & Time
                                <span class="text-red-500 ml-2 font-bold">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="relative">
                                    <input type="date" wire:model.defer="entryDate" required
                                        class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 dark:text-white shadow-sm hover:shadow-md"/>
                                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none">

                                    </div>
                                </div>
                                <div class="relative">
                                    <input type="time" wire:model.defer="entryTime"
                                        class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 dark:text-white shadow-sm hover:shadow-md"/>
                                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none">

                                    </div>
                                </div>
                            </div>
                            @error('entryDate')
                            <div class="mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-400 text-sm flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                            </div>
                            @enderror
                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">เวลาที่เปิดโพซิชัน (เวลาเป็นตัวเลือก)</p>
                        </div>

                        <!-- Exit Date & Time -->
                        <div class="group">
                            <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                <div class="w-6 h-6 bg-gradient-to-r from-orange-100 to-red-100 dark:from-orange-900/30 dark:to-red-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-calendar-minus text-orange-600 dark:text-orange-400 text-sm"></i>
                                </div>
                                Exit Date & Time
                                <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Optional</div>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="relative">
                                    <input type="date" wire:model.defer="exitDate"
                                        class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 dark:text-white shadow-sm hover:shadow-md"/>
                                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none">
                                    </div>
                                </div>
                                <div class="relative">
                                    <input type="time" wire:model.defer="exitTime"
                                        class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 dark:text-white shadow-sm hover:shadow-md"/>
                                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none">
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">เวลาที่ปิดโพซิชัน (ถ้ายังไม่ปิดสามารถข้ามได้)</p>
                        </div>

                    </div>
                </div>
            </div>
            @endif

            <!-- Step 2: Trade Details -->
            @if($step === 2)
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/20 dark:border-slate-700/50 overflow-hidden">
                <!-- Header Section -->
                <div class="relative bg-gradient-to-r from-emerald-600/10 via-blue-600/10 to-indigo-600/10 dark:from-emerald-600/20 dark:via-blue-600/20 dark:to-indigo-600/20 px-6 py-8 border-b border-slate-200/50 dark:border-slate-700/50">
                    <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
                    <div class="relative">
                        <div class="flex items-center space-x-4 mb-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-emerald-600 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/25">
                                <i class="fas fa-calculator text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-slate-800 dark:text-white">Financial Analysis</h3>
                                <p class="text-slate-600 dark:text-slate-400">กรอกราคาและข้อมูลการคำนวณ P&L</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                        <!-- Entry Price -->
                        <div class="group">
                            <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                <div class="w-6 h-6 bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-play text-emerald-600 dark:text-emerald-400 text-sm"></i>
                                </div>
                                Entry Price
                                <span class="text-red-500 ml-2 font-bold">*</span>
                                <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Required</div>
                            </label>
                            <div class="relative">
                                <input type="number" step="0.00001" wire:model.live="entryPrice" required
                                    placeholder="1.08542"
                                    class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 font-mono text-lg shadow-sm hover:shadow-md pl-12"/>
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
                                    <i class="fas fa-dollar-sign text-sm"></i>
                                </div>
                            </div>
                            @error('entryPrice')
                            <div class="mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-400 text-sm flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                            </div>
                            @enderror
                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">ราคาที่เปิดโพซิชัน</p>
                        </div>

                        <!-- Exit Price -->
                        <div class="group">
                            <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                <div class="w-6 h-6 bg-gradient-to-r from-red-100 to-rose-100 dark:from-red-900/30 dark:to-rose-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-stop text-red-600 dark:text-red-400 text-sm"></i>
                                </div>
                                Exit Price
                                <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Optional</div>
                            </label>
                            <div class="relative">
                                <input type="number" step="0.00001" wire:model.live="exitPrice"
                                    placeholder="1.08642"
                                    class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 font-mono text-lg shadow-sm hover:shadow-md pl-12"/>
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
                                    <i class="fas fa-dollar-sign text-sm"></i>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">ราคาที่ปิดโพซิชัน (ถ้ายังไม่ปิดสามารถข้ามได้)</p>
                        </div>

                        <!-- Stop Loss -->
                        <div class="group">
                            <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                <div class="w-6 h-6 bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-shield-alt text-red-600 dark:text-red-400 text-sm"></i>
                                </div>
                                Stop Loss
                                <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Risk Management</div>
                            </label>
                            <div class="relative">
                                <input type="number" step="0.00001" wire:model.live="stopLoss"
                                    placeholder="1.08442"
                                    class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 font-mono text-lg shadow-sm hover:shadow-md pl-12"/>
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
                                    <i class="fas fa-shield text-sm"></i>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">ระดับการตัดขาดทุน (สำหรับคำนวณ Risk:Reward)</p>
                        </div>

                        <!-- Take Profit -->
                        <div class="group">
                            <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                <div class="w-6 h-6 bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-bullseye text-emerald-600 dark:text-emerald-400 text-sm"></i>
                                </div>
                                Take Profit
                                <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Target</div>
                            </label>
                            <div class="relative">
                                <input type="number" step="0.00001" wire:model.live="takeProfit"
                                    placeholder="1.08742"
                                    class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 font-mono text-lg shadow-sm hover:shadow-md pl-12"/>
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
                                    <i class="fas fa-target text-sm"></i>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">เป้าหมายการทำกำไร (สำหรับคำนวณ Risk:Reward)</p>
                        </div>

                        <!-- Position Size -->
                        <div class="group">
                            <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                <div class="w-6 h-6 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-weight-hanging text-blue-600 dark:text-blue-400 text-sm"></i>
                                </div>
                                Position Size
                                <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Volume</div>
                            </label>
                            <div class="relative">
                                <input type="number" step="0.01" wire:model.live="lotSize"
                                    placeholder="0.10"
                                    class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 font-mono text-lg shadow-sm hover:shadow-md pl-12"/>
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
                                    <i class="fas fa-layer-group text-sm"></i>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">ขนาดของโพซิชัน (Lot Size) เช่น 0.01, 0.10, 1.00</p>
                        </div>

                        <!-- Order Type -->
                        <div class="group">
                            <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                <div class="w-6 h-6 bg-gradient-to-r from-purple-100 to-indigo-100 dark:from-purple-900/30 dark:to-indigo-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-layer-group text-purple-600 dark:text-purple-400 text-sm"></i>
                                </div>
                                Order Type
                                <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Fixed</div>
                            </label>
                            <div class="relative">
                                <div class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl text-slate-800 dark:text-white shadow-sm font-medium pl-12">
                                    Market Order
                                </div>
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none">
                                    <i class="fas fa-bolt text-sm"></i>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">ใช้ Market Order สำหรับการเทรดทั้งหมด</p>
                        </div>
                    </div>

                    <!-- Real-time Analysis Panel -->
                    <div class="mt-10 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-800/50 dark:via-slate-700/50 dark:to-slate-600/50 rounded-3xl p-8 border border-slate-200/50 dark:border-slate-700/50 backdrop-blur-sm">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-chart-pie text-white text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-slate-800 dark:text-white">Live Analysis</h4>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">การวิเคราะห์แบบ Real-time</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-xs text-slate-500 dark:text-slate-400">Live</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- P&L Card with Manual Input -->
                            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-200/50 dark:border-slate-700/50 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Profit & Loss</span>
                                    <div class="flex items-center space-x-2">
                                        <!-- Toggle Button for Manual Input -->
                                        <button type="button" wire:click="$toggle('manualPnl')"
                                            class="text-xs px-2 py-1 rounded-lg transition-all duration-200 {{ $manualPnl ? 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 dark:bg-slate-700 dark:text-slate-400 dark:hover:bg-slate-600' }}">
                                            <i class="fas fa-edit mr-1"></i>{{ $manualPnl ? 'Auto' : 'Manual' }}
                                        </button>

                                        <div class="w-8 h-8 rounded-xl flex items-center justify-center {{ ($manualPnl ? $manualPnlValue : $this->pnl) > 0 ? 'bg-emerald-100 dark:bg-emerald-900/30' : (($manualPnl ? $manualPnlValue : $this->pnl) < 0 ? 'bg-red-100 dark:bg-red-900/30' : 'bg-slate-100 dark:bg-slate-700') }}">
                                            <i class="fas fa-dollar-sign text-sm {{ ($manualPnl ? $manualPnlValue : $this->pnl) > 0 ? 'text-emerald-600 dark:text-emerald-400' : (($manualPnl ? $manualPnlValue : $this->pnl) < 0 ? 'text-red-600 dark:text-red-400' : 'text-slate-500') }}"></i>
                                        </div>
                                    </div>
                                </div>

                                @if($manualPnl)
                                    <!-- Manual Input Mode -->
                                    <div class="space-y-3">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">
                                                <i class="fas fa-hand-point-right mr-1"></i>Manual Input
                                            </span>
                                        </div>
                                        <div class="relative">
                                            <input type="number" step="0.01" wire:model.live="manualPnlValue"
                                                placeholder="0.00"
                                                class="w-full px-3 py-2 text-2xl font-bold bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 font-mono text-center">
                                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none">
                                                <span class="text-lg font-bold">$</span>
                                            </div>
                                        </div>

                                        @if($manualPnlValue != 0)
                                            <div class="flex items-center justify-center space-x-1 {{ $manualPnlValue > 0 ? 'text-emerald-500' : 'text-red-500' }}">
                                                <i class="fas fa-{{ $manualPnlValue > 0 ? 'arrow-up' : 'arrow-down' }} text-sm"></i>
                                                <span class="text-xs font-medium">{{ $manualPnlValue > 0 ? 'Profit' : 'Loss' }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <!-- Auto Calculation Mode -->
                                    <div class="flex items-center space-x-3">
                                        <div class="text-3xl font-bold {{ $this->pnl > 0 ? 'text-emerald-500' : ($this->pnl < 0 ? 'text-red-500' : 'text-slate-500') }}">
                                            {{ $this->pnl > 0 ? '+' : '' }}${{ number_format($this->pnl ?? 0, 2) }}
                                        </div>
                                        @if($this->pnl > 0)
                                            <div class="flex items-center space-x-1 text-emerald-500">
                                                <i class="fas fa-arrow-up text-sm"></i>
                                                <span class="text-xs font-medium">Profit</span>
                                            </div>
                                        @elseif($this->pnl < 0)
                                            <div class="flex items-center space-x-1 text-red-500">
                                                <i class="fas fa-arrow-down text-sm"></i>
                                                <span class="text-xs font-medium">Loss</span>
                                            </div>
                                        @else
                                            <div class="flex items-center space-x-1 text-slate-500">
                                                <i class="fas fa-minus text-sm"></i>
                                                <span class="text-xs font-medium">Pending</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Auto calculation hint -->
                                    @if($this->pnl != 0)
                                        <div class="mt-2 text-xs text-slate-400 flex items-center">
                                            <i class="fas fa-calculator mr-1"></i>
                                            Auto-calculated from trade data
                                        </div>
                                    @endif
                                @endif
                            </div>

                            <!-- Risk:Reward Card -->
                            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-200/50 dark:border-slate-700/50 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Risk : Reward</span>
                                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-balance-scale text-blue-600 dark:text-blue-400 text-sm"></i>
                                    </div>
                                </div>
                                <div class="text-3xl font-bold text-blue-500">
                                    {{ $this->riskReward ?? '---' }}
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                    @if($this->riskReward && $this->riskReward >= 3)
                                        <span class="text-green-500 font-medium">Excellent ratio</span>
                                    @elseif($this->riskReward && $this->riskReward >= 2)
                                        <span class="text-blue-500 font-medium">Very good ratio</span>
                                    @elseif($this->riskReward && $this->riskReward >= 1)
                                        <span class="text-yellow-500 font-medium">Good ratio</span>
                                    @elseif($this->riskReward && $this->riskReward < 1)
                                        <span class="text-red-500 font-medium">Poor ratio</span>
                                    @else
                                        <span class="text-slate-400">Needs data</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Trade Status Card with Manual Selection -->
                            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-200/50 dark:border-slate-700/50 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Trade Status</span>
                                    <div class="flex items-center space-x-2">
                                        <!-- Toggle Button for Manual Selection -->
                                        <button type="button" wire:click="$toggle('manualResult')"
                                            class="text-xs px-2 py-1 rounded-lg transition-all duration-200 {{ $manualResult ? 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 dark:bg-slate-700 dark:text-slate-400 dark:hover:bg-slate-600' }}">
                                            <i class="fas fa-edit mr-1"></i>{{ $manualResult ? 'Auto' : 'Manual' }}
                                        </button>

                                        <div class="w-8 h-8 rounded-xl flex items-center justify-center {{ ($manualResult ? $manualResultValue : $this->result) === 'win' ? 'bg-emerald-100 dark:bg-emerald-900/30' : (($manualResult ? $manualResultValue : $this->result) === 'loss' ? 'bg-red-100 dark:bg-red-900/30' : (($manualResult ? $manualResultValue : $this->result) === 'breakeven' ? 'bg-yellow-100 dark:bg-yellow-900/30' : 'bg-slate-100 dark:bg-slate-700')) }}">
                                            @php
                                                $currentResult = $manualResult ? $manualResultValue : $this->result;
                                            @endphp
                                            @if($currentResult === 'win')
                                                <i class="fas fa-trophy text-emerald-600 dark:text-emerald-400 text-sm"></i>
                                            @elseif($currentResult === 'loss')
                                                <i class="fas fa-chart-line-down text-red-600 dark:text-red-400 text-sm"></i>
                                            @elseif($currentResult === 'breakeven')
                                                <i class="fas fa-equals text-yellow-600 dark:text-yellow-400 text-sm"></i>
                                            @else
                                                <i class="fas fa-clock text-slate-500 text-sm"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if($manualResult)
                                    <!-- Manual Selection Mode -->
                                    <div class="space-y-3">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">
                                                <i class="fas fa-hand-point-right mr-1"></i>Manual Selection
                                            </span>
                                        </div>

                                        <!-- Status Selection Buttons -->
                                        <div class="grid grid-cols-2 gap-2">
                                            <!-- Win Button -->
                                            <button type="button" wire:click="$set('manualResultValue', 'win')"
                                                class="p-3 rounded-xl border-2 transition-all duration-300 text-center hover:scale-105 {{ $manualResultValue === 'win' ? 'bg-gradient-to-r from-emerald-500 to-green-500 border-emerald-600 text-white shadow-lg shadow-emerald-500/25' : 'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-200 dark:border-emerald-800 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' }}">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <i class="fas fa-trophy text-sm"></i>
                                                    <span class="font-semibold">Win</span>
                                                </div>
                                            </button>

                                            <!-- Loss Button -->
                                            <button type="button" wire:click="$set('manualResultValue', 'loss')"
                                                class="p-3 rounded-xl border-2 transition-all duration-300 text-center hover:scale-105 {{ $manualResultValue === 'loss' ? 'bg-gradient-to-r from-red-500 to-rose-500 border-red-600 text-white shadow-lg shadow-red-500/25' : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-700 dark:text-red-300' }}">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <i class="fas fa-chart-line-down text-sm"></i>
                                                    <span class="font-semibold">Loss</span>
                                                </div>
                                            </button>

                                            <!-- Break Even Button -->
                                            <button type="button" wire:click="$set('manualResultValue', 'breakeven')"
                                                class="p-3 rounded-xl border-2 transition-all duration-300 text-center hover:scale-105 {{ $manualResultValue === 'breakeven' ? 'bg-gradient-to-r from-yellow-500 to-amber-500 border-yellow-600 text-white shadow-lg shadow-yellow-500/25' : 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800 hover:bg-yellow-100 dark:hover:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' }}">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <i class="fas fa-equals text-sm"></i>
                                                    <span class="font-semibold">Break Even</span>
                                                </div>
                                            </button>

                                            <!-- Pending Button -->
                                            <button type="button" wire:click="$set('manualResultValue', 'pending')"
                                                class="p-3 rounded-xl border-2 transition-all duration-300 text-center hover:scale-105 {{ $manualResultValue === 'pending' ? 'bg-gradient-to-r from-slate-500 to-gray-500 border-slate-600 text-white shadow-lg shadow-slate-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300' }}">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <i class="fas fa-clock text-sm"></i>
                                                    <span class="font-semibold">Pending</span>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <!-- Auto Calculation Mode -->
                                    <div class="text-3xl font-bold {{ $this->result === 'win' ? 'text-emerald-500' : ($this->result === 'loss' ? 'text-red-500' : ($this->result === 'breakeven' ? 'text-yellow-500' : 'text-slate-500')) }}">
                                        @if($this->result === 'win')
                                            Win
                                        @elseif($this->result === 'loss')
                                            Loss
                                        @elseif($this->result === 'breakeven')
                                            Break Even
                                        @else
                                            Pending
                                        @endif
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                        {{ $this->result === 'win' ? 'Target achieved!' : ($this->result === 'loss' ? 'Stop loss hit' : ($this->result === 'breakeven' ? 'No profit/loss' : 'Awaiting calculation')) }}
                                    </div>

                                    <!-- Auto calculation hint -->
                                    @if($this->result && $this->result !== 'pending')
                                        <div class="mt-2 text-xs text-slate-400 flex items-center">
                                            <i class="fas fa-calculator mr-1"></i>
                                            Auto-calculated from P&L
                                        </div>
                                    @endif
                                @endif

                                <!-- Display current selection in manual mode -->
                                @if($manualResult && $manualResultValue)
                                    <div class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                                        {{ $manualResultValue === 'win' ? 'Profitable trade!' : ($manualResultValue === 'loss' ? 'Learning experience' : ($manualResultValue === 'breakeven' ? 'No profit/loss' : 'Trade in progress')) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Step 3: Strategy & Psychology -->
            @if($step === 3)
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/20 dark:border-slate-700/50 overflow-hidden">
                <!-- Header Section -->
                <div class="relative bg-gradient-to-r from-purple-600/10 via-pink-600/10 to-indigo-600/10 dark:from-purple-600/20 dark:via-pink-600/20 dark:to-indigo-600/20 px-6 py-8 border-b border-slate-200/50 dark:border-slate-700/50">
                    <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
                    <div class="relative">
                        <div class="flex items-center space-x-4 mb-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/25">
                                <i class="fas fa-brain text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-slate-800 dark:text-white">Trading Psychology</h3>
                                <p class="text-slate-600 dark:text-slate-400">วิเคราะห์กลยุทธ์และจิตวิทยาในการเทรด</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                        <!-- Trading Strategy -->
                        <div class="group col-span-1 lg:col-span-2">
                            <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">
                                <div class="w-6 h-6 bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-chess text-indigo-600 dark:text-indigo-400 text-sm"></i>
                                </div>
                                Trading Strategy
                                <span class="text-red-500 ml-2 font-bold">*</span>
                                <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Required</div>
                            </label>

                            <!-- Strategy Grid -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                <button type="button" wire:click="$set('strategy', 'breakout')"
                                    class="p-4 rounded-2xl border-2 transition-all duration-300 text-left hover:scale-105 {{ $strategy === 'breakout' ? 'bg-gradient-to-r from-blue-500 to-indigo-500 border-blue-600 text-white shadow-lg shadow-blue-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-200 dark:hover:border-blue-800' }}">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2 {{ $strategy === 'breakout' ? 'bg-white/20' : 'bg-blue-100 dark:bg-blue-900/30' }}">
                                        <i class="fas fa-rocket {{ $strategy === 'breakout' ? 'text-white' : 'text-blue-600 dark:text-blue-400' }} text-sm"></i>
                                    </div>
                                    <div class="font-semibold text-sm {{ $strategy === 'breakout' ? 'text-white' : 'text-slate-800 dark:text-white' }}">Breakout</div>
                                </button>

                                <button type="button" wire:click="$set('strategy', 'scalping')"
                                    class="p-4 rounded-2xl border-2 transition-all duration-300 text-left hover:scale-105 {{ $strategy === 'scalping' ? 'bg-gradient-to-r from-emerald-500 to-green-500 border-emerald-600 text-white shadow-lg shadow-emerald-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:border-emerald-200 dark:hover:border-emerald-800' }}">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2 {{ $strategy === 'scalping' ? 'bg-white/20' : 'bg-emerald-100 dark:bg-emerald-900/30' }}">
                                        <i class="fas fa-bolt {{ $strategy === 'scalping' ? 'text-white' : 'text-emerald-600 dark:text-emerald-400' }} text-sm"></i>
                                    </div>
                                    <div class="font-semibold text-sm {{ $strategy === 'scalping' ? 'text-white' : 'text-slate-800 dark:text-white' }}">Scalping</div>
                                </button>

                                <button type="button" wire:click="$set('strategy', 'swing')"
                                    class="p-4 rounded-2xl border-2 transition-all duration-300 text-left hover:scale-105 {{ $strategy === 'swing' ? 'bg-gradient-to-r from-purple-500 to-pink-500 border-purple-600 text-white shadow-lg shadow-purple-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:border-purple-200 dark:hover:border-purple-800' }}">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2 {{ $strategy === 'swing' ? 'bg-white/20' : 'bg-purple-100 dark:bg-purple-900/30' }}">
                                        <i class="fas fa-wave-square {{ $strategy === 'swing' ? 'text-white' : 'text-purple-600 dark:text-purple-400' }} text-sm"></i>
                                    </div>
                                    <div class="font-semibold text-sm {{ $strategy === 'swing' ? 'text-white' : 'text-slate-800 dark:text-white' }}">Swing</div>
                                </button>

                                <button type="button" wire:click="$set('strategy', 'trend')"
                                    class="p-4 rounded-2xl border-2 transition-all duration-300 text-left hover:scale-105 {{ $strategy === 'trend' ? 'bg-gradient-to-r from-orange-500 to-red-500 border-orange-600 text-white shadow-lg shadow-orange-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-orange-50 dark:hover:bg-orange-900/20 hover:border-orange-200 dark:hover:border-orange-800' }}">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2 {{ $strategy === 'trend' ? 'bg-white/20' : 'bg-orange-100 dark:bg-orange-900/30' }}">
                                        <i class="fas fa-chart-line {{ $strategy === 'trend' ? 'text-white' : 'text-orange-600 dark:text-orange-400' }} text-sm"></i>
                                    </div>
                                    <div class="font-semibold text-sm {{ $strategy === 'trend' ? 'text-white' : 'text-slate-800 dark:text-white' }}">Trend</div>
                                </button>

                                <button type="button" wire:click="$set('strategy', 'reversal')"
                                    class="p-4 rounded-2xl border-2 transition-all duration-300 text-left hover:scale-105 {{ $strategy === 'reversal' ? 'bg-gradient-to-r from-cyan-500 to-blue-500 border-cyan-600 text-white shadow-lg shadow-cyan-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 hover:border-cyan-200 dark:hover:border-cyan-800' }}">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2 {{ $strategy === 'reversal' ? 'bg-white/20' : 'bg-cyan-100 dark:bg-cyan-900/30' }}">
                                        <i class="fas fa-undo {{ $strategy === 'reversal' ? 'text-white' : 'text-cyan-600 dark:text-cyan-400' }} text-sm"></i>
                                    </div>
                                    <div class="font-semibold text-sm {{ $strategy === 'reversal' ? 'text-white' : 'text-slate-800 dark:text-white' }}">Reversal</div>
                                </button>

                                <button type="button" wire:click="$set('strategy', 'range')"
                                    class="p-4 rounded-2xl border-2 transition-all duration-300 text-left hover:scale-105 {{ $strategy === 'range' ? 'bg-gradient-to-r from-teal-500 to-green-500 border-teal-600 text-white shadow-lg shadow-teal-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-teal-50 dark:hover:bg-teal-900/20 hover:border-teal-200 dark:hover:border-teal-800' }}">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2 {{ $strategy === 'range' ? 'bg-white/20' : 'bg-teal-100 dark:bg-teal-900/30' }}">
                                        <i class="fas fa-arrows-alt-h {{ $strategy === 'range' ? 'text-white' : 'text-teal-600 dark:text-teal-400' }} text-sm"></i>
                                    </div>
                                    <div class="font-semibold text-sm {{ $strategy === 'range' ? 'text-white' : 'text-slate-800 dark:text-white' }}">Range</div>
                                </button>

                                <button type="button" wire:click="$set('strategy', 'news')"
                                    class="p-4 rounded-2xl border-2 transition-all duration-300 text-left hover:scale-105 {{ $strategy === 'news' ? 'bg-gradient-to-r from-yellow-500 to-orange-500 border-yellow-600 text-white shadow-lg shadow-yellow-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:border-yellow-200 dark:hover:border-yellow-800' }}">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2 {{ $strategy === 'news' ? 'bg-white/20' : 'bg-yellow-100 dark:bg-yellow-900/30' }}">
                                        <i class="fas fa-newspaper {{ $strategy === 'news' ? 'text-white' : 'text-yellow-600 dark:text-yellow-400' }} text-sm"></i>
                                    </div>
                                    <div class="font-semibold text-sm {{ $strategy === 'news' ? 'text-white' : 'text-slate-800 dark:text-white' }}">News</div>
                                </button>

                                <button type="button" wire:click="$set('strategy', 'other')"
                                    class="p-4 rounded-2xl border-2 transition-all duration-300 text-left hover:scale-105 {{ $strategy === 'other' ? 'bg-gradient-to-r from-slate-500 to-gray-500 border-slate-600 text-white shadow-lg shadow-slate-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-600 hover:border-slate-300 dark:hover:border-slate-500' }}">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2 {{ $strategy === 'other' ? 'bg-white/20' : 'bg-slate-100 dark:bg-slate-600' }}">
                                        <i class="fas fa-plus {{ $strategy === 'other' ? 'text-white' : 'text-slate-600 dark:text-slate-400' }} text-sm"></i>
                                    </div>
                                    <div class="font-semibold text-sm {{ $strategy === 'other' ? 'text-white' : 'text-slate-800 dark:text-white' }}">Other</div>
                                </button>
                            </div>

                            @error('strategy')
                            <div class="p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-400 text-sm flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Custom Strategy Input -->
                        @if($strategy === 'other')
                        <div class="group col-span-1 lg:col-span-2">
                            <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                <div class="w-6 h-6 bg-gradient-to-r from-orange-100 to-red-100 dark:from-orange-900/30 dark:to-red-900/30 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-edit text-orange-600 dark:text-orange-400 text-sm"></i>
                                </div>
                                Custom Strategy
                            </label>
                            <input type="text" wire:model.defer="customStrategy"
                                placeholder="อธิบายกลยุทธ์ของคุณ เช่น 'Fibonacci Retracement + RSI Divergence'"
                                class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 shadow-sm hover:shadow-md"/>
                        </div>
                        @endif


                        <!-- Emotion Before Trading -->
                        <div class="group">
                            <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                <div class="w-6 h-6 bg-gradient-to-r from-yellow-100 to-amber-100 dark:from-yellow-900/30 dark:to-amber-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-smile text-yellow-600 dark:text-yellow-400 text-sm"></i>
                                </div>
                                Pre-Trade Emotion
                                <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Mindset</div>
                            </label>
                            <div class="relative">
                                <input type="text" wire:model.defer="emotionBefore" list="emotionBeforeOptions"
                                    placeholder="พิมพ์หรือเลือกอารมณ์ก่อนเทรด..."
                                    class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 shadow-sm hover:shadow-md pl-12"/>
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
                                    <i class="fas fa-heart text-sm"></i>
                                </div>
                            </div>
                            <datalist id="emotionBeforeOptions">
                                <option value="มั่นใจ">
                                <option value="กังวล">
                                <option value="ตื่นเต้น">
                                <option value="สงบ">
                                <option value="กลัว">
                                <option value="โลภ">
                                <option value="เป็นกลาง">
                                <option value="เครียด">
                                <option value="ประหม่า">
                                <option value="คาดหวัง">
                                <option value="ระมัดระวัง">
                                <option value="กระตือรือร้น">
                            </datalist>
                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">อารมณ์และจิตใจก่อนเปิดโพซิชัน</p>
                        </div>

                        <!-- Emotion After Trading -->
                        <div class="group">
                            <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                <div class="w-6 h-6 bg-gradient-to-r from-red-100 to-pink-100 dark:from-red-900/30 dark:to-pink-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-heart text-red-600 dark:text-red-400 text-sm"></i>
                                </div>
                                Post-Trade Emotion
                                <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Reflection</div>
                            </label>
                            <div class="relative">
                                <input type="text" wire:model.defer="emotionAfter" list="emotionAfterOptions"
                                    placeholder="พิมพ์หรือเลือกความรู้สึกหลังเทรด..."
                                    class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 shadow-sm hover:shadow-md pl-12"/>
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
                                    <i class="fas fa-feather text-sm"></i>
                                </div>
                            </div>
                            <datalist id="emotionAfterOptions">
                                <option value="พอใจ">
                                <option value="ผิดหวัง">
                                <option value="เสียใจ">
                                <option value="โล่งใจ">
                                <option value="หงุดหงิด">
                                <option value="ภูมิใจ">
                                <option value="เป็นกลาง">
                                <option value="เครียด">
                                <option value="งงๆ">
                                <option value="มั่นใจ">
                                <option value="ช็อค">
                                <option value="ตื่นเต้น">
                            </datalist>
                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">ความรู้สึกหลังปิดโพซิชันหรือขณะนี้</p>
                        </div>
                    </div>

                    <!-- Trading Notes -->
                    <div class="mt-8 group">
                        <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                            <div class="w-6 h-6 bg-gradient-to-r from-amber-100 to-yellow-100 dark:from-amber-900/30 dark:to-yellow-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-sticky-note text-amber-600 dark:text-amber-400 text-sm"></i>
                            </div>
                            Trading Notes & Lessons
                            <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Learning</div>
                        </label>
                        <textarea wire:model.defer="notes" rows="4"
                            placeholder="บันทึกบทเรียนที่ได้รับ, จุดที่ควรปรับปรุง, หรือข้อสังเกตจากการเทรดนี้..."
                            class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 resize-none shadow-sm hover:shadow-md"></textarea>
                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">เขียนบทเรียนและข้อสังเกตที่จะช่วยปรับปรุงการเทรดในอนาคต</p>
                    </div>

                    <!-- Chart Screenshots -->
                    <div class="mt-8">
                        <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">
                            <div class="w-6 h-6 bg-gradient-to-r from-purple-100 to-indigo-100 dark:from-purple-900/30 dark:to-indigo-900/30 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-camera text-purple-600 dark:text-purple-400 text-sm"></i>
                            </div>
                            Chart Screenshots
                            <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Optional</div>
                        </label>

                        <!-- File Upload Area -->
                        <div class="relative">
                            <input type="file" multiple wire:model="uploadedImages" accept="image/*"
                                class="w-full px-4 py-3 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-2xl bg-slate-50/50 dark:bg-slate-700/50 text-slate-700 dark:text-white mb-4
                                file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all duration-200" />

                            <!-- Loading Overlay -->
                            <div wire:loading wire:target="uploadedImages" class="absolute inset-0 bg-white/75 dark:bg-slate-800/75 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-4">
                                <div class="flex items-center space-x-3 text-blue-600 dark:text-blue-400">
                                    <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-600"></div>
                                    <span class="text-sm font-medium">กำลังประมวลผลรูปภาพ...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Error Messages -->
                        @error('uploadedImages')
                            <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-400 text-sm flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                            </div>
                        @enderror
                        @error('uploadedImages.*')
                            <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-400 text-sm flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                            </div>
                        @enderror

                        <!-- Preview or Instructions -->
                        @if ($uploadedImages && count($uploadedImages) > 0)
                            <!-- Preview Grid with Notes -->
                            <div class="space-y-4 mb-4">
                                @foreach ($uploadedImages as $index => $image)
                                    <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-5">
                                        <div class="flex flex-col md:flex-row gap-6">
                                            <!-- Image Preview -->
                                            <div class="relative flex-shrink-0">
                                                <img src="{{ $image->temporaryUrl() }}"
                                                    class="w-28 h-28 object-cover rounded-2xl border border-slate-200 dark:border-slate-600 shadow-lg"
                                                    loading="lazy"
                                                    onclick="openPreviewModal('{{ $image->temporaryUrl() }}', 'Chart {{ $index + 1 }}')">

                                                <button type="button" wire:click="removeImage({{ $index }})"
                                                    class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-7 h-7 flex items-center justify-center text-xs transition-all duration-200 shadow-lg hover:scale-110">
                                                    <i class="fas fa-times"></i>
                                                </button>

                                                <div class="absolute -bottom-2 -left-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-3 py-1 rounded-xl text-xs font-medium shadow-lg">
                                                    Chart {{ $index + 1 }}
                                                </div>
                                            </div>

                                            <!-- Note Input -->
                                            <div class="flex-1">
                                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                                    <i class="fas fa-tag text-blue-600 dark:text-blue-400 mr-2"></i>
                                                    Chart Description {{ $index + 1 }}
                                                </label>
                                                <textarea wire:model.defer="imageNotes.{{ $index }}" rows="4"
                                                    placeholder="อธิบายสิ่งที่เห็นในชาร์ต เช่น จุดเข้า, Support/Resistance, Pattern, Indicators..."
                                                    class="w-full px-4 py-3 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 text-sm resize-none"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Success Summary -->
                            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-2xl p-4">
                                <div class="flex items-center text-emerald-700 dark:text-emerald-300">
                                    <i class="fas fa-check-circle mr-3"></i>
                                    <span class="font-medium">อัพโหลดรูปภาพแล้ว: {{ count($uploadedImages) }}/10 รูป</span>
                                </div>
                            </div>
                        @else
                            <!-- Upload Instructions -->
                            <div class="bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-800/50 dark:to-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl p-8 text-center">
                                <div class="mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg">
                                        <i class="fas fa-cloud-upload-alt text-white text-2xl"></i>
                                    </div>
                                </div>
                                <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-2">Upload Chart Screenshots</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    รองรับ: JPG, PNG, GIF • สูงสุด 2MB ต่อรูป • สูงสุด 10 รูป
                                </p>

                                <!-- Upload Benefits -->
                                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                                    <div class="flex items-center justify-center space-x-2 text-slate-600 dark:text-slate-400">
                                        <i class="fas fa-chart-area text-blue-500"></i>
                                        <span>Chart Analysis</span>
                                    </div>
                                    <div class="flex items-center justify-center space-x-2 text-slate-600 dark:text-slate-400">
                                        <i class="fas fa-search text-emerald-500"></i>
                                        <span>Pattern Recognition</span>
                                    </div>
                                    <div class="flex items-center justify-center space-x-2 text-slate-600 dark:text-slate-400">
                                        <i class="fas fa-history text-purple-500"></i>
                                        <span>Trade Review</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                <!-- Back Button -->
                @if($step > 1)
                <button type="button"
                    wire:click="prevStep"
                    class="flex items-center space-x-2 px-6 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 font-medium">
                    <i class="fas fa-arrow-left"></i>
                    <span>ย้อนกลับ</span>
                </button>
                @else
                <div></div>
                @endif

                <!-- Progress Indicator (Mobile) -->
                <div class="flex md:hidden items-center space-x-2">
                    @for($i = 1; $i <= $totalSteps; $i++)
                    <div class="w-2 h-2 rounded-full {{ $i <= $step ? 'bg-blue-500' : 'bg-gray-300' }}"></div>
                    @endfor
                </div>

                <!-- Next/Submit Button -->
                <div class="flex space-x-4">
                    @if($step < $totalSteps)
                    <button type="button"
                        wire:click="nextStep"
                        class="flex items-center space-x-2 px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-200 font-medium shadow-lg">
                        <span>ขั้นตอนต่อไป</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    @else
                    <button type="submit"
                        class="flex items-center space-x-2 px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 font-medium shadow-lg">
                        <i class="fas fa-save"></i>
                        <span>บันทึกการเทรด</span>
                    </button>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Simple Preview Modal (ใส่ท้ายหน้า) -->
    <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <!-- Close Button -->
        <button onclick="closePreviewModal()"
                class="absolute top-4 right-4 z-10 w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-200">
            <i class="fas fa-times text-xl"></i>
        </button>

        <!-- Image Container -->
        <div class="relative max-w-full max-h-full" onclick="closePreviewModal()">
            <img id="previewImage"
                src=""
                alt="Preview"
                class="max-w-full max-h-full object-contain rounded-lg shadow-2xl"
                onclick="event.stopPropagation()">

            <!-- Image Title -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-70 text-white px-4 py-2 rounded-lg">
                <p id="previewTitle" class="text-sm font-medium"></p>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('success'))
    <div class="fixed top-6 right-6 z-50 max-w-sm">
        <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 animate-slide-in-right">
            <i class="fas fa-check-circle text-xl"></i>ไ
            <div>
                <p class="font-semibold">สำเร็จ!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif
</div>
