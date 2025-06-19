<section class="py-20 px-6 bg-gradient-to-b from-indigo-50 to-white" x-data="{ active: null }">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">
                คำถามที่พบบ่อย
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                คำตอบสำหรับคำถามเกี่ยวกับการชำระเงินและการใช้งานระบบ
            </p>
        </div>

        <div class="space-y-6">
            <!-- FAQ 1 -->
            <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                <button
                    @click="active = active === 1 ? null : 1"
                    class="w-full text-left p-6 md:p-8 flex justify-between items-center hover:bg-indigo-50 transition-colors group"
                >
                    <span class="font-bold text-lg text-gray-800 group-hover:text-indigo-700 transition-colors">ทดลองใช้ฟรีได้กี่วัน?</span>
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600 transition-transform duration-300" :class="{ 'rotate-180': active === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>
                <div x-show="active === 1" x-transition class="px-6 md:px-8 pb-6 md:pb-8">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-700 font-medium mb-2">
                                    ทดลองใช้ฟรี 14 วัน ไม่ต้องใส่บัตรเครดิต
                                </p>
                                <p class="text-gray-600">
                                    เข้าถึงฟีเจอร์ทั้งหมดได้เต็มที่ หลังจากนั้นเลือกแพลนที่เหมาะกับคุณ
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                <button
                    @click="active = active === 2 ? null : 2"
                    class="w-full text-left p-6 md:p-8 flex justify-between items-center hover:bg-indigo-50 transition-colors group"
                >
                    <span class="font-bold text-lg text-gray-800 group-hover:text-indigo-700 transition-colors">ระบบตัดเงินอัตโนมัติทำงานอย่างไร?</span>
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600 transition-transform duration-300" :class="{ 'rotate-180': active === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>
                <div x-show="active === 2" x-transition class="px-6 md:px-8 pb-6 md:pb-8">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-700 font-bold mb-4 text-lg">
                                    ใช้ Stripe ระบบชำระเงินระดับโลก ปลอดภัย 100%
                                </p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-white rounded-lg p-4 border border-blue-200">
                                        <div class="flex items-center mb-2">
                                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                            <h4 class="font-semibold text-gray-800">การตัดเงิน</h4>
                                        </div>
                                        <p class="text-gray-600 text-sm">ตัดเงินทุกเดือนตามวันที่สมัคร ไม่มีค่าธรรมเนียมเพิ่มเติม</p>
                                    </div>
                                    <div class="bg-white rounded-lg p-4 border border-green-200">
                                        <div class="flex items-center mb-2">
                                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <h4 class="font-semibold text-gray-800">ความปลอดภัย</h4>
                                        </div>
                                        <p class="text-gray-600 text-sm">เข้ารหัส PCI DSS Level 1 ไม่เก็บข้อมูลบัตรในระบบ</p>
                                    </div>
                                </div>
                                <div class="mt-4 p-4 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg border border-yellow-200">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                        </svg>
                                        <p class="text-gray-700 font-medium">สามารถยกเลิกการใช้งานได้ตลอดเวลา</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                <button
                    @click="active = active === 3 ? null : 3"
                    class="w-full text-left p-6 md:p-8 flex justify-between items-center hover:bg-indigo-50 transition-colors group"
                >
                    <span class="font-bold text-lg text-gray-800 group-hover:text-indigo-700 transition-colors">รองรับบัตรเครดิต/เดบิตอะไรบ้าง?</span>
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600 transition-transform duration-300" :class="{ 'rotate-180': active === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>
                <div x-show="active === 3" x-transition class="px-6 md:px-8 pb-6 md:pb-8">
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-700 font-medium mb-4">
                                    รองรับบัตรเครดิต/เดบิตทุกประเภทจากธนาคารไทยและต่างประเทศ
                                </p>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                    <div class="bg-white rounded-lg p-3 text-center border border-gray-200 shadow-sm">
                                        <div class="text-2xl mb-1 font-bold text-blue-600">VISA</div>
                                        <div class="text-xs text-gray-600">Visa Card</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-3 text-center border border-gray-200 shadow-sm">
                                        <div class="text-2xl mb-1 font-bold text-red-600">MC</div>
                                        <div class="text-xs text-gray-600">MasterCard</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-3 text-center border border-gray-200 shadow-sm">
                                        <div class="text-2xl mb-1 font-bold text-blue-800">AMEX</div>
                                        <div class="text-xs text-gray-600">American Express</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-3 text-center border border-gray-200 shadow-sm">
                                        <div class="text-2xl mb-1 font-bold text-purple-600">JCB</div>
                                        <div class="text-xs text-gray-600">JCB Card</div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-600 text-sm">รองรับบัตรจากธนาคารไทยทุกแห่ง</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-600 text-sm">รองรับบัตรต่างประเทศ (รองรับ 3D Secure)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                <button
                    @click="active = active === 4 ? null : 4"
                    class="w-full text-left p-6 md:p-8 flex justify-between items-center hover:bg-indigo-50 transition-colors group"
                >
                    <span class="font-bold text-lg text-gray-800 group-hover:text-indigo-700 transition-colors">สามารถยกเลิกการสมัครสมาชิกได้ไหม?</span>
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600 transition-transform duration-300" :class="{ 'rotate-180': active === 4 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>
                <div x-show="active === 4" x-transition class="px-6 md:px-8 pb-6 md:pb-8">
                    <div class="bg-gradient-to-r from-green-50 to-teal-50 rounded-xl p-6 border border-green-200">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-700 font-medium mb-3">
                                    ยกเลิกได้ตลอดเวลา ไม่มีข้อผูกมัด
                                </p>
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-600 text-sm">ยกเลิกได้ทันทีจากหน้าการตั้งค่าบัญชี</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-600 text-sm">ไม่มีค่าปรับหรือค่าธรรมเนียมยกเลิก</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-600 text-sm">ใช้งานได้จนกว่าจะหมดรอบการเรียกเก็บเงิน</span>
                                    </div>
                                </div>
                                <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                                    <p class="text-blue-800 text-sm font-medium">
                                        💡 หลังยกเลิก: ข้อมูลจะถูกเก็บไว้ 90 วัน กรณีต้องการกลับมาใช้งาน
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                <button
                    @click="active = active === 5 ? null : 5"
                    class="w-full text-left p-6 md:p-8 flex justify-between items-center hover:bg-indigo-50 transition-colors group"
                >
                    <span class="font-bold text-lg text-gray-800 group-hover:text-indigo-700 transition-colors">มีใบเสร็จรับเงิน/ใบกำกับภาษีไหม?</span>
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600 transition-transform duration-300" :class="{ 'rotate-180': active === 5 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>
                <div x-show="active === 5" x-transition class="px-6 md:px-8 pb-6 md:pb-8">
                    <div class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl p-6 border border-orange-200">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-700 font-medium mb-3">
                                    มีใบเสร็จและใบกำกับภาษีครบถ้วน
                                </p>
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-600 text-sm">ส่งใบเสร็จอัตโนมัติทางอีเมลทุกครั้งที่ชำระเงิน</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-600 text-sm">ดาวน์โหลดใบกำกับภาษีได้จากระบบ</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-600 text-sm">รองรับการออกใบกำกับภาษีเต็มรูปแบบสำหรับนิติบุคคล</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="p-3 bg-white rounded-lg border border-gray-200">
                                        <p class="font-medium text-gray-800 text-sm">ใบเสร็จรับเงิน</p>
                                        <p class="text-gray-600 text-xs">PDF รูปแบบมาตรฐาน</p>
                                    </div>
                                    <div class="p-3 bg-white rounded-lg border border-gray-200">
                                        <p class="font-medium text-gray-800 text-sm">ใบกำกับภาษี</p>
                                        <p class="text-gray-600 text-xs">รวม VAT 7% ตามกฎหมาย</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Security Badge -->
        <div class="mt-12 text-center">
            <div class="inline-flex items-center space-x-6 bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                <div class="flex items-center space-x-2">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <div class="text-left">
                        <p class="font-bold text-gray-800">Stripe</p>
                        <p class="text-xs text-gray-600">PCI DSS Level 1</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <div class="text-left">
                        <p class="font-bold text-gray-800">256-bit SSL</p>
                        <p class="text-xs text-gray-600">การเข้ารหัส</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-left">
                        <p class="font-bold text-gray-800">3D Secure</p>
                        <p class="text-xs text-gray-600">ตรวจสอบตัวตน</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
