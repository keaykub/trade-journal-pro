<div>
    <!-- Main Content -->
    <div class="max-w-4xl mx-auto">

        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-slate-600 dark:text-slate-400">
                <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600">รายการเทรด</a></li>
                <li><i class="fas fa-chevron-right mx-2"></i></li>
                <li class="text-slate-800 dark:text-white font-medium">{{ $trade->symbol }}</li>
            </ol>
        </nav>

        <!-- Header with Actions -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-white mb-2">
                    การเทรด {{ $trade->symbol }}
                </h1>
                <p class="text-slate-600 dark:text-slate-400">
                    <i class="fas fa-calendar mr-2"></i>
                    {{ \Carbon\Carbon::parse($trade->entry_date)->format('d F Y') }}
                    @if($trade->entry_time)
                        เวลา {{ \Carbon\Carbon::parse($trade->entry_time)->format('H:i') }} น.
                    @endif
                </p>
            </div>

            <!-- Action Buttons -->
            {{-- <div class="mt-4 lg:mt-0 flex flex-wrap gap-3">
                <!-- Share Button -->
                <button wire:click="toggleShare"
                        class="px-4 py-2 {{ $trade->is_shared ? 'bg-green-600 hover:bg-green-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white rounded-lg transition-all duration-300 flex items-center">
                    <i class="fas {{ $trade->is_shared ? 'fa-eye' : 'fa-share-alt' }} mr-2"></i>
                    <span>{{ $trade->is_shared ? 'แชร์แล้ว' : 'แชร์' }}</span>
                </button>

                <!-- Delete Button -->
                <button wire:click="deleteTrade"
                        wire:confirm="คุณต้องการลบการเทรดนี้หรือไม่? การกระทำนี้ไม่สามารถยกเลิกได้"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-300 flex items-center">
                    <i class="fas fa-trash mr-2"></i>
                    ลบ
                </button>
            </div> --}}
        </div>

        <!-- Trade Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- P&L Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">ผลกำไรขาดทุน</h3>
                    <i class="fas fa-dollar-sign text-2xl {{ $trade->pnl >= 0 ? 'text-green-600' : 'text-red-600' }}"></i>
                </div>
                @if($trade->pnl)
                <div class="text-3xl font-bold {{ $trade->pnl >= 0 ? 'text-green-600' : 'text-red-600' }} mb-2">
                    {{ $trade->pnl >= 0 ? '+' : '' }}${{ number_format($trade->pnl, 2) }}
                </div>
                @else
                <div class="text-2xl text-slate-400">-</div>
                @endif
            </div>

            <!-- Duration Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">ระยะเวลา</h3>
                    <i class="fas fa-clock text-2xl text-blue-600"></i>
                </div>
                <div class="text-2xl text-slate-400">กำลังเทรด</div>
            </div>

            <!-- Status Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">สถานะ</h3>
                    <i class="fas fa-flag text-2xl text-purple-600"></i>
                </div>
                <div class="mb-4">
                    @if($trade->result === 'win')
                    <span class="inline-flex items-center px-3 py-2 rounded-lg text-lg font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                        <i class="fas fa-trophy mr-2"></i>Win
                    </span>
                    @elseif($trade->result === 'loss')
                    <span class="inline-flex items-center px-3 py-2 rounded-lg text-lg font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                        <i class="fas fa-times-circle mr-2"></i>Loss
                    </span>
                    @elseif($trade->result === 'breakeven')
                    <span class="inline-flex items-center px-3 py-2 rounded-lg text-lg font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                        <i class="fas fa-equals mr-2"></i>Break Even
                    </span>
                    @else
                    <span class="inline-flex items-center px-3 py-2 rounded-lg text-lg font-medium bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300">
                        <i class="fas fa-clock mr-2"></i>Pending
                    </span>
                    @endif
                </div>

                {{-- <!-- Quick Status Update -->
                <select wire:change="updateStatus($event.target.value)" class="w-full text-sm border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2 dark:bg-slate-700 dark:text-white">
                    <option value="pending" {{ $trade->result === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="win" {{ $trade->result === 'win' ? 'selected' : '' }}>Win</option>
                    <option value="loss" {{ $trade->result === 'loss' ? 'selected' : '' }}>Loss</option>
                    <option value="breakeven" {{ $trade->result === 'breakeven' ? 'selected' : '' }}>Break Even</option>
                </select> --}}
            </div>
        </div>

        <!-- Main Trade Details -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden">

            <!-- Trade Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-chart-line text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">{{ $trade->symbol }}</h2>
                            <p class="text-blue-100">{{ ucfirst($trade->order_type) }} Order</p>
                        </div>
                    </div>

                    @if($trade->is_shared)
                    <div class="text-right">
                        <div class="text-sm opacity-90 mb-1">แชร์สาธารณะ</div>
                        <a href="{{ route('trades.public', $trade->id) }}"
                           target="_blank"
                           class="inline-flex items-center text-sm bg-white/20 hover:bg-white/30 px-3 py-1 rounded-lg transition-colors">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            ดูหน้าแชร์
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Trade Details Content -->
            <div class="p-6 space-y-8">

                <!-- Entry & Exit Information -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    <!-- Entry Details -->
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-sign-in-alt text-green-600 mr-2"></i>
                            ข้อมูลการเข้า
                        </h3>

                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-slate-50 dark:bg-slate-700 rounded-lg p-4">
                                    <div class="text-sm text-slate-600 dark:text-slate-400 mb-1">วันที่เข้า</div>
                                    <div class="font-semibold text-slate-800 dark:text-white">
                                        {{ \Carbon\Carbon::parse($trade->entry_date)->format('d/m/Y') }}
                                    </div>
                                </div>

                                @if($trade->entry_time)
                                <div class="bg-slate-50 dark:bg-slate-700 rounded-lg p-4">
                                    <div class="text-sm text-slate-600 dark:text-slate-400 mb-1">เวลาเข้า</div>
                                    <div class="font-semibold text-slate-800 dark:text-white">
                                        {{ \Carbon\Carbon::parse($trade->entry_time)->format('H:i') }}
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border-l-4 border-green-500">
                                <div class="text-sm text-green-600 dark:text-green-400 font-medium mb-1">ราคาเข้า</div>
                                <div class="font-mono font-bold text-green-700 dark:text-green-300 text-xl">
                                    {{ number_format($trade->entry_price, 5) }}
                                </div>
                            </div>

                            @if($trade->lot_size)
                            <div class="bg-slate-50 dark:bg-slate-700 rounded-lg p-4">
                                <div class="text-sm text-slate-600 dark:text-slate-400 mb-1">ขนาดล็อต</div>
                                <div class="font-semibold text-slate-800 dark:text-white">{{ $trade->lot_size }}</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Exit Details -->
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-sign-out-alt text-red-600 mr-2"></i>
                            ข้อมูลการออก
                        </h3>

                        @if($trade->exit_price || $trade->exit_date)
                        <div class="space-y-4">
                            @if($trade->exit_date)
                            <div class="bg-slate-50 dark:bg-slate-700 rounded-lg p-4">
                                <div class="text-sm text-slate-600 dark:text-slate-400 mb-1">วันที่ออก</div>
                                <div class="font-semibold text-slate-800 dark:text-white">
                                    {{ \Carbon\Carbon::parse($trade->exit_date)->format('d/m/Y') }}
                                </div>
                            </div>
                            @endif

                            @if($trade->exit_price)
                            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4 border-l-4 border-red-500">
                                <div class="text-sm text-red-600 dark:text-red-400 font-medium mb-1">ราคาออก</div>
                                <div class="font-mono font-bold text-red-700 dark:text-red-300 text-xl">
                                    {{ number_format($trade->exit_price, 5) }}
                                </div>
                            </div>
                            @endif

                            @if($trade->pips)
                            <div class="bg-slate-50 dark:bg-slate-700 rounded-lg p-4">
                                <div class="text-sm text-slate-600 dark:text-slate-400 mb-1">Pips</div>
                                <div class="font-semibold {{ $trade->pips > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $trade->pips > 0 ? '+' : '' }}{{ $trade->pips }}
                                </div>
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="text-center py-8 text-slate-500 dark:text-slate-400">
                            <i class="fas fa-clock text-3xl mb-3"></i>
                            <p>ยังไม่ได้ออกจากเทรด</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Risk Management -->
                @if($trade->stop_loss || $trade->take_profit)
                <div class="border-t border-slate-200 dark:border-slate-700 pt-8">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-shield-alt text-purple-600 mr-2"></i>
                        การจัดการความเสี่ยง
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($trade->stop_loss)
                        <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-6 border-l-4 border-red-500">
                            <div class="text-sm text-red-600 dark:text-red-400 font-medium mb-2">Stop Loss</div>
                            <div class="font-mono font-bold text-red-700 dark:text-red-300 text-xl">
                                {{ number_format($trade->stop_loss, 5) }}
                            </div>
                        </div>
                        @endif

                        @if($trade->take_profit)
                        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-6 border-l-4 border-green-500">
                            <div class="text-sm text-green-600 dark:text-green-400 font-medium mb-2">Take Profit</div>
                            <div class="font-mono font-bold text-green-700 dark:text-green-300 text-xl">
                                {{ number_format($trade->take_profit, 5) }}
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($trade->risk_reward)
                    <div class="mt-6 text-center">
                        <div class="inline-flex items-center bg-blue-50 dark:bg-blue-900/20 px-6 py-3 rounded-lg border border-blue-200 dark:border-blue-800">
                            <i class="fas fa-balance-scale text-blue-600 mr-3"></i>
                            <span class="text-sm text-blue-600 dark:text-blue-400 font-medium mr-2">Risk:Reward</span>
                            <span class="text-xl font-bold text-blue-700 dark:text-blue-300">1:{{ $trade->risk_reward }}</span>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- รูปภาพการเทรด -->
                @if(!empty($trade->images) && count($trade->images) > 0)
                <div class="border-t border-slate-200 dark:border-slate-700 pt-8">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-images text-pink-600 mr-2"></i>
                        รูปภาพการเทรด
                        <span class="ml-3 text-sm bg-pink-100 dark:bg-pink-900/30 text-pink-800 dark:text-pink-300 px-3 py-1 rounded-full">
                            {{ count($trade->images) }} รูป
                        </span>
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($trade->images as $index => $image)
                        <div class="relative group">
                            <!-- Image Container -->
                            <div class="bg-slate-100 dark:bg-slate-700 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300">
                                <img src="{{ env('AWS_URL', 'https://pub-16760dab33ab4d1db0e1252b4577c03e.r2.dev') . '/' . $image['path'] }}"
                                    alt="Trade Image {{ $index + 1 }}"
                                    class="w-full h-64 object-cover cursor-pointer hover:scale-105 transition-transform duration-300"
                                    onclick="openImageModal({{ $index }})">

                                {{-- <!-- Image Overlay -->
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50 rounded-full p-3">
                                        <i class="fas fa-expand text-white text-xl"></i>
                                    </div>
                                </div> --}}

                                <!-- Image Number Badge -->
                                <div class="absolute top-3 left-3 bg-black bg-opacity-60 text-white text-xs px-2 py-1 rounded-full">
                                    {{ $index + 1 }}/{{ count($trade->images) }}
                                </div>
                            </div>

                            <!-- Image Note -->
                            @if(isset($image['note']) && $image['note'])
                            <div class="mt-3 p-3 bg-slate-50 dark:bg-slate-700 rounded-lg">
                                <p class="text-sm text-slate-700 dark:text-slate-300">
                                    <i class="fas fa-comment-alt text-blue-500 mr-2"></i>
                                    {{ $image['note'] }}
                                </p>
                            </div>
                            @endif

                            <!-- Image Info -->
                            <div class="mt-2 flex justify-between items-center text-xs text-slate-500 dark:text-slate-400">
                                <span>
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ \Carbon\Carbon::parse($image['uploaded_at'])->format('d/m/Y H:i') }}
                                </span>
                                @if(isset($image['size']))
                                <span>
                                    <i class="fas fa-file mr-1"></i>
                                    {{ number_format($image['size'] / 1024, 1) }} KB
                                </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Strategy & Notes -->
                @php
                    $displayStrategy = $trade->strategy === 'other' ? $trade->custom_strategy : $trade->strategy;
                @endphp
                @if($displayStrategy || $trade->notes || $trade->emotion_before || $trade->emotion_after)
                <div class="border-t border-slate-200 dark:border-slate-700 pt-8">

                    <!-- Strategy & Emotions Grid -->
                    @if($displayStrategy || $trade->emotion_before || $trade->emotion_after)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

                        <!-- Strategy -->
                        @if($displayStrategy)
                        <div class="group">
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center">
                                <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-chess text-indigo-600 dark:text-indigo-400"></i>
                                </div>
                                กลยุทธ์
                            </h3>
                            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl p-5 border border-indigo-200 dark:border-indigo-800 group-hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-indigo-500 rounded-full mr-3"></div>
                                    <span class="text-indigo-800 dark:text-indigo-300 font-semibold text-lg">
                                        {{ ucfirst($displayStrategy) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Emotion Before -->
                        @if($trade->emotion_before)
                        <div class="group">
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center">
                                <div class="w-8 h-8 bg-rose-100 dark:bg-rose-900/50 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-heart text-rose-600 dark:text-rose-400"></i>
                                </div>
                                อารมณ์ก่อนเทรด
                            </h3>
                            <div class="bg-gradient-to-r from-rose-50 to-pink-50 dark:from-rose-900/20 dark:to-pink-900/20 rounded-xl p-5 border border-rose-200 dark:border-rose-800 group-hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-rose-500 rounded-full mr-3"></div>
                                    <span class="text-rose-800 dark:text-rose-300 font-semibold text-lg">
                                        {{ ucfirst($trade->emotion_before) }}
                                    </span>
                                </div>
                                @php
                                    $emotionIcon = match($trade->emotion_before) {
                                        'confident' => 'fas fa-muscle',
                                        'excited' => 'fas fa-rocket',
                                        'calm' => 'fas fa-leaf',
                                        'nervous' => 'fas fa-exclamation-triangle',
                                        'anxious' => 'fas fa-clock',
                                        'fearful' => 'fas fa-shield-alt',
                                        'neutral' => 'fas fa-minus',
                                        'focused' => 'fas fa-bullseye',
                                        default => 'fas fa-question'
                                    };
                                    $emotionColor = match($trade->emotion_before) {
                                        'confident', 'excited', 'calm' => 'text-emerald-500',
                                        'nervous', 'anxious', 'fearful' => 'text-red-500',
                                        'neutral', 'focused' => 'text-blue-500',
                                        default => 'text-slate-500'
                                    };
                                @endphp
                                <div class="mt-3 flex justify-end">
                                    <div class="w-8 h-8 rounded-full bg-white dark:bg-slate-800 shadow-md flex items-center justify-center">
                                        <i class="{{ $emotionIcon }} {{ $emotionColor }} text-sm"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Emotion After -->
                        @if($trade->emotion_after)
                        <div class="group">
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center">
                                <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-smile text-emerald-600 dark:text-emerald-400"></i>
                                </div>
                                อารมณ์หลังเทรด
                            </h3>
                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl p-5 border border-emerald-200 dark:border-emerald-800 group-hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-emerald-500 rounded-full mr-3"></div>
                                    <span class="text-emerald-800 dark:text-emerald-300 font-semibold text-lg">
                                        {{ ucfirst($trade->emotion_after) }}
                                    </span>
                                </div>
                                @php
                                    $emotionAfterIcon = match($trade->emotion_after) {
                                        'satisfied' => 'fas fa-check-circle',
                                        'happy' => 'fas fa-smile',
                                        'proud' => 'fas fa-trophy',
                                        'relieved' => 'fas fa-sigh',
                                        'disappointed' => 'fas fa-frown',
                                        'frustrated' => 'fas fa-angry',
                                        'angry' => 'fas fa-fire',
                                        'regretful' => 'fas fa-sad-tear',
                                        'neutral' => 'fas fa-meh',
                                        'learned' => 'fas fa-brain',
                                        default => 'fas fa-question'
                                    };
                                    $emotionAfterColor = match($trade->emotion_after) {
                                        'satisfied', 'happy', 'proud', 'relieved' => 'text-emerald-500',
                                        'disappointed', 'frustrated', 'angry', 'regretful' => 'text-red-500',
                                        'neutral', 'learned' => 'text-blue-500',
                                        default => 'text-slate-500'
                                    };
                                @endphp
                                <div class="mt-3 flex justify-end">
                                    <div class="w-8 h-8 rounded-full bg-white dark:bg-slate-800 shadow-md flex items-center justify-center">
                                        <i class="{{ $emotionAfterIcon }} {{ $emotionAfterColor }} text-sm"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                    @endif

                    <!-- Emotion Comparison (ถ้ามีทั้งก่อนและหลัง) -->
                    @if($trade->emotion_before && $trade->emotion_after)
                    <div class="mb-8">
                        <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-6 border border-slate-200 dark:border-slate-700">
                            <h4 class="text-md font-semibold text-slate-700 dark:text-slate-300 mb-4 flex items-center">
                                <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                                การเปลี่ยนแปลงอารมณ์
                            </h4>
                            <div class="flex items-center justify-center space-x-8">
                                <div class="text-center">
                                    <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-rose-100 dark:bg-rose-900/50 flex items-center justify-center">
                                        @php
                                            $beforeIcon = match($trade->emotion_before) {
                                                'confident' => 'fas fa-muscle',
                                                'excited' => 'fas fa-rocket',
                                                'calm' => 'fas fa-leaf',
                                                'nervous' => 'fas fa-exclamation-triangle',
                                                'anxious' => 'fas fa-clock',
                                                'fearful' => 'fas fa-shield-alt',
                                                'neutral' => 'fas fa-minus',
                                                'focused' => 'fas fa-bullseye',
                                                default => 'fas fa-question'
                                            };
                                        @endphp
                                        <i class="{{ $beforeIcon }} text-rose-600 dark:text-rose-400"></i>
                                    </div>
                                    <div class="text-sm text-slate-600 dark:text-slate-400">ก่อนเทรด</div>
                                    <div class="font-medium text-slate-800 dark:text-slate-200">{{ ucfirst($trade->emotion_before) }}</div>
                                </div>

                                <div class="flex items-center text-blue-500">
                                    <i class="fas fa-arrow-right text-xl"></i>
                                </div>

                                <div class="text-center">
                                    <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center">
                                        @php
                                            $afterIcon = match($trade->emotion_after) {
                                                'satisfied' => 'fas fa-check-circle',
                                                'happy' => 'fas fa-smile',
                                                'proud' => 'fas fa-trophy',
                                                'relieved' => 'fas fa-sigh',
                                                'disappointed' => 'fas fa-frown',
                                                'frustrated' => 'fas fa-angry',
                                                'angry' => 'fas fa-fire',
                                                'regretful' => 'fas fa-sad-tear',
                                                'neutral' => 'fas fa-meh',
                                                'learned' => 'fas fa-brain',
                                                default => 'fas fa-question'
                                            };
                                        @endphp
                                        <i class="{{ $afterIcon }} text-emerald-600 dark:text-emerald-400"></i>
                                    </div>
                                    <div class="text-sm text-slate-600 dark:text-slate-400">หลังเทรด</div>
                                    <div class="font-medium text-slate-800 dark:text-slate-200">{{ ucfirst($trade->emotion_after) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Notes -->
                    @if($trade->notes)
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center">
                            <div class="w-8 h-8 bg-amber-100 dark:bg-amber-900/50 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-sticky-note text-amber-600 dark:text-amber-400"></i>
                            </div>
                            บันทึกและข้อคิด
                        </h3>
                        <div class="bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 rounded-xl p-6 border border-amber-200 dark:border-amber-800 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-start space-x-4">
                                <div class="w-1 bg-amber-400 rounded-full h-full min-h-[60px]"></div>
                                <div class="flex-1">
                                    <p class="text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line">{{ $trade->notes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
                @endif

            </div>
        </div>

        <!-- Footer Actions -->
        <div class="mt-8 text-center">
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center px-6 py-3 bg-slate-600 hover:bg-slate-700 text-white rounded-lg transition-all duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                กลับไปรายการเทรด
            </a>
        </div>

        <!-- Share Modal -->
        <div x-data="{ showShareModal: false }"
             @share-toggled.window="
                 if ($event.detail.is_shared) {
                     showShareModal = true;
                     $nextTick(() => {
                         document.getElementById('shareUrlInput').value = $event.detail.share_url;
                     });
                 }
             ">

            <div x-show="showShareModal"
                 x-cloak
                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                 @click.self="showShareModal = false">

                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-green-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-share-alt text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-white">แชร์การเทรด</h3>
                                <p class="text-sm text-slate-600 dark:text-slate-400">คัดลอกลิงก์เพื่อแชร์</p>
                            </div>
                        </div>
                        <button @click="showShareModal = false"
                                class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <!-- Share URL -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                            <i class="fas fa-link mr-2 text-blue-600"></i>ลิงก์สำหรับแชร์
                        </label>
                        <div class="flex">
                            <input type="text"
                                   value=""
                                   readonly
                                   id="shareUrlInput"
                                   class="flex-1 px-4 py-3 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-l-xl text-sm text-slate-800 dark:text-white font-mono">
                            <button onclick="copyShareUrl()"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-r-xl transition-all duration-300 font-medium">
                                <i class="fas fa-copy mr-2"></i>Copy
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <button @click="showShareModal = false"
                                class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-xl transition-all duration-300 font-medium">
                            ปิด
                        </button>
                        <button onclick="window.open(document.getElementById('shareUrlInput').value, '_blank')"
                                class="flex-1 px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl transition-all duration-300 font-medium">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            ดูหน้าแชร์
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Modal -->
        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center p-4">
            <!-- Close Button -->
            <button onclick="closeImageModal()"
                    class="absolute top-4 right-4 z-10 w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-200">
                <i class="fas fa-times text-xl"></i>
            </button>

            <!-- Navigation Buttons -->
            <button onclick="previousImage()"
                    id="prevBtn"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10 w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-200">
                <i class="fas fa-chevron-left text-lg"></i>
            </button>

            <button onclick="nextImage()"
                    id="nextBtn"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10 w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-200">
                <i class="fas fa-chevron-right text-lg"></i>
            </button>

            <!-- Image Container -->
            <div class="relative max-w-full max-h-full">
                <img id="modalImage"
                    src=""
                    alt="Trade Image"
                    class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">

                <!-- Image Info -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-70 text-white px-4 py-2 rounded-lg text-center">
                    <p id="imageNote" class="text-sm mb-1"></p>
                    <p id="imageCounter" class="text-xs opacity-75"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
<script>
// ข้อมูลรูปภาพจาก Laravel
const tradeImages = @json($trade->images ?? []);
const baseUrl = '{{ env("AWS_URL", "https://pub-16760dab33ab4d1db0e1252b4577c03e.r2.dev") }}';

let currentImageIndex = 0;

// เปิด Modal
function openImageModal(index) {
    currentImageIndex = index;
    updateModalImage();

    const modal = document.getElementById('imageModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    console.log('Opened image modal for index:', index);
}

// ปิด Modal
function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentImageIndex = 0;
}

// อัพเดทรูปใน Modal
function updateModalImage() {
    if (!tradeImages || tradeImages.length === 0) {
        console.log('No images available');
        return;
    }

    const image = tradeImages[currentImageIndex];
    const modalImage = document.getElementById('modalImage');
    const imageNote = document.getElementById('imageNote');
    const imageCounter = document.getElementById('imageCounter');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    // แสดงรูปจริง
    const imageUrl = baseUrl + '/' + image.path;
    modalImage.src = imageUrl;
    modalImage.alt = `Trade Image ${currentImageIndex + 1}`;

    // อัพเดทข้อมูล
    imageNote.textContent = image.note || 'ไม่มีหมายเหตุ';
    imageCounter.textContent = `${currentImageIndex + 1} / ${tradeImages.length}`;

    // แสดง/ซ่อนปุ่ม navigation
    if (tradeImages.length <= 1) {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
    } else {
        prevBtn.style.display = 'flex';
        nextBtn.style.display = 'flex';
    }

    console.log('Updated modal image:', imageUrl);
}

// รูปก่อนหน้า
function previousImage() {
    if (tradeImages.length <= 1) return;

    currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : tradeImages.length - 1;
    updateModalImage();
}

// รูปถัดไป
function nextImage() {
    if (tradeImages.length <= 1) return;

    currentImageIndex = currentImageIndex < tradeImages.length - 1 ? currentImageIndex + 1 : 0;
    updateModalImage();
}

// Keyboard controls
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('imageModal');
    if (!modal.classList.contains('hidden')) {
        switch(e.key) {
            case 'Escape':
                closeImageModal();
                break;
            case 'ArrowLeft':
                if (tradeImages.length > 1) previousImage();
                break;
            case 'ArrowRight':
                if (tradeImages.length > 1) nextImage();
                break;
        }
    }
});

// Touch/Swipe support
let touchStartX = 0;
let touchStartY = 0;

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('imageModal');

    modal.addEventListener('touchstart', function(e) {
        touchStartX = e.touches[0].clientX;
        touchStartY = e.touches[0].clientY;
    });

    modal.addEventListener('touchend', function(e) {
        if (!touchStartX || !touchStartY) return;

        const touchEndX = e.changedTouches[0].clientX;
        const touchEndY = e.changedTouches[0].clientY;

        const diffX = touchStartX - touchEndX;
        const diffY = touchStartY - touchEndY;

        if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
            if (diffX > 0 && tradeImages.length > 1) {
                nextImage();
            } else if (diffX < 0 && tradeImages.length > 1) {
                previousImage();
            }
        }

        touchStartX = 0;
        touchStartY = 0;
    });

    modal.addEventListener('touchmove', function(e) {
        if (!modal.classList.contains('hidden')) {
            e.preventDefault();
        }
    });

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeImageModal();
        }
    });

    console.log('Trade Image Modal Ready! 📸');
    console.log('Found', tradeImages.length, 'images');
});
</script>
</div>
