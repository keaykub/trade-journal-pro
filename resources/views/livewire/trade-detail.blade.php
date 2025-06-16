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
                            <div class="bg-slate-100 dark:bg-slate-700 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <img src="{{ env('AWS_URL', 'https://pub-16760dab33ab4d1db0e1252b4577c03e.r2.dev') . '/' . $image['path'] }}"
                                    alt="Trade Image {{ $index + 1 }}"
                                    class="w-full h-64 object-cover cursor-pointer transition-all duration-300"
                                    onclick="openImageModal({{ $index }})">

                                <!-- Image Number Badge -->
                                <div class="absolute top-3 left-3 bg-black bg-opacity-70 text-white text-xs px-3 py-1 rounded-full font-medium backdrop-blur-sm">
                                    {{ $index + 1 }}/{{ count($trade->images) }}
                                </div>
                            </div>

                            <!-- Image Note -->
                            @if(isset($image['note']) && $image['note'])
                            <div class="mt-3 p-4 bg-gradient-to-r from-slate-50 to-blue-50 dark:from-slate-800 dark:to-slate-700 rounded-lg border border-slate-200 dark:border-slate-600">
                                <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed">
                                    <i class="fas fa-quote-left text-blue-500 mr-2 text-xs"></i>
                                    {{ $image['note'] }}
                                </p>
                            </div>
                            @endif

                            <!-- Image Info -->
                            <div class="mt-3 flex justify-between items-center text-xs text-slate-500 dark:text-slate-400">
                                <span class="flex items-center">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ \Carbon\Carbon::parse($image['uploaded_at'])->format('d/m/Y H:i') }}
                                </span>
                                @if(isset($image['size']))
                                <span class="flex items-center">
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
                            </div>
                        </div>
                        @endif

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

        <!-- Enhanced Image Modal -->
        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-95 z-50 hidden items-center justify-center p-4">
            <!-- Close Button -->
            <button onclick="closeImageModal()"
                    class="absolute top-4 right-4 z-30 w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-200 backdrop-blur-sm">
                <i class="fas fa-times text-xl"></i>
            </button>

            <!-- Navigation Buttons -->
            <button onclick="previousImage()"
                    id="prevBtn"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 z-30 w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-200 backdrop-blur-sm">
                <i class="fas fa-chevron-left text-xl"></i>
            </button>

            <button onclick="nextImage()"
                    id="nextBtn"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 z-30 w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-200 backdrop-blur-sm">
                <i class="fas fa-chevron-right text-xl"></i>
            </button>

            <!-- Zoom Controls -->
            <div class="absolute top-4 left-4 z-30 flex flex-col space-y-2">
                <button onclick="zoomIn()"
                        id="zoomInBtn"
                        class="w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-200 backdrop-blur-sm">
                    <i class="fas fa-plus text-xl"></i>
                </button>
                <button onclick="zoomOut()"
                        id="zoomOutBtn"
                        class="w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-200 backdrop-blur-sm">
                    <i class="fas fa-minus text-xl"></i>
                </button>
                <button onclick="resetZoom()"
                        id="resetZoomBtn"
                        class="w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-200 backdrop-blur-sm">
                    <i class="fas fa-home text-xl"></i>
                </button>
            </div>

            <!-- Zoom Info -->
            <div class="absolute bottom-4 left-4 z-30 bg-black bg-opacity-70 text-white px-4 py-2 rounded-lg backdrop-blur-sm">
                <div class="text-xs space-y-1">
                    <div>Zoom: <span id="zoomLevel">100%</span></div>
                    <div>Size: <span id="imageDimensions">-</span></div>
                </div>
            </div>

            <!-- Image Counter -->
            <div class="absolute top-4 left-1/2 transform -translate-x-1/2 z-30 bg-black bg-opacity-70 text-white px-4 py-2 rounded-lg backdrop-blur-sm">
                <span id="imageCounter" class="text-sm font-medium">1 / 1</span>
            </div>

            <!-- Image Container -->
            <div class="relative max-w-full max-h-full flex items-center justify-center overflow-hidden">
                <div id="imageWrapper" class="transition-transform duration-300 ease-out cursor-grab active:cursor-grabbing">
                    <img id="modalImage"
                        src=""
                        alt="Trade Image"
                        class="max-w-none h-auto object-contain rounded-lg shadow-2xl transition-all duration-300 select-none"
                        onclick="event.stopPropagation()"
                        draggable="false">
                </div>
            </div>

            <!-- Image Note -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 z-30 bg-black bg-opacity-70 text-white px-6 py-3 rounded-lg backdrop-blur-sm max-w-md text-center">
                <p id="imageNote" class="text-sm leading-relaxed">ไม่มีหมายเหตุ</p>
            </div>

            <!-- Keyboard Instructions -->
            <div class="absolute bottom-4 right-4 z-30 bg-black bg-opacity-70 text-white px-4 py-2 rounded-lg backdrop-blur-sm text-xs">
                <div class="space-y-1">
                    <div><span class="bg-white bg-opacity-20 px-2 py-1 rounded font-mono text-xs">Esc</span> Close</div>
                    <div><span class="bg-white bg-opacity-20 px-2 py-1 rounded font-mono text-xs">←→</span> Navigate</div>
                    <div><span class="bg-white bg-opacity-20 px-2 py-1 rounded font-mono text-xs">+/-</span> Zoom</div>
                    <div><span class="bg-white bg-opacity-20 px-2 py-1 rounded font-mono text-xs">0</span> Reset</div>
                    <div><span class="bg-white bg-opacity-20 px-2 py-1 rounded font-mono text-xs">Wheel</span> Zoom</div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // ข้อมูลรูปภาพจาก Laravel
    const tradeImages = @json($trade->images ?? []);
    const baseUrl = '{{ env("AWS_URL", "https://pub-16760dab33ab4d1db0e1252b4577c03e.r2.dev") }}';

    let currentImageIndex = 0;
    let isModalOpen = false;
    let touchStartX = 0;
    let touchStartY = 0;

    // Zoom variables
    let currentZoom = 1;
    let maxZoom = 5;
    let minZoom = 0.1;
    let isDragging = false;
    let lastPanX = 0;
    let lastPanY = 0;
    let startX = 0;
    let startY = 0;

    // เปิด Modal
    function openImageModal(index) {
        currentImageIndex = index;
        isModalOpen = true;
        currentZoom = 1;
        lastPanX = 0;
        lastPanY = 0;
        updateModalImage();

        const modal = document.getElementById('imageModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';

        // เพิ่ม animation เข้า
        setTimeout(() => {
            modal.style.opacity = '1';
        }, 10);

        console.log('Opened image modal for index:', index);
    }

    // ปิด Modal
    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        isModalOpen = false;

        // เพิ่ม animation ออก
        modal.style.opacity = '0';

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
            currentImageIndex = 0;
            resetZoom();
        }, 200);

        console.log('Closed image modal');
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

        // เพิ่ม loading effect
        modalImage.style.opacity = '0.5';
        modalImage.src = imageUrl;
        modalImage.alt = `Trade Image ${currentImageIndex + 1}`;

        // เมื่อรูปโหลดเสร็จ
        modalImage.onload = function() {
            modalImage.style.opacity = '1';
            resetZoom(); // Reset zoom เมื่อเปลี่ยนรูป
            updateImageDimensions();
        };

        // อัพเดทข้อมูล
        imageNote.textContent = image.note || 'ไม่มีหมายเหตุ';
        imageCounter.textContent = `${currentImageIndex + 1} / ${tradeImages.length}`;

        // แสดง/ซ่อนปุ่ม navigation
        if (tradeImages.length <= 1) {
            prevBtn.classList.add('hidden');
            nextBtn.classList.add('hidden');
        } else {
            prevBtn.classList.remove('hidden');
            nextBtn.classList.remove('hidden');
        }

        console.log('Updated modal image:', imageUrl);
    }

    // Zoom Functions
    function zoomIn() {
        if (currentZoom < maxZoom) {
            currentZoom = Math.min(currentZoom * 1.2, maxZoom);
            updateImageTransform();
            updateZoomInfo();
            updateCursor();
        }
    }

    function zoomOut() {
        if (currentZoom > minZoom) {
            currentZoom = Math.max(currentZoom / 1.2, minZoom);

            // ถ้า zoom น้อยกว่า 1 ให้ reset position
            if (currentZoom <= 1) {
                lastPanX = 0;
                lastPanY = 0;
            }

            updateImageTransform();
            updateZoomInfo();
            updateCursor();
        }
    }

    function resetZoom() {
        currentZoom = 1;
        lastPanX = 0;
        lastPanY = 0;
        updateImageTransform();
        updateZoomInfo();
        updateCursor();
    }

    function updateImageTransform() {
        const imageWrapper = document.getElementById('imageWrapper');
        if (imageWrapper) {
            imageWrapper.style.transform = `scale(${currentZoom}) translate(${lastPanX}px, ${lastPanY}px)`;
        }
    }

    function updateZoomInfo() {
        const zoomLevel = document.getElementById('zoomLevel');
        if (zoomLevel) {
            zoomLevel.textContent = `${Math.round(currentZoom * 100)}%`;
        }
    }

    function updateImageDimensions() {
        const modalImage = document.getElementById('modalImage');
        const dimensionsEl = document.getElementById('imageDimensions');

        if (modalImage && dimensionsEl && modalImage.naturalWidth) {
            dimensionsEl.textContent = `${modalImage.naturalWidth} × ${modalImage.naturalHeight}px`;
        }
    }

    function updateCursor() {
        const imageWrapper = document.getElementById('imageWrapper');
        if (imageWrapper) {
            if (currentZoom > 1) {
                imageWrapper.classList.add('cursor-grab');
                imageWrapper.classList.remove('cursor-default');
            } else {
                imageWrapper.classList.remove('cursor-grab');
                imageWrapper.classList.add('cursor-default');
            }
        }
    }

    // Mouse/Touch drag functionality
    function startDrag(e) {
        if (currentZoom <= 1) return;

        isDragging = true;
        const imageWrapper = document.getElementById('imageWrapper');
        imageWrapper.classList.add('active:cursor-grabbing');

        if (e.type === 'mousedown') {
            startX = e.clientX - lastPanX;
            startY = e.clientY - lastPanY;
        } else if (e.type === 'touchstart') {
            startX = e.touches[0].clientX - lastPanX;
            startY = e.touches[0].clientY - lastPanY;
        }

        e.preventDefault();
    }

    function drag(e) {
        if (!isDragging || currentZoom <= 1) return;

        e.preventDefault();

        if (e.type === 'mousemove') {
            lastPanX = e.clientX - startX;
            lastPanY = e.clientY - startY;
        } else if (e.type === 'touchmove') {
            lastPanX = e.touches[0].clientX - startX;
            lastPanY = e.touches[0].clientY - startY;
        }

        updateImageTransform();
    }

    function endDrag() {
        isDragging = false;
        const imageWrapper = document.getElementById('imageWrapper');
        imageWrapper.classList.remove('active:cursor-grabbing');
    }

    // รูปก่อนหน้า
    function previousImage() {
        if (tradeImages.length <= 1) return;

        currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : tradeImages.length - 1;
        updateModalImage();

        // เพิ่ม feedback animation
        const prevBtn = document.getElementById('prevBtn');
        prevBtn.style.transform = 'scale(0.9)';
        setTimeout(() => {
            prevBtn.style.transform = 'scale(1)';
        }, 150);
    }

    // รูปถัดไป
    function nextImage() {
        if (tradeImages.length <= 1) return;

        currentImageIndex = currentImageIndex < tradeImages.length - 1 ? currentImageIndex + 1 : 0;
        updateModalImage();

        // เพิ่ม feedback animation
        const nextBtn = document.getElementById('nextBtn');
        nextBtn.style.transform = 'scale(0.9)';
        setTimeout(() => {
            nextBtn.style.transform = 'scale(1)';
        }, 150);
    }

    // Keyboard controls
    document.addEventListener('keydown', function(e) {
        if (!isModalOpen) return;

        switch(e.key) {
            case 'Escape':
                closeImageModal();
                break;
            case 'ArrowLeft':
                if (tradeImages.length > 1) {
                    e.preventDefault();
                    previousImage();
                }
                break;
            case 'ArrowRight':
                if (tradeImages.length > 1) {
                    e.preventDefault();
                    nextImage();
                }
                break;
            case ' ': // Spacebar
                e.preventDefault();
                if (tradeImages.length > 1) {
                    nextImage();
                }
                break;
            case '+':
            case '=':
                e.preventDefault();
                zoomIn();
                break;
            case '-':
                e.preventDefault();
                zoomOut();
                break;
            case '0':
                e.preventDefault();
                resetZoom();
                break;
        }
    });

    // เมื่อ DOM โหลดเสร็จ
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('imageModal');
        const imageWrapper = document.getElementById('imageWrapper');

        // เพิ่ม transition styles
        modal.style.transition = 'opacity 0.2s ease-in-out';
        modal.style.opacity = '0';

        // Mouse events สำหรับ drag
        imageWrapper.addEventListener('mousedown', startDrag);
        document.addEventListener('mousemove', drag);
        document.addEventListener('mouseup', endDrag);

        // Touch events สำหรับ drag
        imageWrapper.addEventListener('touchstart', startDrag, { passive: false });
        document.addEventListener('touchmove', drag, { passive: false });
        document.addEventListener('touchend', endDrag);

        // Mouse wheel zoom
        modal.addEventListener('wheel', function(e) {
            if (!isModalOpen) return;

            e.preventDefault();

            if (e.deltaY < 0) {
                zoomIn();
            } else {
                zoomOut();
            }
        }, { passive: false });

        // Touch/Swipe support สำหรับ navigation (ไม่ใช่ zoom)
        let isNavigationSwipe = false;

        modal.addEventListener('touchstart', function(e) {
            if (e.touches.length === 1 && currentZoom <= 1) {
                touchStartX = e.touches[0].clientX;
                touchStartY = e.touches[0].clientY;
                isNavigationSwipe = true;
            }
        }, { passive: true });

        modal.addEventListener('touchend', function(e) {
            if (!isNavigationSwipe || !touchStartX || !touchStartY) return;

            const touchEndX = e.changedTouches[0].clientX;
            const touchEndY = e.changedTouches[0].clientY;

            const diffX = touchStartX - touchEndX;
            const diffY = touchStartY - touchEndY;

            // ตรวจสอบว่าเป็นการ swipe แนวนอนและระยะทางเพียงพอ
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50 && currentZoom <= 1) {
                if (diffX > 0 && tradeImages.length > 1) {
                    nextImage();
                } else if (diffX < 0 && tradeImages.length > 1) {
                    previousImage();
                }
            }

            touchStartX = 0;
            touchStartY = 0;
            isNavigationSwipe = false;
        }, { passive: true });

        // คลิกนอกรูปเพื่อปิด modal
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeImageModal();
            }
        });

        // เพิ่ม transition styles สำหรับ modal image
        const modalImage = document.getElementById('modalImage');
        modalImage.style.transition = 'opacity 0.3s ease-in-out';

        // เพิ่ม transition styles สำหรับปุ่ม
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const zoomInBtn = document.getElementById('zoomInBtn');
        const zoomOutBtn = document.getElementById('zoomOutBtn');
        const resetZoomBtn = document.getElementById('resetZoomBtn');

        [prevBtn, nextBtn, zoomInBtn, zoomOutBtn, resetZoomBtn].forEach(btn => {
            if (btn) btn.style.transition = 'all 0.15s ease-in-out';
        });

        // เพิ่ม hover effects สำหรับ thumbnail images
        const thumbnails = document.querySelectorAll('[onclick*="openImageModal"]');
        thumbnails.forEach(thumbnail => {
            thumbnail.style.transition = 'all 0.3s ease-in-out';

            thumbnail.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
                this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.2)';
            });

            thumbnail.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
            });
        });

        console.log('Enhanced Trade Image Modal with Zoom Ready! 📸🔍');
        console.log('Found', tradeImages.length, 'images');
        console.log('Features: Zoom, Pan, Keyboard navigation, Touch/Swipe, Smooth animations');
    });

    // เพิ่มฟังก์ชันสำหรับ copy share URL (ถ้ามี)
    function copyShareUrl() {
        const urlInput = document.getElementById('shareUrlInput');
        if (urlInput) {
            urlInput.select();
            urlInput.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(urlInput.value).then(function() {
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check mr-2"></i>Copied!';
                button.classList.add('bg-green-600');

                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('bg-green-600');
                }, 2000);
            }).catch(function() {
                document.execCommand('copy');
            });
        }
    }

    // Preload images สำหรับ performance ที่ดีขึ้น
    function preloadImages() {
        if (tradeImages && tradeImages.length > 0) {
            tradeImages.forEach((image, index) => {
                const img = new Image();
                img.src = baseUrl + '/' + image.path;
            });
            console.log('Preloaded', tradeImages.length, 'images for faster viewing');
        }
    }

    // เรียก preload เมื่อหน้าโหลดเสร็จ
    window.addEventListener('load', preloadImages);
    </script>
</div>
