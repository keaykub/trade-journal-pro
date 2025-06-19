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
                <h3 class="font-semibold text-gray-800 mb-2 text-center">ติดต่อทางอีเมล</h3>
                <p class="text-gray-600 mb-4 text-sm text-center leading-relaxed">
                    ส่งคำถามหรือปัญหามาหาเราได้เลย<br/>
                    ทีมงานจะตอบกลับภายใน <strong>2 ชั่วโมง</strong>
                </p>
                <div class="text-center">
                    <a href="mailto:wickfill.notifications@gmail.com?subject=ติดต่อจากหน้าเว็บ Trade Journal"
                    class="text-blue-600 font-semibold hover:text-blue-700 text-sm underline">
                        ส่งอีเมลหาเรา
                    </a>
                </div>
            </div>

            <!-- Discord Community -->
            <div class="p-6 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition-colors cursor-pointer">
                <div class="w-12 h-12 bg-indigo-600 rounded-lg mx-auto mb-4 flex items-center justify-center">
                    <svg viewBox="0 0 256 199" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="white">
                        <path d="M216.856 16.597A208.502 208.502 0 0 0 164.042 0c-2.275 4.113-4.933 9.645-6.766 14.046-19.692-2.961-39.203-2.961-58.533 0-1.832-4.4-4.55-9.933-6.846-14.046a207.809 207.809 0 0 0-52.855 16.638C5.618 67.147-3.443 116.4 1.087 164.956c22.169 16.555 43.653 26.612 64.775 33.193A161.094 161.094 0 0 0 79.735 175.3a136.413 136.413 0 0 1-21.846-10.632 108.636 108.636 0 0 0 5.356-4.237c42.122 19.702 87.89 19.702 129.51 0a131.66 131.66 0 0 0 5.355 4.237 136.07 136.07 0 0 1-21.886 10.653c4.006 8.02 8.638 15.67 13.873 22.848 21.142-6.58 42.646-16.637 64.815-33.213 5.316-56.288-9.08-105.09-38.056-148.36ZM85.474 135.095c-12.645 0-23.015-11.805-23.015-26.18s10.149-26.2 23.015-26.2c12.867 0 23.236 11.804 23.015 26.2.02 14.375-10.148 26.18-23.015 26.18Zm85.051 0c-12.645 0-23.014-11.805-23.014-26.18s10.148-26.2 23.014-26.2c12.867 0 23.236 11.804 23.015 26.2 0 14.375-10.148 26.18-23.015 26.18Z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2 text-center">ชุมชน Discord</h3>
                <p class="text-gray-600 mb-4 text-sm text-center leading-relaxed">
                    เข้าร่วมคอมมูนิตี้ของเรา<br/>
                    พูดคุย แบ่งปัน และเรียนรู้เรื่องการเทรด
                </p>
                <div class="text-center">
                    <a href="https://discord.gg/your-invite-code"
                    target="_blank"
                    class="text-indigo-600 font-semibold hover:text-indigo-700 text-sm underline">
                        เข้าร่วม Discord
                    </a>
                </div>
            </div>

            <!-- LINE Support -->
            <div class="p-6 bg-green-50 rounded-xl hover:bg-green-100 transition-colors cursor-pointer">
                <div class="w-12 h-12 bg-green-500 rounded-lg mx-auto mb-4 flex items-center justify-center">
                    <i class="fab fa-line text-white text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2 text-center">ติดต่อผ่าน LINE</h3>
                <p class="text-gray-600 mb-4 text-sm text-center leading-relaxed">
                    สะดวก ง่าย และรวดเร็ว<br/>
                    แอดไลน์เพื่อพูดคุยกับทีมงาน
                </p>
                <div class="text-center">
                    <a href="https://bit.ly/linemjopo"
                    target="_blank"
                    class="inline-block px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded-md hover:bg-green-600 transition-colors">
                        @mjopo
                    </a>
                </div>
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
