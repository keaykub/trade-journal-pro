<div class="min-h-screen dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <div class="px-6 py-6">

        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800 dark:text-white mb-2">Trading Analytics</h1>
                    <p class="text-slate-600 dark:text-slate-400">การวิเคราะห์เชิงลึกและสถิติการเทรด</p>
                </div>

                <!-- Date Range Filter -->
                <div class="mt-4 md:mt-0 flex items-center space-x-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">วันที่เริ่มต้น</label>
                        <input type="date" wire:model.live="dateFrom"
                            class="px-3 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">วันที่สิ้นสุด</label>
                        <input type="date" wire:model.live="dateTo"
                            class="px-3 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm dark:text-white">
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <!-- Total Trades -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-4 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-bar text-white text-sm"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-full">Total</span>
                </div>
                <div class="text-2xl font-bold text-slate-800 dark:text-white">{{ number_format($totalTrades) }}</div>
                <div class="text-xs text-slate-600 dark:text-slate-400">เทรดทั้งหมด</div>
            </div>

            <!-- Win Rate -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-4 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-gradient-to-r from-emerald-600 to-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-trophy text-white text-sm"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-full">Win Rate</span>
                </div>
                <div class="text-2xl font-bold text-emerald-600">{{ $winRate }}%</div>
                <div class="text-xs text-slate-600 dark:text-slate-400">อัตราชนะ</div>
            </div>

            <!-- Total P&L -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-4 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-gradient-to-r {{ $totalPnl >= 0 ? 'from-emerald-600 to-green-600' : 'from-red-600 to-rose-600' }} rounded-lg flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-white text-sm"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-full">P&L</span>
                </div>
                <div class="text-2xl font-bold {{ $totalPnl >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                    {{ $totalPnl >= 0 ? '+' : '' }}${{ number_format($totalPnl, 2) }}
                </div>
                <div class="text-xs text-slate-600 dark:text-slate-400">กำไรขาดทุนรวม</div>
            </div>

            <!-- Average RR -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-4 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-balance-scale text-white text-sm"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-full">Avg RR</span>
                </div>
                <div class="text-2xl font-bold text-purple-600">1:{{ $averageRiskReward }}</div>
                <div class="text-xs text-slate-600 dark:text-slate-400">ค่าเฉลี่ย R:R</div>
            </div>

            <!-- Profit Factor -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-4 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-gradient-to-r from-amber-600 to-orange-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-sm"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-full">PF</span>
                </div>
                <div class="text-2xl font-bold {{ $profitFactor >= 1.5 ? 'text-emerald-600' : ($profitFactor >= 1 ? 'text-amber-600' : 'text-red-600') }}">
                    {{ $profitFactor == 999 ? '∞' : $profitFactor }}
                </div>
                <div class="text-xs text-slate-600 dark:text-slate-400">Profit Factor</div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">

            <!-- Equity Curve -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-chart-line mr-2 text-blue-600"></i>
                    Equity Curve
                </h3>
                <div class="h-64" id="equityCurveChart">
                    <div class="flex items-center justify-center h-full text-slate-400">
                        <div class="text-center">
                            <i class="fas fa-chart-line text-4xl mb-2"></i>
                            <p>กราฟ Equity Curve</p>
                            <p class="text-sm">แสดงความเปลี่ยนแปลงของกำไรสะสม</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- P&L Distribution -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-chart-pie mr-2 text-emerald-600"></i>
                    P&L Distribution
                </h3>
                <div class="h-64" id="pnlChart">
                    <div class="grid grid-cols-2 gap-4 h-full">
                        @foreach($pnlDistribution as $item)
                        <div class="flex items-center justify-between p-3 rounded-lg border border-slate-200 dark:border-slate-700">
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 rounded-full" style="background-color: {{ $item['color'] }}"></div>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $item['label'] }}</span>
                            </div>
                            <span class="text-lg font-bold text-slate-800 dark:text-white">{{ $item['value'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Strategy & Emotion Analysis -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">

            <!-- Strategy Usage -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-chess mr-2 text-indigo-600"></i>
                    กลยุทธ์ที่ใช้บ่อยที่สุด
                </h3>
                <div class="space-y-3">
                    @foreach($strategyUsage as $strategy)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50 dark:bg-slate-700/50">
                        <span class="font-medium text-slate-800 dark:text-white">{{ $strategy['strategy'] }}</span>
                        <div class="flex items-center space-x-2">
                            <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ ($strategy['count'] / max(array_column($strategyUsage, 'count'))) * 100 }}px; min-width: 20px;"></div>
                            <span class="text-sm font-bold text-slate-600 dark:text-slate-400">{{ $strategy['count'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Emotion Analysis -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-heart mr-2 text-pink-600"></i>
                    การวิเคราะห์อารมณ์
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($emotionAnalysis as $emotion)
                    <div class="flex items-center justify-between p-3 rounded-lg border border-slate-200 dark:border-slate-700">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full" style="background-color: {{ $emotion['color'] }}"></div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $emotion['label'] }}</span>
                        </div>
                        <span class="text-sm font-bold text-slate-800 dark:text-white">{{ $emotion['value'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Time Analysis -->
        <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg mb-8">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center">
                <i class="fas fa-clock mr-2 text-amber-600"></i>
                การวิเคราะห์ตามเวลา
            </h3>
            <div class="h-64" id="timeAnalysisChart">
                <div class="flex items-center justify-center h-full text-slate-400">
                    <div class="text-center">
                        <i class="fas fa-clock text-4xl mb-2"></i>
                        <p>กราฟการเทรดตามช่วงเวลา</p>
                        <p class="text-sm">แสดงจำนวนเทรดและผลกำไรในแต่ละช่วงเวลา</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Analysis -->
        <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-6 border border-white/20 dark:border-slate-700/50 shadow-lg">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                <i class="fas fa-trophy mr-2 text-yellow-600"></i>
                การวิเคราะห์ผลงาน
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            <!-- Best Strategy -->
            <div class="p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                <div class="flex items-center space-x-2 mb-3">
                    <i class="fas fa-trophy text-green-600"></i>
                    <h4 class="font-semibold text-green-800 dark:text-green-300">กลยุทธ์ที่ดีที่สุด</h4>
                </div>
                @if($performanceAnalysis['bestStrategy'])
                <div class="space-y-2">
                    <!-- เพิ่มชื่อกลยุทธ์ -->
                    <div class="text-sm font-medium text-green-700 dark:text-green-400 mb-1">
                        {{ $performanceAnalysis['bestStrategy']['name'] ?? 'ไม่ระบุ' }}
                    </div>
                    <div class="text-lg font-bold text-green-600">${{ number_format($performanceAnalysis['bestStrategy']['pnl'], 2) }}</div>
                    <div class="text-sm text-green-700 dark:text-green-400">
                        {{ $performanceAnalysis['bestStrategy']['trades'] }} เทรด |
                        {{ round($performanceAnalysis['bestStrategy']['winRate'], 1) }}% Win Rate
                    </div>
                </div>
                @else
                <div class="text-sm text-slate-500">ไม่มีข้อมูล</div>
                @endif
            </div>

                <!-- Best Symbol -->
                <div class="p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center space-x-2 mb-3">
                        <i class="fas fa-coins text-blue-600"></i>
                        <h4 class="font-semibold text-blue-800 dark:text-blue-300">คู่เงินที่ดีที่สุด</h4>
                    </div>
                    @if($performanceAnalysis['bestSymbol'])
                    <div class="space-y-2">
                        <!-- เพิ่มชื่อคู่เงิน -->
                        <div class="text-sm font-medium text-blue-700 dark:text-blue-400 mb-1">
                            {{ $performanceAnalysis['bestSymbol']['name'] ?? 'ไม่ระบุ' }}
                        </div>
                        <div class="text-lg font-bold text-blue-600">${{ number_format($performanceAnalysis['bestSymbol']['pnl'], 2) }}</div>
                        <div class="text-sm text-blue-700 dark:text-blue-400">
                            {{ $performanceAnalysis['bestSymbol']['trades'] }} เทรด |
                            {{ round($performanceAnalysis['bestSymbol']['winRate'], 1) }}% Win Rate
                        </div>
                    </div>
                    @else
                    <div class="text-sm text-slate-500">ไม่มีข้อมูล</div>
                    @endif
                </div>

                <!-- Worst Strategy -->
                <div class="p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                    <div class="flex items-center space-x-2 mb-3">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                        <h4 class="font-semibold text-red-800 dark:text-red-300">กลยุทธ์ที่ต้องปรับปรุง</h4>
                    </div>
                    @if($performanceAnalysis['worstStrategy'])
                    <div class="space-y-2">
                        <!-- เพิ่มชื่อกลยุทธ์ -->
                        <div class="text-sm font-medium text-red-700 dark:text-red-400 mb-1">
                            {{ $performanceAnalysis['worstStrategy']['name'] ?? 'ไม่ระบุ' }}
                        </div>
                        <div class="text-lg font-bold text-red-600">${{ number_format($performanceAnalysis['worstStrategy']['pnl'], 2) }}</div>
                        <div class="text-sm text-red-700 dark:text-red-400">
                            {{ $performanceAnalysis['worstStrategy']['trades'] }} เทรด |
                            {{ round($performanceAnalysis['worstStrategy']['winRate'], 1) }}% Win Rate
                        </div>
                    </div>
                    @else
                    <div class="text-sm text-slate-500">ไม่มีข้อมูล</div>
                    @endif
                </div>

                <!-- Worst Symbol -->
            <div class="p-4 rounded-xl bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800">
                <div class="flex items-center space-x-2 mb-3">
                    <i class="fas fa-chart-line-down text-orange-600"></i>
                    <h4 class="font-semibold text-orange-800 dark:text-orange-300">คู่เงินที่ต้องระวัง</h4>
                </div>
                @if($performanceAnalysis['worstSymbol'])
                <div class="space-y-2">
                    <!-- เพิ่มชื่อคู่เงิน -->
                    <div class="text-sm font-medium text-orange-700 dark:text-orange-400 mb-1">
                        {{ $performanceAnalysis['worstSymbol']['name'] ?? 'ไม่ระบุ' }}
                    </div>
                    <div class="text-lg font-bold text-orange-600">${{ number_format($performanceAnalysis['worstSymbol']['pnl'], 2) }}</div>
                    <div class="text-sm text-orange-700 dark:text-orange-400">
                        {{ $performanceAnalysis['worstSymbol']['trades'] }} เทรด |
                        {{ round($performanceAnalysis['worstSymbol']['winRate'], 1) }}% Win Rate
                    </div>
                </div>
                @else
                <div class="text-sm text-slate-500">ไม่มีข้อมูล</div>
                @endif
            </div>
            </div>
        </div>

        <!-- No Data Message -->
        @if($totalTrades == 0)
        <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-12 border border-white/20 dark:border-slate-700/50 shadow-lg text-center">
            <div class="w-20 h-20 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-chart-bar text-slate-400 dark:text-slate-500 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">ไม่มีข้อมูลสำหรับวิเคราะห์</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-6">ยังไม่มีข้อมูลการเทรดในช่วงเวลาที่เลือก</p>
            <a href="{{ route('trade') }}"
               class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all duration-200 font-medium">
                <i class="fas fa-plus mr-2"></i>
                เริ่มบันทึกการเทรด
            </a>
        </div>
        @endif

    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sample chart implementations - replace with actual data

    // Equity Curve Chart
    if (document.getElementById('equityCurveChart') && @json($totalTrades) > 0) {
        const equityData = @json($equityCurveData);
        const ctx1 = document.createElement('canvas');
        document.getElementById('equityCurveChart').innerHTML = '';
        document.getElementById('equityCurveChart').appendChild(ctx1);

        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: equityData.map(item => item.date),
                datasets: [{
                    label: 'Balance',
                    data: equityData.map(item => item.balance),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Time Analysis Chart
    if (document.getElementById('timeAnalysisChart') && @json($totalTrades) > 0) {
        const timeData = @json($timeAnalysis);
        const ctx2 = document.createElement('canvas');
        document.getElementById('timeAnalysisChart').innerHTML = '';
        document.getElementById('timeAnalysisChart').appendChild(ctx2);

        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: timeData.map(item => item.hour),
                datasets: [{
                    label: 'จำนวนเทรด',
                    data: timeData.map(item => item.trades),
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderColor: '#3b82f6',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
});

// Livewire refresh charts when data changes
document.addEventListener('livewire:updated', function () {
    // Re-initialize charts after Livewire updates
    setTimeout(() => {
        const event = new Event('DOMContentLoaded');
        document.dispatchEvent(event);
    }, 100);
});
</script>
