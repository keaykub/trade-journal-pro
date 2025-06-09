<section class="py-12 px-6 -mt-8">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Getting Started -->
            <div class="category-card bg-white rounded-xl p-6 shadow-lg text-center cursor-pointer hover:shadow-xl transition-all duration-300"
                 onclick="scrollToSection('getting-started')">
                <div class="w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-rocket text-blue-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">เริ่มต้นใช้งาน</h3>
                <p class="text-gray-600 text-sm">วิธีสมัคร ลงทะเบียน และเริ่มใช้งาน</p>
                <div class="mt-4 text-blue-600 text-sm font-medium">5 คำถาม</div>
            </div>

            <!-- Features -->
            <div class="category-card bg-white rounded-xl p-6 shadow-lg text-center cursor-pointer hover:shadow-xl transition-all duration-300"
                 onclick="scrollToSection('features')">
                <div class="w-12 h-12 bg-green-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-cogs text-green-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">ฟีเจอร์</h3>
                <p class="text-gray-600 text-sm">การใช้งานฟีเจอร์ต่าง ๆ ของระบบ</p>
                <div class="mt-4 text-green-600 text-sm font-medium">8 คำถาม</div>
            </div>

            <!-- Billing -->
            <div class="category-card bg-white rounded-xl p-6 shadow-lg text-center cursor-pointer hover:shadow-xl transition-all duration-300"
                 onclick="scrollToSection('billing')">
                <div class="w-12 h-12 bg-purple-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-credit-card text-purple-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">การเงิน</h3>
                <p class="text-gray-600 text-sm">แผนราคา การชำระเงิน และการยกเลิก</p>
                <div class="mt-4 text-purple-600 text-sm font-medium">6 คำถาม</div>
            </div>

            <!-- Technical -->
            <div class="category-card bg-white rounded-xl p-6 shadow-lg text-center cursor-pointer hover:shadow-xl transition-all duration-300"
                 onclick="scrollToSection('technical')">
                <div class="w-12 h-12 bg-orange-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-tools text-orange-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">เทคนิค</h3>
                <p class="text-gray-600 text-sm">ปัญหาเทคนิคและวิธีแก้ไข</p>
                <div class="mt-4 text-orange-600 text-sm font-medium">7 คำถาม</div>
            </div>
        </div>
    </div>
</section>

<style>
.category-card {
    transition: all 0.3s ease;
}

.category-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}
</style>
