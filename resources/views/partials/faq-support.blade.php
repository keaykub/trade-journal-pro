<section class="py-16 px-6 bg-white">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">
            ไม่เจอคำตอบที่ต้องการ?
        </h2>
        <p class="text-xl text-gray-600 mb-8">
            ทีมงานเราพร้อมช่วยเหลือคุณตลอด 24 ชั่วโมง
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Email Support -->
            <div class="p-6 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors cursor-pointer">
                <div class="w-12 h-12 bg-blue-600 rounded-lg mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-envelope text-white text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">อีเมล</h3>
                <p class="text-gray-600 mb-4 text-sm">ส่งคำถามมาหาเรา<br/>ตอบกลับภายใน 2 ชั่วโมง</p>
                <a href="mailto:support@tradejournal.co" class="text-blue-600 font-semibold hover:text-blue-700 text-sm">
                    support@tradejournal.co
                </a>
            </div>

            <!-- Live Chat -->
            <div class="p-6 bg-green-50 rounded-xl hover:bg-green-100 transition-colors cursor-pointer">
                <div class="w-12 h-12 bg-green-600 rounded-lg mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-comments text-white text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Live Chat</h3>
                <p class="text-gray-600 mb-4 text-sm">แชทสดกับทีมงาน<br/>พร้อมช่วยเหลือตลอด 24 ชม.</p>
                <button class="text-green-600 font-semibold hover:text-green-700 text-sm" onclick="openChat()">
                    เริ่มแชท
                </button>
            </div>

            <!-- LINE Support -->
            <div class="p-6 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors cursor-pointer">
                <div class="w-12 h-12 bg-purple-600 rounded-lg mx-auto mb-4 flex items-center justify-center">
                    <i class="fab fa-line text-white text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">LINE</h3>
                <p class="text-gray-600 mb-4 text-sm">ติดต่อผ่าน LINE<br/>สะดวกและรวดเร็ว</p>
                <a href="https://line.me/ti/p/@tradejournal" target="_blank" class="text-purple-600 font-semibold hover:text-purple-700 text-sm">
                    @tradejournal
                </a>
            </div>
        </div>

        <!-- Newsletter Signup -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl p-8 text-white">
            <h3 class="text-2xl font-bold mb-4">🎯 เคล็ดลับการใช้งาน</h3>
            <p class="text-blue-100 mb-6">
                สมัครรับข้อมูลเคล็ดลับการเทรดและการใช้งาน Trade Journal อย่างมืออาชีพ
            </p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto" x-data="{ email: '', subscribed: false }">
                <input
                    type="email"
                    x-model="email"
                    placeholder="อีเมลของคุณ"
                    class="flex-1 px-4 py-3 rounded-lg border-0 text-gray-800"
                    required
                />
                <button
                    type="submit"
                    @click.prevent="subscribed = true; email = ''"
                    class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors whitespace-nowrap"
                >
                    <span x-show="!subscribed">สมัครรับ</span>
                    <span x-show="subscribed" class="text-green-600">✓ สมัครแล้ว</span>
                </button>
            </form>
        </div>
    </div>
</section>
