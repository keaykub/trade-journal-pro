<section class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 py-12 sm:py-16 px-4 sm:px-6 text-center relative overflow-hidden">

    <div class="relative z-10 max-w-4xl mx-auto">
        <!-- Main Heading -->
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 sm:mb-6 text-white">
            พร้อมจะเป็นเทรดเดอร์ที่ดีขึ้นหรือยัง?
        </h2>

        <!-- Subtitle -->
        <div class="mb-6 sm:mb-8">
            <p class="text-base sm:text-lg lg:text-xl text-blue-100 max-w-2xl mx-auto leading-relaxed">
                เริ่มบันทึกและวิเคราะห์การเทรดวันนี้
            </p>
            <p class="mt-2 text-sm sm:text-base font-medium text-blue-200">
                <span class="text-white">ฟรี</span> •
                <span class="text-white">ปลอดภัย</span> •
                <span class="text-white">ใช้งานได้ทันที</span>
            </p>
        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center mb-6 sm:mb-8">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-white text-blue-700 px-6 sm:px-7 py-3 sm:py-3.5 font-semibold rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 hover:bg-blue-50 group">
                    <i class="fas fa-tachometer-alt mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                    <span class="text-sm sm:text-base">ไปที่ Dashboard</span>
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-white text-blue-700 px-6 sm:px-7 py-3 sm:py-3.5 font-semibold rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 hover:bg-blue-50 group">
                    <i class="fas fa-rocket mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                    <span class="text-sm sm:text-base">สมัครใช้งานฟรี</span>
                </a>
            @endauth
        </div>

        <!-- Trust indicator -->
        <div class="text-blue-200 text-sm">
            <p>เข้าร่วมกับเทรดเดอร์มากกว่า <span class="font-semibold text-white">500+</span> คน</p>
        </div>

        <!-- Trust badges -->
        <div class="mt-6 flex flex-wrap justify-center items-center gap-4 sm:gap-6 text-blue-200 text-xs">
            <div class="flex items-center space-x-1.5">
                <i class="fas fa-shield-alt text-blue-300"></i>
                <span>ปลอดภัย 100%</span>
            </div>
            <div class="flex items-center space-x-1.5">
                <i class="fas fa-mobile-alt text-blue-300"></i>
                <span>ใช้งานทุกอุปกรณ์</span>
            </div>
            <div class="flex items-center space-x-1.5">
                <i class="fas fa-clock text-blue-300"></i>
                <span>ใช้ได้ทันที</span>
            </div>
        </div>
    </div>
</section>
