<section class="gradient-bg text-white py-20 px-6 relative overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="blob w-72 h-72 bg-purple-300 opacity-30 top-10 left-10"></div>
        <div class="blob w-96 h-96 bg-blue-300 opacity-30 top-20 right-10" style="animation-delay: 2s;"></div>
        <div class="blob w-64 h-64 bg-indigo-300 opacity-30 bottom-20 left-20" style="animation-delay: 4s;"></div>
    </div>

    <div class="max-w-4xl mx-auto text-center relative z-10">
        <div class="floating-animation">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                เราคือ <span class="text-gradient bg-clip-text text-transparent bg-gradient-to-r from-yellow-400 to-pink-400">Trade Journal</span>
            </h1>
        </div>

        <p class="text-xl md:text-2xl mb-8 text-blue-100 max-w-3xl mx-auto leading-relaxed">
            เครื่องมือที่เกิดจากประสบการณ์จริงของเทรดเดอร์<br/>
            เพื่อเทรดเดอร์ โดยเทรดเดอร์
        </p>

        <!-- Company Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-12">
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-yellow-300 mb-2">10,000+</div>
                <div class="text-blue-200">เทรดเดอร์ใช้งาน</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-yellow-300 mb-2">500K+</div>
                <div class="text-blue-200">การเทรดที่บันทึก</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-yellow-300 mb-2">2020</div>
                <div class="text-blue-200">ก่อตั้งบริษัท</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-yellow-300 mb-2">24/7</div>
                <div class="text-blue-200">การสนับสนุน</div>
            </div>
        </div>
    </div>
</section>

<style>
.floating-animation {
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(40px);
    animation: blob 7s infinite;
}

@keyframes blob {
    0%, 100% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}
</style>
