@extends('layouts.app')

@section('title', 'ตัวอย่างการใช้งาน - Trade Journal')

@section('content')
    @include('partials.navigation')

    <section class="py-20 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold mb-4 text-gray-800">
                    ตัวอย่างการใช้งาน Trade Journal
                </h1>
                <p class="text-xl text-gray-600">
                    ดูว่า Trade Journal จะช่วยเปลี่ยนการเทรดของคุณอย่างไร
                </p>
            </div>

            <!-- Sample Dashboard -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 mb-12">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Dashboard Overview</h2>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-blue-50 rounded-lg p-6 text-center">
                        <div class="text-blue-600 text-3xl font-bold">127</div>
                        <div class="text-gray-600">Total Trades</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-6 text-center">
                        <div class="text-green-600 text-3xl font-bold">68%</div>
                        <div class="text-gray-600">Win Rate</div>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-6 text-center">
                        <div class="text-purple-600 text-3xl font-bold">+15.2%</div>
                        <div class="text-gray-600">Total P/L</div>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-6 text-center">
                        <div class="text-yellow-600 text-3xl font-bold">1:2.1</div>
                        <div class="text-gray-600">Risk/Reward</div>
                    </div>
                </div>

                <!-- Sample Chart Area -->
                <div class="bg-gray-100 rounded-lg h-64 flex items-center justify-center">
                    <div class="text-center">
                        <i class="fas fa-chart-line text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">ตัวอย่างกราฟผลการเทรดรายวัน</p>
                    </div>
                </div>
            </div>

            <!-- Sample Trade Records -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Recent Trades</h2>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4">Date</th>
                                <th class="text-left py-3 px-4">Symbol</th>
                                <th class="text-left py-3 px-4">Type</th>
                                <th class="text-left py-3 px-4">Entry</th>
                                <th class="text-left py-3 px-4">Exit</th>
                                <th class="text-left py-3 px-4">P/L</th>
                                <th class="text-left py-3 px-4">Result</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="py-3 px-4">2024-12-15</td>
                                <td class="py-3 px-4 font-semibold">EUR/USD</td>
                                <td class="py-3 px-4">BUY</td>
                                <td class="py-3 px-4">1.0850</td>
                                <td class="py-3 px-4">1.0920</td>
                                <td class="py-3 px-4 text-green-600 font-semibold">+70 pips</td>
                                <td class="py-3 px-4">
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">WIN</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4">2024-12-14</td>
                                <td class="py-3 px-4 font-semibold">GBP/USD</td>
                                <td class="py-3 px-4">SELL</td>
                                <td class="py-3 px-4">1.2650</td>
                                <td class="py-3 px-4">1.2680</td>
                                <td class="py-3 px-4 text-red-600 font-semibold">-30 pips</td>
                                <td class="py-3 px-4">
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">LOSS</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4">2024-12-13</td>
                                <td class="py-3 px-4 font-semibold">USD/JPY</td>
                                <td class="py-3 px-4">BUY</td>
                                <td class="py-3 px-4">149.50</td>
                                <td class="py-3 px-4">150.20</td>
                                <td class="py-3 px-4 text-green-600 font-semibold">+70 pips</td>
                                <td class="py-3 px-4">
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">WIN</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center mt-12">
                <h3 class="text-2xl font-bold mb-4 text-gray-800">ชอบในสิ่งที่เห็นไหม?</h3>
                <p class="text-gray-600 mb-8">เริ่มใช้งาน Trade Journal วันนี้และปรับปรุงการเทรดของคุณ</p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-blue-700 transition-colors">
                        เริ่มใช้งานฟรี
                    </a>
                    <a href="{{ route('pricing') }}" class="border border-blue-600 text-blue-600 px-8 py-3 rounded-full font-semibold hover:bg-blue-50 transition-colors">
                        ดูแผนราคา
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')
@endsection
