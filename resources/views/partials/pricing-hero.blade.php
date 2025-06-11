<section class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white py-12 sm:py-16 px-4 sm:px-6 lg:px-8 mt-20" x-data="{ yearly: false }">
    <div class="max-w-5xl mx-auto text-center">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 sm:mb-6 leading-normal">
            เลือกแผนที่เหมาะกับคุณ
        </h1>
        <p class="text-base sm:text-lg lg:text-xl text-blue-100 mb-6 sm:mb-8 max-w-3xl mx-auto leading-relaxed">
            เริ่มต้นฟรี แล้วอัปเกรดเมื่อคุณพร้อมจะเป็นเทรดเดอร์ระดับโปร
        </p>

        <!-- Billing Toggle (ถ้าต้องการใช้) -->
        <div class="flex items-center justify-center mb-8 sm:mb-12" style="display: none;" x-show="false">
            <span class="text-blue-100 mr-3 text-sm sm:text-base">รายเดือน</span>
            <button
                @click="yearly = !yearly"
                class="relative inline-flex h-7 w-12 sm:h-8 sm:w-14 items-center rounded-full bg-blue-500 hover:bg-blue-400 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-blue-700"
            >
                <span
                    :class="yearly ? 'translate-x-6 sm:translate-x-7' : 'translate-x-1'"
                    class="inline-block h-5 w-5 sm:h-6 sm:w-6 transform rounded-full bg-white transition-transform shadow-lg"
                ></span>
            </button>
            <span class="text-blue-100 ml-3 text-sm sm:text-base">รายปี</span>
            <span class="ml-3 bg-white text-blue-700 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-semibold shadow-lg">
                ประหยัด 20%
            </span>
        </div>
    </div>
</section>
