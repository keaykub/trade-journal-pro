<header class="fixed w-full top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-200/50 shadow-lg" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo Section -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <div class="relative">
                    <img src="{{ asset('logo/logo-40-40.png') }}"
                        alt="Wick Fill Trade Journal Logo"
                        class="h-10 w-auto transition-transform duration-300 group-hover:scale-110">
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl font-bold text-gray-800 leading-tight tracking-tight">Wick Fill</span>
                    <span class="text-sm text-blue-600 font-semibold -mt-0.5 tracking-wide">TRADE JOURNAL</span>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-8 text-gray-700">
                <a href="{{ route('pricing') }}"
                class="hover:text-blue-600 transition-colors font-medium relative group {{ request()->routeIs('pricing') ? 'text-blue-600' : '' }}">
                    แผนราคา
                    <span class="absolute bottom-0 left-0 h-0.5 bg-blue-600 transition-all duration-300 {{ request()->routeIs('pricing') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
                <a href="{{ route('faq') }}" class="hover:text-blue-600 transition-colors font-medium relative group">
                    คำถามที่พบบ่อย
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="{{ route('about') }}"
                class="transition-colors font-medium relative group {{ request()->routeIs('about') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                    เกี่ยวกับเรา
                    <span class="absolute bottom-0 left-0 h-0.5 bg-blue-600 transition-all duration-300 {{ request()->routeIs('about') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2.5 rounded-full font-medium hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-105 relative overflow-hidden group">
                        <span class="relative z-10">Dashboard</span>
                        <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2.5 rounded-full font-medium hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-105 relative overflow-hidden group">
                        <span class="relative z-10">เข้าสู่ระบบ</span>
                        <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    </a>
                @endauth
            </nav>

            <!-- Mobile menu button -->
            <button @click="open = !open" class="md:hidden p-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                <i class="fas fa-bars text-xl" x-show="!open"></i>
                <i class="fas fa-times text-xl" x-show="open"></i>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <nav x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="md:hidden mt-4 pb-4 border-t border-gray-200 pt-4">www
            <div class="flex flex-col space-y-3">
                <a href="{{ route('pricing') }}" class="text-gray-700 hover:text-blue-600 font-medium py-2 px-4 rounded-lg hover:bg-blue-50 transition-all">แผนราคา</a>
                <a href="{{ route('faq') }}" class="text-gray-700 hover:text-blue-600 font-medium py-2 px-4 rounded-lg hover:bg-blue-50 transition-all">คำถามที่พบบ่อย</a>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-blue-600 font-medium py-2 px-4 rounded-lg hover:bg-blue-50 transition-all">เกี่ยวกับเรา</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-full text-center font-medium shadow-lg mt-2">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-full text-center font-medium shadow-lg mt-2">เข้าสู่ระบบ</a>
                @endauth
            </div>
        </nav>
    </div>
</header>
