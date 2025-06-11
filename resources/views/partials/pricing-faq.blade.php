<section class="py-20 px-6 bg-gradient-to-b from-blue-50 to-white" x-data="{ active: null }">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-2xl mb-6">
                <i class="fas fa-question-circle text-white text-2xl"></i>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">
                คำถามที่พบบ่อย
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                คำตอบสำหรับคำถามที่เทรดเดอร์ส่วนใหญ่อยากรู้
            </p>
        </div>

        <div class="space-y-6">
            <!-- FAQ 1 -->
            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                <button
                    @click="active = active === 1 ? null : 1"
                    class="w-full text-left p-6 md:p-8 flex justify-between items-center hover:bg-blue-50 transition-colors group"
                >
                    <span class="font-bold text-lg text-gray-800 group-hover:text-blue-700 transition-colors">ทดลองใช้ฟรีได้กี่วัน?</span>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300" :class="{ 'rotate-180': active === 1 }"></i>
                    </div>
                </button>
                <div x-show="active === 1" x-transition class="px-6 md:px-8 pb-6 md:pb-8">
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-gift text-white"></i>
                            </div>
                            <div>
                                <p class="text-gray-700 font-medium mb-2">
                                    เรามีแพลนฟรีให้ทดลองใช้ได้ไม่จำกัดวัน!
                                </p>
                                <p class="text-gray-600">
                                    คุณสามารถใช้งานฟีเจอร์พื้นฐานได้ตลอดชีวิต ไม่มีการเรียกเก็บเงินใดๆ
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                <button
                    @click="active = active === 2 ? null : 2"
                    class="w-full text-left p-6 md:p-8 flex justify-between items-center hover:bg-blue-50 transition-colors group"
                >
                    <span class="font-bold text-lg text-gray-800 group-hover:text-blue-700 transition-colors">ตัดเงินรายเดือนอัติโนมัติหรือเปล่า?</span>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300" :class="{ 'rotate-180': active === 2 }"></i>
                    </div>
                </button>
                <div x-show="active === 2" x-transition class="px-6 md:px-8 pb-6 md:pb-8">
                    <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-6 border border-green-200">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-shield-alt text-white"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-700 font-bold mb-4 text-lg">
                                    ไม่มีการตัดเงินอัตโนมัติ - เราใช้ระบบชำระเงินแบบ Manual Payment เท่านั้น
                                </p>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-white rounded-lg p-4 border border-green-200">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-lock text-green-600 mr-2"></i>
                                            <h4 class="font-semibold text-gray-800">ความปลอดภัย</h4>
                                        </div>
                                        <p class="text-gray-600 text-sm">คุณควบคุมการชำระเงินได้เต็มที่</p>
                                    </div>
                                    <div class="bg-white rounded-lg p-4 border border-blue-200">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-eye text-blue-600 mr-2"></i>
                                            <h4 class="font-semibold text-gray-800">โปร่งใส</h4>
                                        </div>
                                        <p class="text-gray-600 text-sm">จ่ายเท่าที่เห็น ไม่มีค่าธรรมเนียมซ่อน</p>
                                    </div>
                                    <div class="bg-white rounded-lg p-4 border border-purple-200">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-clock text-purple-600 mr-2"></i>
                                            <h4 class="font-semibold text-gray-800">ยืดหยุ่น</h4>
                                        </div>
                                        <p class="text-gray-600 text-sm">ต่ออายุเมื่อไหร่ก็ได้ตามความสะดวก</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                <button
                    @click="active = active === 3 ? null : 3"
                    class="w-full text-left p-6 md:p-8 flex justify-between items-center hover:bg-blue-50 transition-colors group"
                >
                    <span class="font-bold text-lg text-gray-800 group-hover:text-blue-700 transition-colors">ข้อมูลการเทรดปลอดภัยไหม?</span>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300" :class="{ 'rotate-180': active === 3 }"></i>
                    </div>
                </button>
                <div x-show="active === 3" x-transition class="px-6 md:px-8 pb-6 md:pb-8">
                    <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl p-6 border border-purple-200">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-shield-alt text-white"></i>
                            </div>
                            <div>
                                <p class="text-gray-700 font-medium mb-3">
                                    ข้อมูลของคุณปลอดภัย 100%
                                </p>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span class="text-gray-600">เข้ารหัสด้วย SSL 256-bit</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span class="text-gray-600">ไม่เก็บข้อมูลการเข้าสู่ระบบของโบรกเกอร์</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span class="text-gray-600">เซิร์ฟเวอร์ตั้งอยู่ในประเทศไทย</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                <button
                    @click="active = active === 4 ? null : 4"
                    class="w-full text-left p-6 md:p-8 flex justify-between items-center hover:bg-blue-50 transition-colors group"
                >
                    <span class="font-bold text-lg text-gray-800 group-hover:text-blue-700 transition-colors">รองรับโบรกเกอร์ไหนบ้าง?</span>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300" :class="{ 'rotate-180': active === 4 }"></i>
                    </div>
                </button>
                <div x-show="active === 4" x-transition class="px-6 md:px-8 pb-6 md:pb-8">
                    <div class="bg-gradient-to-r from-orange-50 to-blue-50 rounded-xl p-6 border border-orange-200">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-building text-white"></i>
                            </div>
                            <div>
                                <p class="text-gray-700 font-medium mb-3">
                                    รองรับทุกโบรกเกอร์ 100%
                                </p>
                                <p class="text-gray-600 mb-4">
                                    เพราะคุณบันทึกข้อมูลเองผ่านระบบ ไม่ต้องเชื่อมต่อกับโบรกเกอร์โดยตรง
                                </p>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    <div class="bg-white rounded-lg p-3 text-center border border-gray-200">
                                        <div class="text-2xl mb-1">📈</div>
                                        <div class="text-xs text-gray-600">Forex</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-3 text-center border border-gray-200">
                                        <div class="text-2xl mb-1">₿</div>
                                        <div class="text-xs text-gray-600">Crypto</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-3 text-center border border-gray-200">
                                        <div class="text-2xl mb-1">📊</div>
                                        <div class="text-xs text-gray-600">Stocks</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-3 text-center border border-gray-200">
                                        <div class="text-2xl mb-1">🛢️</div>
                                        <div class="text-xs text-gray-600">Commodities</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 5 - Additional -->
            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                <button
                    @click="active = active === 5 ? null : 5"
                    class="w-full text-left p-6 md:p-8 flex justify-between items-center hover:bg-blue-50 transition-colors group"
                >
                    <span class="font-bold text-lg text-gray-800 group-hover:text-blue-700 transition-colors">สามารถยกเลิกได้ตลอดเวลาไหม?</span>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300" :class="{ 'rotate-180': active === 5 }"></i>
                    </div>
                </button>
                <div x-show="active === 5" x-transition class="px-6 md:px-8 pb-6 md:pb-8">
                    <div class="bg-gradient-to-r from-red-50 to-blue-50 rounded-xl p-6 border border-red-200">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-heart text-white"></i>
                            </div>
                            <div>
                                <p class="text-gray-700 font-medium mb-3">
                                    ยกเลิกได้ตลอดเวลา ไม่มีข้อผูกมัด
                                </p>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span class="text-gray-600">ไม่มีค่าปรับยกเลิก</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span class="text-gray-600">ใช้งานได้จนกว่าจะหมดอายุ</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span class="text-gray-600">รับประกันคืนเงิน 30 วัน</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="mt-16 text-center">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-3xl p-8 text-white">
                <div class="max-w-2xl mx-auto">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-question-circle text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">ยังมีคำถามอื่นๆ อีกไหม?</h3>
                    <p class="text-blue-100 mb-6">ทีมงานของเรายินดีตอบคำถามและให้คำปรึกษาฟรี</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="mailto:support@wickfill.com" class="inline-flex items-center bg-white text-blue-600 px-6 py-3 rounded-full font-medium hover:bg-blue-50 transition-colors">
                            <i class="fas fa-envelope mr-2"></i>
                            ส่งอีเมลถาม
                        </a>
                        <a href="https://line.me/ti/p/@mjopo" class="inline-flex items-center bg-white bg-opacity-20 text-white px-6 py-3 rounded-full font-medium hover:bg-opacity-30 transition-colors">
                            <i class="fab fa-line mr-2"></i>
                            แชทใน LINE
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
