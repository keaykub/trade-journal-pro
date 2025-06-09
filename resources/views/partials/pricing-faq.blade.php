<section class="py-16 px-6 bg-gray-50" x-data="{ active: null }">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">
            คำถามที่พบบ่อย
        </h2>

        <div class="space-y-6">
            <!-- FAQ 1 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <button
                    @click="active = active === 1 ? null : 1"
                    class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors"
                >
                    <span class="font-semibold text-gray-800">ทดลองใช้ฟรีได้กี่วัน?</span>
                    <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': active === 1 }"></i>
                </button>
                <div x-show="active === 1" x-transition class="px-6 pb-6">
                    <p class="text-gray-600">คุณสามารถทดลองใช้แผนโปรและพรีเมียมฟรี 14 วัน โดยไม่ต้องผูกบัตรเครดิต</p>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <button
                    @click="active = active === 2 ? null : 2"
                    class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors"
                >
                    <span class="font-semibold text-gray-800">สามารถยกเลิกได้ทุกเมื่อหรือไม่?</span>
                    <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': active === 2 }"></i>
                </button>
                <div x-show="active === 2" x-transition class="px-6 pb-6">
                    <p class="text-gray-600">ได้ครับ คุณสามารถยกเลิกได้ทุกเมื่อผ่านหน้า Settings โดยไม่มีค่าธรรมเนียมยกเลิก</p>
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <button
                    @click="active = active === 3 ? null : 3"
                    class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors"
                >
                    <span class="font-semibold text-gray-800">ข้อมูลการเทรดปลอดภัยไหม?</span>
                    <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': active === 3 }"></i>
                </button>
                <div x-show="active === 3" x-transition class="px-6 pb-6">
                    <p class="text-gray-600">ข้อมูลของคุณปลอดภัย 100% เราใช้การเข้ารหัส SSL และไม่เก็บข้อมูลการเข้าสู่ระบบของโบรกเกอร์</p>
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <button
                    @click="active = active === 4 ? null : 4"
                    class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors"
                >
                    <span class="font-semibold text-gray-800">รองรับโบรกเกอร์ไหนบ้าง?</span>
                    <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': active === 4 }"></i>
                </button>
                <div x-show="active === 4" x-transition class="px-6 pb-6">
                    <p class="text-gray-600">รองรับทุกโบรกเกอร์ครับ เพราะคุณบันทึกข้อมูลเองผ่านระบบ ไม่ต้องเชื่อมต่อกับโบรกเกอร์โดยตรง</p>
                </div>
            </div>
        </div>
    </div>
</section>
