<header class="fixed w-full top-0 z-50 bg-white/95 backdrop-blur-xl border-b border-blue-100/50 shadow-lg shadow-blue-100/20" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-2 sm:py-3 lg:py-4">
        <div class="flex justify-between items-center">

            <!-- Logo Section - Mobile Optimized -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2 group min-w-0 flex-1 sm:flex-initial">
                <div class="relative flex-shrink-0">
                    <img src="{{ asset('logo/logo-40-40.png') }}"
                        alt="Wick Fill Trade Journal Logo"
                        class="h-7 w-7 sm:h-9 sm:w-9 lg:h-10 lg:w-10 transition-all duration-300 group-hover:scale-110 drop-shadow-lg">
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-base sm:text-lg lg:text-xl xl:text-2xl font-bold text-blue-900 leading-tight tracking-tight truncate">
                        Wick Fill
                    </span>
                    <span class="text-xs sm:text-sm text-blue-600 font-semibold -mt-0.5 tracking-wide hidden sm:block">
                        TRADE JOURNAL
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation - Hidden on mobile -->
            <nav class="hidden lg:flex items-center space-x-4 xl:space-x-6">
                <!-- แผนราคา -->
                <a href="{{ route('pricing') }}" class="{{ request()->routeIs('pricing') ? 'text-blue-600 font-semibold' : 'text-blue-800 hover:text-blue-600 font-medium' }} transition-all duration-300 relative group py-2 text-sm xl:text-base">
                    แผนราคา
                    @if(request()->routeIs('pricing'))
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full"></span>
                    @else
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-500 to-blue-600 transition-all duration-300 group-hover:w-full rounded-full"></span>
                    @endif
                </a>

                <!-- คำถามที่พบบ่อย -->
                <a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'text-blue-600 font-semibold' : 'text-blue-800 hover:text-blue-600 font-medium' }} transition-all duration-300 relative group py-2 text-sm xl:text-base">
                    คำถามที่พบบ่อย
                    @if(request()->routeIs('faq'))
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full"></span>
                    @else
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-500 to-blue-600 transition-all duration-300 group-hover:w-full rounded-full"></span>
                    @endif
                </a>

                <!-- เกี่ยวกับเรา -->
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-blue-600 font-semibold' : 'text-blue-800 hover:text-blue-600 font-medium' }} transition-all duration-300 relative group py-2 text-sm xl:text-base">
                    เกี่ยวกับเรา
                    @if(request()->routeIs('about'))
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full"></span>
                    @else
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-500 to-blue-600 transition-all duration-300 group-hover:w-full rounded-full"></span>
                    @endif
                </a>

                <!-- Auth Button -->
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 lg:px-5 lg:py-2.5 xl:px-6 xl:py-3 rounded-full font-medium transition-all duration-300 shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:scale-105 relative overflow-hidden group">
                        <span class="relative z-10 text-sm lg:text-base">Dashboard</span>
                        <div class="absolute inset-0 bg-white/10 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 lg:px-5 lg:py-2.5 xl:px-6 xl:py-3 rounded-full font-medium transition-all duration-300 shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:scale-105 relative overflow-hidden group">
                        <span class="relative z-10 text-sm lg:text-base">เข้าสู่ระบบ</span>
                        <div class="absolute inset-0 bg-white/10 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    </a>
                @endauth
            </nav>

            <!-- Mobile menu button - Enhanced -->
            <button @click="open = !open"
                    class="lg:hidden p-2 text-blue-800 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-300 border border-blue-100 flex-shrink-0"
                    :class="{ 'bg-blue-50 text-blue-600': open }">
                <i class="fas fa-bars text-base sm:text-lg" x-show="!open"></i>
                <i class="fas fa-times text-base sm:text-lg" x-show="open"></i>
            </button>
        </div>

        <!-- Enhanced Mobile Navigation -->
        <nav x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-2"
                class="lg:hidden mt-3 sm:mt-4 pb-3 sm:pb-4 border-t border-blue-100 pt-3 sm:pt-4 bg-blue-50/30 rounded-xl mx-1 sm:mx-2">
            <div class="flex flex-col space-y-1 sm:space-y-2 px-2 sm:px-4">
                <!-- Mobile Navigation Links with Active States -->
                <a href="{{ route('pricing') }}" class="{{ request()->routeIs('pricing') ? 'text-blue-600 bg-blue-50 border-blue-200' : 'text-blue-800 hover:text-blue-600 border-transparent hover:border-blue-200' }} font-medium py-2.5 sm:py-3 px-3 sm:px-4 rounded-lg hover:bg-blue-50 transition-all duration-300 border text-sm sm:text-base">
                    <i class="fas fa-tag mr-2 text-xs"></i>
                    แผนราคา
                </a>
                <a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'text-blue-600 bg-blue-50 border-blue-200' : 'text-blue-800 hover:text-blue-600 border-transparent hover:border-blue-200' }} font-medium py-2.5 sm:py-3 px-3 sm:px-4 rounded-lg hover:bg-blue-50 transition-all duration-300 border text-sm sm:text-base">
                    <i class="fas fa-question-circle mr-2 text-xs"></i>
                    คำถามที่พบบ่อย
                </a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-blue-600 bg-blue-50 border-blue-200' : 'text-blue-800 hover:text-blue-600 border-transparent hover:border-blue-200' }} font-medium py-2.5 sm:py-3 px-3 sm:px-4 rounded-lg hover:bg-blue-50 transition-all duration-300 border text-sm sm:text-base">
                    <i class="fas fa-info-circle mr-2 text-xs"></i>
                    เกี่ยวกับเรา
                </a>

                <!-- Mobile Auth Button -->
                <div class="pt-2 sm:pt-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="flex items-center justify-center bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 sm:px-6 py-3 sm:py-3.5 rounded-lg text-center font-medium shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all duration-300 text-sm sm:text-base">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center justify-center bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 sm:px-6 py-3 sm:py-3.5 rounded-lg text-center font-medium shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all duration-300 text-sm sm:text-base">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            เข้าสู่ระบบ
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
    </div>
</header>
