<header class="bg-white shadow-sm sticky top-0 z-50" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-sm"></i>
                </div>
                <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">Trade Journal</a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="{{ route('pricing') }}" class="text-blue-600 font-semibold">แผนราคา</a>
                <a href="{{ route('faq') }}" class="text-gray-600 hover:text-blue-600 transition-colors">คำถามที่พบบ่อย</a>
                <a href="{{ route('about') }}" class="text-gray-600 hover:text-blue-600 transition-colors">เกี่ยวกับเรา</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-6 py-2 rounded-full font-medium hover:bg-blue-700 transition-all">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-full font-medium hover:bg-blue-700 transition-all">เข้าสู่ระบบ</a>
                @endauth
            </nav>

            <!-- Mobile menu button -->
            <button @click="open = !open" class="md:hidden text-gray-600">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <nav x-show="open" x-transition class="md:hidden mt-4 pb-4">
            <div class="flex flex-col space-y-4">
                <a href="{{ route('pricing') }}" class="text-blue-600 font-semibold">แผนราคา</a>
                <a href="{{ route('faq') }}" class="text-gray-600">คำถามที่พบบ่อย</a>
                <a href="{{ route('about') }}" class="text-gray-600">เกี่ยวกับเรา</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-6 py-2 rounded-full text-center font-medium">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-full text-center font-medium">เข้าสู่ระบบ</a>
                @endauth
            </div>
        </nav>
    </div>
</header>
