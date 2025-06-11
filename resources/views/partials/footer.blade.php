<footer class="bg-gray-900 text-gray-300 py-12 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <img src="{{ asset('logo/logo-40-40.png') }}"
                         alt="Wick Fill Logo"
                         class="h-8 w-auto">
                    <div class="flex flex-col">
                        <span class="text-lg font-bold text-white">Wick Fill</span>
                        <span class="text-xs text-blue-400 font-semibold -mt-1">TRADE JOURNAL</span>
                    </div>
                </div>
                <p class="text-gray-400 leading-relaxed">เครื่องมือบันทึกและวิเคราะห์การเทรดสำหรับเทรดเดอร์ที่ต้องการพัฒนาทักษะอย่างต่อเนื่อง</p>
            </div>

            <div>
                <h4 class="font-semibold text-white mb-4">ฟีเจอร์</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-blue-400 transition-colors">บันทึกการเทรด</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition-colors">วิเคราะห์สถิติ</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition-colors">แชร์ผลงาน</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition-colors">Export ข้อมูล</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-white mb-4">บริษัท</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('about') }}" class="hover:text-blue-400 transition-colors">เกี่ยวกับเรา</a></li>
                    <li><a href="{{ route('pricing') }}" class="hover:text-blue-400 transition-colors">แผนราคา</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition-colors">นโยบายความเป็นส่วนตัว</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition-colors">เงื่อนไขการใช้งาน</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-white mb-4">ช่วยเหลือ</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('faq') }}" class="hover:text-blue-400 transition-colors">คำถามที่พบบ่อย</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition-colors">วิธีใช้งาน</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition-colors">ติดต่อสนับสนุน</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition-colors">รายงานปัญหา</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-center md:text-left">
                    <p class="text-gray-400 mb-2">© {{ date('Y') }} Wick Fill Trade Journal. สงวนลิขสิทธิ์.</p>
                    <p class="text-sm text-gray-500">Made with ❤️ for traders in Thailand</p>
                </div>

                <div class="flex flex-col items-center md:items-end mt-4 md:mt-0">
                    <div class="flex space-x-4 mb-2">
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors" title="Facebook">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors" title="Line">
                            <i class="fab fa-line text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors" title="YouTube">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors" title="Email">
                            <i class="fas fa-envelope text-xl"></i>
                        </a>
                    </div>
                    <p class="text-xs text-gray-500">ติดตามข่าวสารและเทคนิคการเทรด</p>
                </div>
            </div>
        </div>
    </div>
</footer>
