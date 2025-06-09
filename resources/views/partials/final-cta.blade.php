<section class="gradient-bg py-20 px-6 text-center relative overflow-hidden">
    <div class="blob w-96 h-96 bg-white opacity-10 top-0 right-0"></div>
    <div class="blob w-64 h-64 bg-yellow-300 opacity-20 bottom-0 left-0" style="animation-delay: 3s;"></div>

    <div class="relative z-10 max-w-4xl mx-auto">
        <h2 class="text-4xl md:text-5xl font-bold mb-6 text-white">
            พร้อมจะเป็นเทรดเดอร์ที่ดีขึ้นหรือยัง?
        </h2>
        <p class="mb-8 text-xl text-blue-100 max-w-2xl mx-auto">
            เริ่มบันทึกและวิเคราะห์การเทรดวันนี้<br/>
            <span class="font-semibold text-yellow-300">ฟรี — ปลอดภัย — ใช้งานได้ทันที</span>
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-white text-blue-600 px-8 py-4 font-bold rounded-full shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all glow-effect">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    ไปที่ Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-4 font-bold rounded-full shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all glow-effect">
                    <i class="fas fa-rocket mr-2"></i>
                    สมัครใช้งานฟรี
                </a>
            @endauth
            <a href="{{ route('demo') }}" class="border-2 border-white text-white font-semibold px-8 py-4 rounded-full hover:bg-white hover:text-blue-600 transition-all">
                <i class="fas fa-eye mr-2"></i>
                ดูการใช้งานจริง
            </a>
        </div>

        <p class="text-blue-200 text-sm">
            เข้าร่วมกับเทรดเดอร์มากกว่า 10,000 คนที่เชื่อมั่นในเรา
        </p>
    </div>
</section>
