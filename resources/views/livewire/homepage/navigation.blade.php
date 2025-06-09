<header class="fixed w-full top-0 z-50 glass-effect">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-sm"></i>
                </div>
                <span class="text-xl font-bold text-white">Trade Journal</span>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-8 text-white">
                <a href="{{ route('pricing') }}" class="hover:text-blue-200 transition-colors">แผนราคา</a>
                <a href="{{ route('faq') }}" class="hover:text-blue-200 transition-colors">คำถามที่พบบ่อย</a>
                <a href="{{ route('about') }}" class="hover:text-blue-200 transition-colors">เกี่ยวกับเรา</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-white text-blue-600 px-6 py-2 rounded-full font-medium hover:bg-blue-50 transition-all glow-effect">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-white text-blue-600 px-6 py-2 rounded-full font-medium hover:bg-blue-50 transition-all glow-effect">เข้าสู่ระบบ</a>
                @endauth
            </nav>

            <!-- Mobile menu button -->
            <button wire:click="toggleMenu" class="md:hidden text-white">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Mobile Navigation -->
        @if($isOpen)
        <nav class="md:hidden mt-4 pb-4 transition-all duration-300">
            <div class="flex flex-col space-y-4 text-white">
                <a href="{{ route('pricing') }}" class="hover:text-blue-200">แผนราคา</a>
                <a href="{{ route('faq') }}" class="hover:text-blue-200">คำถามที่พบบ่อย</a>
                <a href="{{ route('about') }}" class="hover:text-blue-200">เกี่ยวกับเรา</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-white text-blue-600 px-6 py-2 rounded-full text-center font-medium">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-white text-blue-600 px-6 py-2 rounded-full text-center font-medium">เข้าสู่ระบบ</a>
                @endauth
            </div>
        </nav>
        @endif
    </div>
</header>
