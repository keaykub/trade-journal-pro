<section class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white py-12 sm:py-16 px-4 sm:px-6 lg:px-8 mt-20" x-data="{ search: '' }">
    <div class="max-w-5xl mx-auto text-center">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 sm:mb-6 leading-normal">
            คำถามที่พบบ่อย
        </h1>
        <p class="text-base sm:text-lg lg:text-xl text-blue-100 mb-6 sm:mb-8 max-w-3xl mx-auto leading-relaxed">
            ค้นหาคำตอบที่คุณต้องการ หรือติดต่อทีมงานเราได้ตลอดเวลา
        </p>

        <!-- Search Box - Pure Tailwind -->
        <div class="max-w-2xl mx-auto">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-blue-400 z-10"></i>
                <input
                    type="text"
                    x-model="search"
                    placeholder="ค้นหาคำถาม..."
                    class="w-full pl-12 pr-4 py-3 sm:py-4 rounded-full border-0 text-blue-900 text-base sm:text-lg bg-white shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-300/30 transition-all duration-300 placeholder-blue-400"
                />
            </div>
        </div>
    </div>
</section>
