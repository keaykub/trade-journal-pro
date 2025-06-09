<section class="relative min-h-screen gradient-bg flex items-center justify-center overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="blob w-72 h-72 bg-purple-300 top-10 left-10"></div>
    <div class="blob w-96 h-96 bg-blue-300 top-20 right-10" style="animation-delay: 2s;"></div>
    <div class="blob w-64 h-64 bg-indigo-300 bottom-20 left-20" style="animation-delay: 4s;"></div>

    <div class="relative z-10 text-center px-6 max-w-5xl mx-auto">
        <div class="floating-animation">
            <h1 class="text-5xl md:text-7xl font-black mb-6 text-white leading-tight">
                บันทึกการเทรด<br/>
                <span class="text-gradient bg-clip-text text-transparent bg-gradient-to-r from-yellow-400 to-pink-400">อย่างมืออาชีพ</span>
            </h1>
        </div>
        <p class="text-xl md:text-2xl mb-8 text-blue-100 max-w-3xl mx-auto leading-relaxed">
            เครื่องมือบันทึก วิเคราะห์ และเข้าใจตัวเองในการเทรด<br/>
            พร้อม <span class="font-semibold text-yellow-300">AI โค้ช</span> ที่จะช่วยให้คุณเทรดดีขึ้น
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-white text-blue-600 font-bold px-8 py-4 rounded-full shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all glow-effect">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    ไปที่ Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-white text-blue-600 font-bold px-8 py-4 rounded-full shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all glow-effect">
                    <i class="fas fa-rocket mr-2"></i>
                    เริ่มต้นใช้ฟรี
                </a>
            @endauth
            <a href="#demo" class="border-2 border-white text-white font-semibold px-8 py-4 rounded-full hover:bg-white hover:text-blue-600 transition-all">
                <i class="fas fa-play mr-2"></i>
                ดูตัวอย่าง
            </a>
        </div>

        <!-- Trust Indicators -->
        <div class="flex flex-wrap justify-center items-center gap-8 text-blue-200">
            <div class="flex items-center gap-2">
                <i class="fas fa-shield-alt"></i>
                <span>ปลอดภัย 100%</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-credit-card"></i>
                <span>ใช้งานง่าย</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-users"></i>
                <span>เทรดเดอร์ 10,000+ คน</span>
            </div>
        </div>
    </div>
</section>
