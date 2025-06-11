<section class="relative min-h-screen bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-700 flex items-center justify-center overflow-hidden">
    <!-- Animated Background Elements - ซ่อนในมือถือ -->
    <div class="blob w-48 h-48 sm:w-64 sm:h-64 lg:w-72 lg:h-72 bg-purple-300 absolute top-10 left-5 sm:left-10 hidden sm:block"></div>
    <div class="blob w-64 h-64 sm:w-80 sm:h-80 lg:w-96 lg:h-96 bg-blue-300 absolute top-20 right-5 sm:right-10 hidden sm:block" style="animation-delay: 2s;"></div>
    <div class="blob w-40 h-40 sm:w-56 sm:h-56 lg:w-64 lg:h-64 bg-indigo-300 absolute bottom-20 left-10 sm:left-20 hidden sm:block" style="animation-delay: 4s;"></div>

    <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto py-12 sm:py-16 lg:py-20">
        <!-- Main Heading -->
        <div class="floating mb-6 sm:mb-8 lg:mb-10">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-black text-white leading-tight sm:leading-tight lg:leading-tight">
                บันทึกการเทรด<br class="hidden sm:block"/>
                <span class="sm:hidden"> </span>
                <span class="bg-gradient-to-r from-yellow-400 via-orange-400 to-pink-400 bg-clip-text text-transparent">
                    อย่างมืออาชีพ
                </span>
            </h1>
        </div>

        <!-- Description -->
        <div class="mb-8 sm:mb-10 lg:mb-12">
            <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-blue-100 max-w-4xl mx-auto leading-relaxed px-2">
                เครื่องมือบันทึก วิเคราะห์ และพัฒนาทักษะการเทรดของคุณ<br class="hidden sm:block"/>
                <span class="sm:hidden"> </span>
                พร้อม <span class="font-semibold text-yellow-300">รายงานสถิติ</span> ที่ช่วยให้คุณเทรดดีขึ้น
            </p>
        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 lg:gap-6 justify-center items-center mb-10 sm:mb-12 lg:mb-16">
            <!-- Primary Button -->
            <a href="{{ route('login') }}" class="w-full sm:w-auto bg-white text-blue-600 font-bold px-6 sm:px-8 lg:px-10 py-3 sm:py-4 rounded-full shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 glow-effect text-sm sm:text-base lg:text-lg">
                <i class="fas fa-rocket mr-2"></i>
                เริ่มต้นใช้ฟรี
            </a>

            <!-- Secondary Button -->
            <a href="#demo" class="w-full sm:w-auto border-2 border-white text-white font-semibold px-6 sm:px-8 lg:px-10 py-3 sm:py-4 rounded-full hover:bg-white hover:text-blue-600 transition-all duration-300 text-sm sm:text-base lg:text-lg">
                <i class="fas fa-play mr-2"></i>
                ดูตัวอย่าง
            </a>
        </div>

        <!-- Trust Indicators -->
        <div class="flex flex-col sm:flex-row flex-wrap justify-center items-center gap-4 sm:gap-6 lg:gap-8 text-blue-200 text-sm sm:text-base">
            <div class="flex items-center gap-2 px-4 py-2 bg-white bg-opacity-10 rounded-full backdrop-blur-sm">
                <i class="fas fa-shield-alt text-green-300"></i>
                <span>ปลอดภัย 100%</span>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-white bg-opacity-10 rounded-full backdrop-blur-sm">
                <i class="fas fa-chart-line text-yellow-300"></i>
                <span>วิเคราะห์แม่นยำ</span>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-white bg-opacity-10 rounded-full backdrop-blur-sm">
                <i class="fas fa-users text-blue-300"></i>
                <span>เทรดเดอร์ 500+ คน</span>
            </div>
        </div>

        <!-- Mobile-specific additional spacing -->
        <div class="h-8 sm:h-0"></div>
    </div>

    <!-- Scroll indicator (visible only on larger screens) -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 hidden lg:block">
        <div class="animate-bounce">
            <i class="fas fa-chevron-down text-white text-2xl opacity-70"></i>
        </div>
    </div>
</section>
