<footer class="bg-gray-900 text-gray-300 py-12 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold text-white">Trade Journal</span>
                </div>
                <p class="text-gray-400">เครื่องมือบันทึกการเทรดสำหรับเทรดเดอร์ที่ต้องการพัฒนาตัวเอง</p>
            </div>

            <div>
                <h4 class="font-semibold text-white mb-4">ผลิตภัณฑ์</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-white transition-colors">บันทึกการเทรด</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">วิเคราะห์สถิติ</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">AI โค้ช</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-white mb-4">บริษัท</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">เกี่ยวกับเรา</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">บล็อก</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">ติดต่อเรา</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-white mb-4">ช่วยเหลือ</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('faq') }}" class="hover:text-white transition-colors">คำถามที่พบบ่อย</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">วิธีใช้งาน</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">สนับสนุน</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400">© {{ date('Y') }} Trade Journal. Made for traders, by traders.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fab fa-facebook text-xl"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fab fa-twitter text-xl"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fab fa-instagram text-xl"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fab fa-youtube text-xl"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
