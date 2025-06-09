<section class="gradient-bg text-white py-16 px-6">
    <div class="max-w-4xl mx-auto text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">
            คำถามที่พบบ่อย
        </h1>
        <p class="text-xl text-blue-100 mb-8">
            ค้นหาคำตอบที่คุณต้องการ หรือติดต่อทีมงานเราได้ตลอดเวลา
        </p>

        <!-- Search Box -->
        <div class="max-w-2xl mx-auto relative" x-data="{ search: '' }">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input
                    type="text"
                    x-model="search"
                    placeholder="ค้นหาคำถาม..."
                    class="w-full pl-12 pr-4 py-4 rounded-full border-0 text-gray-800 text-lg focus:outline-none search-focus"
                />
            </div>
        </div>
    </div>
</section>

<style>
.search-focus {
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}
</style>
