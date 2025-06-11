<section class="gradient-bg text-white py-16 px-6 mt-20" x-data="{ yearly: false }">
    <div class="max-w-4xl mx-auto text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">
            เลือกแผนที่เหมาะกับคุณ
        </h1>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            เริ่มต้นฟรี แล้วอัปเกรดเมื่อคุณพร้อมจะเป็นเทรดเดอร์ระดับโปร
        </p>

        <!-- Billing Toggle -->
        {{-- <div class="flex items-center justify-center mb-12">
            <span class="text-blue-100 mr-3">รายเดือน</span>
            <button
                @click="yearly = !yearly"
                class="relative inline-flex h-8 w-14 items-center rounded-full pricing-toggle transition-colors focus:outline-none"
            >
                <span
                    :class="yearly ? 'translate-x-7' : 'translate-x-1'"
                    class="inline-block h-6 w-6 transform rounded-full bg-white transition-transform"
                ></span>
            </button>
            <span class="text-blue-100 ml-3">รายปี</span>
            <span class="ml-3 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-sm font-semibold">
                ประหยัด 20%
            </span>
        </div> --}}
    </div>
</section>
