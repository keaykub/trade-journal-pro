<section class="py-16 px-6">
    <div class="max-w-4xl mx-auto" x-data="{ active: null }">

        <!-- Getting Started -->
        <div id="getting-started" class="mb-16">
            <h2 class="text-3xl font-bold mb-8 text-gray-800 flex items-center">
                <i class="fas fa-rocket text-blue-600 mr-3"></i>
                เริ่มต้นใช้งาน
            </h2>

            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                    <button
                        @click="active = active === 1 ? null : 1"
                        class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors"
                    >
                        <span class="font-semibold text-gray-800">Trade Journal คืออะไร และใช้สำหรับอะไร?</span>
                        <i class="fas fa-chevron-down transition-transform duration-200" :class="{ 'rotate-180': active === 1 }"></i>
                    </button>
                    <div x-show="active === 1" x-transition class="px-6 pb-6">
                        <p class="text-gray-600 leading-relaxed">Trade Journal เป็นเครื่องมือบันทึกและวิเคราะห์การเทรดที่ออกแบบมาเพื่อเทรดเดอร์โดยเฉพาะ ช่วยให้คุณบันทึกการเทรดทุกครั้ง วิเคราะห์สถิติ ดูกราฟผลงาน และรับคำแนะนำจาก AI เพื่อปรับปรุงการเทรดให้ดีขึ้น</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                    <button
                        @click="active = active === 2 ? null : 2"
                        class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors"
                    >
                        <span class="font-semibold text-gray-800">วิธีสมัครใช้งานอย่างไร?</span>
                        <i class="fas fa-chevron-down transition-transform duration-200" :class="{ 'rotate-180': active === 2 }"></i>
                    </button>
                    <div x-show="active === 2" x-transition class="px-6 pb-6">
                        <p class="text-gray-600 leading-relaxed mb-4">การสมัครใช้งานง่ายมาก:</p>
                        <ol class="list-decimal list-inside text-gray-600 space-y-2">
                            <li>คลิก "เริ่มต้นใช้ฟรี" หรือ "สมัครใช้งาน"</li>
                            <li>กรอกอีเมลและรหัสผ่าน</li>
                            <li>ยืนยันอีเมล (ตรวจ inbox และ spam)</li>
                            <li>เริ่มบันทึกการเทรดได้ทันที</li>
                        </ol>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                    <button
                        @click="active = active === 3 ? null : 3"
                        class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors"
                    >
                        <span class="font-semibold text-gray-800">ใช้ฟรีได้นานแค่ไหน?</span>
                        <i class="fas fa-chevron-down transition-transform duration-200" :class="{ 'rotate-180': active === 3 }"></i>
                    </button>
                    <div x-show="active === 3" x-transition class="px-6 pb-6">
                        <p class="text-gray-600 leading-relaxed">แผนเริ่มต้นใช้ฟรีตลอดชีพ! คุณสามารถบันทึกเทรดได้ 50 รายการ ดูสถิติพื้นฐาน และ export CSV ได้ หากต้องการฟีเจอร์เพิ่มเติมสามารถทดลองแผนโปรหรือพรีเมียมฟรี 14 วัน</p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                    <button
                        @click="active = active === 4 ? null : 4"
                        class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors"
                    >
                        <span class="font-semibold text-gray-800">ต้องดาวน์โหลดแอปไหม?</span>
                        <i class="fas fa-chevron-down transition-transform duration-200" :class="{ 'rotate-180': active === 4 }"></i>
                    </button>
                    <div x-show="active === 4" x-transition class="px-6 pb-6">
                        <p class="text-gray-600 leading-relaxed">ไม่ต้องครับ! Trade Journal เป็น Web Application ที่ใช้งานผ่านเว็บเบราว์เซอร์ ไม่ว่าจะเป็นคอมพิวเตอร์ แท็บเล็ต หรือมือถือ สามารถเข้าใช้งานได้ทุกที่ทุกเวลา</p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                    <button
                        @click="active = active === 5 ? null : 5"
                        class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors"
                    >
                        <span class="font-semibold text-gray-800">ระบบรองรับภาษาไทยไหม?</span>
                        <i class="fas fa-chevron-down transition-transform duration-200" :class="{ 'rotate-180': active === 5 }"></i>
                    </button>
                    <div x-show="active === 5" x-transition class="px-6 pb-6">
                        <p class="text-gray-600 leading-relaxed">รองรับครับ! ระบบ Trade Journal รองรับภาษาไทยและภาษาอังกฤษ สามารถสลับภาษาได้ในหน้า Settings และ AI โค้ชสามารถสนทนาเป็นภาษาไทยได้</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="features" class="mb-16">
            <h2 class="text-3xl font-bold mb-8 text-gray-800 flex items-center">
                <i class="fas fa-cogs text-green-600 mr-3"></i>
                ฟีเจอร์
            </h2>

            <div class="space-y-4">
                <!-- FAQ Item 6 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                    <button
                        @click="active = active === 6 ? null : 6"
                        class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors"
                    >
                        <span class="font-semibold text-gray-800">บันทึกการเทรดควรมีข้อมูลอะไรบ้าง?</span>
                        <i class="fas fa-chevron-down transition-transform duration-200" :class="{ 'rotate-180': active === 6 }"></i>
                    </button>
                    <div x-show="active === 6" x-transition class="px-6 pb-6">
                        <p class="text-gray-600 leading-relaxed mb-4">ข้อมูลที่ควรบันทึกมี:</p>
                        <ul class="list-disc list-inside text-gray-600 space-y-1">
                            <li><strong>ข้อมูลพื้นฐาน:</strong> วันที่, เวลา, คู่เงิน/หุ้น</li>
                            <li><strong>จุดเทรด:</strong> จุดเข้า, Stop Loss, Take Profit, Lot Size</li>
                            <li><strong>ผลลัพธ์:</strong> กำไร/ขาดทุน, R:R Ratio</li>
                            <li><strong>กลยุทธ์:</strong> Tag กลยุทธ์ที่ใช้</li>
                            <li><strong>อารมณ์:</strong> ความรู้สึกก่อน/หลังเทรด</li>
                            <li><strong>หมายเหตุ:</strong> บันทึกเพิ่มเติมและรูปภาพ</li>
                        </ul>
                    </div>
                </div>

                <!-- Add more FAQ items for Features section -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                    <button
                        @click="active = active === 7 ? null : 7"
                        class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors"
                    >
                        <span class="font-semibold text-gray-800">AI โค้ชทำอะไรได้บ้าง?</span>
                        <i class="fas fa-chevron-down transition-transform duration-200" :class="{ 'rotate-180': active === 7 }"></i>
                    </button>
                    <div x-show="active === 7" x-transition class="px-6 pb-6">
                        <p class="text-gray-600 leading-relaxed mb-4">AI โค้ชสามารถช่วยคุณได้หลากหลาย:</p>
                        <ul class="list-disc list-inside text-gray-600 space-y-1">
                            <li>วิเคราะห์จุดแข็ง/จุดอ่อนในการเทรด</li>
                            <li>แนะนำการปรับปรุงกลยุทธ์</li>
                            <li>ตอบคำถามเกี่ยวกับการเทรด</li>
                            <li>ช่วยวางแผนการจัดการความเสี่ยง</li>
                            <li>วิเคราะห์อารมณ์และพฤติกรรมการเทรด</li>
                        </ul>
                    </div>
                </div>

                <!-- Continue with more FAQ items... -->
            </div>
        </div>

        <!-- Billing Section -->
        <div id="billing" class="mb-16">
            <h2 class="text-3xl font-bold mb-8 text-gray-800 flex items-center">
                <i class="fas fa-credit-card text-purple-600 mr-3"></i>
                การเงิน
            </h2>

            <div class="space-y-4">
                <!-- Add billing FAQ items here -->
            </div>
        </div>

        <!-- Technical Section -->
        <div id="technical" class="mb-16">
            <h2 class="text-3xl font-bold mb-8 text-gray-800 flex items-center">
                <i class="fas fa-tools text-orange-600 mr-3"></i>
                ปัญหาเทคนิค
            </h2>

            <div class="space-y-4">
                <!-- Add technical FAQ items here -->
            </div>
        </div>
    </div>
</section>
