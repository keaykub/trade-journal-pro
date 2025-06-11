<section id="demo" class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-24 px-6">
    <!-- Background Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
    <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>

    <div class="relative max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-100 to-purple-100 rounded-full text-sm font-medium text-blue-800 mb-6">
                <i class="fas fa-chart-line mr-2"></i>
                ตัวอย่างผลลัพธ์
            </div>
            <h2 class="text-5xl md:text-6xl font-bold mb-6 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent">
                Dashboard ที่ครบครัน
            </h2>
            <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                ติดตามผลการเทรดแบบเรียลไทม์ วิเคราะห์สถิติ และเพิ่มประสิทธิภาพการลงทุนของคุณ
            </p>
        </div>

        <!-- Main Dashboard Container -->
        <div class="relative">
            <!-- Dashboard Frame -->
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 overflow-hidden">

                <!-- Dashboard Header -->
                <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-md border border-gray-100">
                                <img src="{{ asset('logo/logo-40-40.png') }}"
                                    alt="Wick Fill Logo"
                                    class="h-8 w-auto">
                            </div>
                            <div>
                                <h3 class="text-white text-xl font-bold">Trading Dashboard</h3>
                                <p class="text-slate-300 text-sm">Real-time Analytics</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards Section -->
                <div class="p-8 bg-gradient-to-br from-white to-slate-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                        <!-- Total Trades Card -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-chart-bar text-white"></i>
                                </div>
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">Total</span>
                            </div>
                            <div class="text-3xl font-bold text-slate-800 mb-1">157</div>
                            <div class="text-sm text-slate-500">รายการเทรดทั้งหมด</div>
                            <div class="mt-3 flex items-center text-green-600 text-sm">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>+12% จากเดือนที่แล้ว</span>
                            </div>
                        </div>

                        <!-- Win Rate Card -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-trophy text-white"></i>
                                </div>
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">Win Rate</span>
                            </div>
                            <div class="text-3xl font-bold text-emerald-600 mb-1">68.2%</div>
                            <div class="text-sm text-slate-500">อัตราชนะ</div>
                            <div class="mt-3 w-full bg-slate-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 h-2 rounded-full w-2/3 transition-all duration-1000"></div>
                            </div>
                        </div>

                        <!-- P&L Card -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-dollar-sign text-white"></i>
                                </div>
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">P&L</span>
                            </div>
                            <div class="text-3xl font-bold text-purple-600 mb-1">+$2,847.50</div>
                            <div class="text-sm text-slate-500">กำไรขาดทุนรวม</div>
                            <div class="mt-3 flex items-center text-purple-600 text-sm">
                                <i class="fas fa-trending-up mr-1"></i>
                                <span>ROI: +18.7%</span>
                            </div>
                        </div>

                        <!-- Best Strategy Card -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-chess text-white"></i>
                                </div>
                                <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-semibold rounded-full">Strategy</span>
                            </div>
                            <div class="text-2xl font-bold text-slate-800 mb-1">Breakout</div>
                            <div class="text-sm text-slate-500">กลยุทธ์ที่ดีที่สุด</div>
                            <div class="mt-3 flex items-center text-orange-600 text-sm">
                                <i class="fas fa-star mr-1"></i>
                                <span>Win Rate: 78%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Sample Trade Table -->
                    <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">

                        <div class="px-6 py-4 bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                            <div class="flex items-center justify-between">
                                <h4 class="text-lg font-bold text-slate-800">รายการเทรดล่าสุด</h4>
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <span class="text-sm text-slate-500">Live Updates</span>
                                </div>
                            </div>
                        </div>

                        <div class="overflow-hidden">
                            <table class="w-full">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Symbol</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Entry</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Exit</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">P&L</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <tr class="hover:bg-blue-50 transition-all duration-200">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                                    <i class="fas fa-arrow-up text-green-600 text-sm"></i>
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-slate-800">EURUSD</div>
                                                    <div class="text-xs text-slate-500">Buy</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-mono text-sm text-slate-700">1.08450</td>
                                        <td class="px-6 py-4 font-mono text-sm text-slate-700">1.08720</td>
                                        <td class="px-6 py-4">
                                            <span class="font-semibold text-green-600">+$270.00</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-trophy mr-1"></i>Win
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-blue-50 transition-all duration-200">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                                    <i class="fas fa-arrow-down text-red-600 text-sm"></i>
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-slate-800">GBPJPY</div>
                                                    <div class="text-xs text-slate-500">Sell</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-mono text-sm text-slate-700">186.250</td>
                                        <td class="px-6 py-4 font-mono text-sm text-slate-700">185.980</td>
                                        <td class="px-6 py-4">
                                            <span class="font-semibold text-green-600">+$340.00</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-trophy mr-1"></i>Win
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-blue-50 transition-all duration-200">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                    <i class="fas fa-clock text-blue-600 text-sm"></i>
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-slate-800">XAUUSD</div>
                                                    <div class="text-xs text-slate-500">Buy</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-mono text-sm text-slate-700">2,045.50</td>
                                        <td class="px-6 py-4">
                                            <span class="text-slate-400">-</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-semibold text-blue-600">+$125.00</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-clock mr-1"></i>Running
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Features Highlight -->
                <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-8 py-6">
                    <div class="flex flex-wrap items-center justify-center gap-6 text-white">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-chart-line text-blue-400"></i>
                            <span class="text-sm">เรียลไทม์ Analytics</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-mobile-alt text-green-400"></i>
                            <span class="text-sm">Responsive Design</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-share-alt text-purple-400"></i>
                            <span class="text-sm">แชร์ผลงาน</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-download text-orange-400"></i>
                            <span class="text-sm">Export ข้อมูล</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="text-center mt-12">
                <div class="inline-flex flex-col sm:flex-row gap-4">
                    <a href="#pricing" class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span>เริ่มใช้งานตอนนี้</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <button class="inline-flex items-center px-8 py-4 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-2xl border-2 border-gray-200 hover:border-gray-300 transition-all duration-300 shadow-md hover:shadow-lg">
                        <i class="fas fa-play mr-2"></i>
                        ดูวิดีโอสาธิต
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
