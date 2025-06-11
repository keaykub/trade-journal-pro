<section class="py-20 px-6 gradient-bg text-white">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
            พร้อมเริ่มต้นเทรดอย่างมืออาชีพหรือยัง?
        </h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            เข้าร่วมกับเทรดเดอร์มากกว่า 500+ คนที่เชื่อมั่นในเรา<br/>
            และเริ่มเส้นทางสู่ความสำเร็จในการเทรด
        </p>

        <!-- Benefits -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="flex items-center justify-center space-x-3">
                <i class="fas fa-check-circle text-green-300"></i>
                <span>เริ่มใช้งานฟรี</span>
            </div>
            <div class="flex items-center justify-center space-x-3">
                <i class="fas fa-check-circle text-green-300"></i>
                <span>ไม่ต้องผูกบัตรเครดิต</span>
            </div>
            <div class="flex items-center justify-center space-x-3">
                <i class="fas fa-check-circle text-green-300"></i>
                <span>ข้อมูลปลอดภัย 100%</span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-white text-blue-600 px-8 py-4 font-bold rounded-full shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    ไปที่ Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-4 font-bold rounded-full shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all">
                    <i class="fas fa-rocket mr-2"></i>
                    เริ่มใช้งานฟรี
                </a>
            @endauth
            <a href="{{ route('pricing') }}" class="border-2 border-white text-white font-semibold px-8 py-4 rounded-full hover:bg-white hover:text-blue-600 transition-all">
                <i class="fas fa-eye mr-2"></i>
                ดูแผนราคา
            </a>
        </div>

        <!-- Contact Info -->
        <div class="mt-12 pt-8 border-t border-blue-400">
            <p class="text-blue-100 mb-4">มีคำถามเพิ่มเติม? ติดต่อเราได้</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="mailto:hello@tradejournal.co" class="flex items-center text-blue-100 hover:text-white transition-colors">
                    <i class="fas fa-envelope mr-2"></i>
                    -
                </a>
                <a href="https://line.me/ti/p/@tradejournal" class="flex items-center text-blue-100 hover:text-white transition-colors">
                    <i class="fab fa-line mr-2"></i>
                    @mjopo
                </a>
                <a href="tel:+66-2-123-4567" class="flex items-center text-blue-100 hover:text-white transition-colors">
                    <i class="fas fa-phone mr-2"></i>
                    -
                </a>
            </div>
        </div>
    </div>
</section>
