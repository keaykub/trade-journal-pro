<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('logo/logo-40-40.png') }}" type="image/png">

    <title>@yield('title', 'WickFill Trade Journal - ระบบบันทึกการเทรดของคุณ')</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/th.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        if (
            localStorage.getItem('darkMode') === 'true' ||
            (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark');
        }

        function copyShareUrl() {
            const input = document.getElementById('shareUrlInput');
            input.select();
            input.setSelectionRange(0, 99999);
            document.execCommand('copy');
        }

        function shareToFacebook() {
            const url = encodeURIComponent(document.getElementById('shareUrlInput').value);
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
        }

        function shareToTwitter() {
            const url = encodeURIComponent(document.getElementById('shareUrlInput').value);
            const text = encodeURIComponent('ดูการเทรดของฉัน');
            window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
        }

        function shareToLine() {
            const url = encodeURIComponent(document.getElementById('shareUrlInput').value);
            const text = encodeURIComponent('ดูการเทรดของฉัน');
            window.open(`https://social-plugins.line.me/lineit/share?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
        }

        function shareToWhatsApp() {
            const url = encodeURIComponent(document.getElementById('shareUrlInput').value);
            const text = encodeURIComponent('ดูการเทรดของฉัน: ' + document.getElementById('shareUrlInput').value);
            window.open(`https://wa.me/?text=${text}`, '_blank');
        }
    </script>

    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        .sidebar-transition { transition: all 0.3s ease; }
        .theme-transition { transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease; }

        /* Upgrade button glow effect */
        .upgrade-glow {
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4); }
            50% { box-shadow: 0 0 0 8px rgba(59, 130, 246, 0); }
        }

        /* Sidebar scroll */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.5);
            border-radius: 2px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.7);
        }
    </style>
    @livewireStyles
</head>
<body
  class="theme-transition bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100"
  x-data="{
      sidebarOpen: false,
      darkMode: localStorage.getItem('darkMode') === 'true',
      toggleDarkMode() {
          this.darkMode = !this.darkMode;
          localStorage.setItem('darkMode', this.darkMode);
          document.documentElement.classList.toggle('dark', this.darkMode);
      }
  }"
  x-init="
      document.documentElement.classList.toggle('dark', darkMode);
      $watch('darkMode', value => document.documentElement.classList.toggle('dark', value));
  "
>

    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-lg sidebar-transition flex flex-col"
         :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        <!-- Logo -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <div class="relative">
                    <img src="{{ asset('logo/logo-40-40.png') }}"
                        alt="Wick Fill Trade Journal Logo"
                        class="h-10 w-auto transition-transform duration-300 group-hover:scale-110">
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-bold text-gray-800 dark:text-gray-100 leading-tight tracking-tight">Wick Fill</span>
                    <span class="text-sm text-blue-600 dark:text-blue-400 font-semibold -mt-0.5 tracking-wide">TRADE JOURNAL</span>
                </div>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-2 sidebar-scroll overflow-y-auto">
            <a href="{{ route('dashboard') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors
               {{ request()->routeIs('dashboard')
                  ? 'bg-blue-50 text-blue-700 font-semibold dark:bg-blue-900 dark:text-blue-200'
                  : 'text-gray-600 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
              <i class="fas fa-home"></i>
              <span>Dashboard</span>
            </a>

            <a href="{{ route('trade') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors
               {{ request()->routeIs('trade')
                  ? 'bg-blue-50 text-blue-700 font-semibold dark:bg-blue-900 dark:text-blue-200'
                  : 'text-gray-600 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
              <i class="fas fa-plus"></i>
              <span>เพิ่มบันทึก</span>
            </a>

            <a href="{{ route('analytics') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors
               {{ request()->routeIs('analytics')
                  ? 'bg-blue-50 text-blue-700 font-semibold dark:bg-blue-900 dark:text-blue-200'
                  : 'text-gray-600 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
              <i class="fas fa-chart-bar"></i>
              <span>สถิติ</span>
            </a>

            <a href="#"
               class="flex items-center justify-between px-4 py-3 rounded-lg transition-colors text-gray-600 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-not-allowed opacity-75">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-robot"></i>
                    <span>AI แชท</span>
                </div>
                <span class="bg-orange-100 text-orange-600 dark:bg-orange-900 dark:text-orange-300 text-xs px-2 py-1 rounded-full font-semibold">เร็วๆ นี้</span>
            </a>

            <a href="{{ route('settings') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors
               {{ request()->routeIs('settings')
                  ? 'bg-blue-50 text-blue-700 font-semibold dark:bg-blue-900 dark:text-blue-200'
                  : 'text-gray-600 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
              <i class="fas fa-cog"></i>
              <span>ตั้งค่า</span>
            </a>

            @if(auth()->check() && auth()->user()->isAdmin())
            <a href="{{ route('admin.manage-members') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors text-gray-600 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-users"></i>
                <span>จัดการสมาชิก</span>
            </a>
            @endif
        </nav>

        <!-- Upgrade Section (แสดงเฉพาะ Free Plan) -->
        @if(auth()->user()->subscribed('default') && auth()->user()->subscription('default')->valid())
        @else
            <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex-shrink-0">
                <a href="{{ route('pricing') }}"
                class="block w-full p-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl transition-all transform hover:scale-105 upgrade-glow">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-crown text-yellow-300"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-sm">Upgrade to Pro</div>
                            <div class="text-xs text-blue-100">ปลดล็อคฟีเจอร์ทั้งหมด</div>
                        </div>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
        @endif

        <!-- User Info Section -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex-shrink-0">
            <div class="flex items-center space-x-3">
                <img src="{{ auth()->user()->avatar_url ?: 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->first_name ?? auth()->user()->name ?? 'User') . '&color=7F9CF5&background=EBF4FF&size=40' }}"
                     alt="Profile"
                     class="w-10 h-10 rounded-full border-2 border-gray-200 dark:border-gray-600">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800 dark:text-gray-100 truncate text-sm">
                        {{ auth()->user()->first_name ?? auth()->user()->name ?? 'User' }}
                    </p>
                    <div class="flex items-center space-x-2">
                        @php
                            $plan = auth()->user()?->subscription('default')?->stripe_price;
                        @endphp

                        @if ($plan === 'price_XXXXX_PREMIUM')
                            <span class="inline-flex items-center bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300 px-2 py-0.5 rounded text-xs font-semibold">
                                <i class="fas fa-gem mr-1"></i> Premium
                            </span>
                        @elseif ($plan === 'price_1RaIueCZi1bmUwYslJWl6shH')
                            <span class="inline-flex items-center bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300 px-2 py-0.5 rounded text-xs font-semibold">
                                <i class="fas fa-crown mr-1"></i> Pro
                            </span>
                        @else
                            <span class="inline-flex items-center text-gray-500 dark:text-gray-400 text-xs font-medium">
                                Free Plan
                            </span>
                        @endif
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-gray-400 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors p-1 rounded"
                            title="ออกจากระบบ">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" x-cloak x-transition
        @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden">
    </div>

    <!-- Main Content -->
    <div class="lg:pl-64">

        <!-- Top Bar -->
        <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden text-gray-600 dark:text-gray-200 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-bars text-lg"></i>
                    </button>

                    <!-- Page Info with Icon -->
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                            @if(request()->routeIs('dashboard'))
                                <i class="fas fa-home text-blue-600 dark:text-blue-400 text-sm"></i>
                            @elseif(request()->routeIs('trade'))
                                <i class="fas fa-plus text-blue-600 dark:text-blue-400 text-sm"></i>
                            @elseif(request()->routeIs('analytics'))
                                <i class="fas fa-chart-bar text-blue-600 dark:text-blue-400 text-sm"></i>
                            @elseif(request()->routeIs('settings'))
                                <i class="fas fa-cog text-blue-600 dark:text-blue-400 text-sm"></i>
                            @else
                                <i class="fas fa-file text-blue-600 dark:text-blue-400 text-sm"></i>
                            @endif
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $title ?? 'Dashboard' }}</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $description ?? 'ภาพรวมการเทรดของคุณ' }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <!-- Toggle Dark Mode Button -->
                    <button @click="toggleDarkMode"
                            class="p-2 rounded-lg transition-colors text-gray-600 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
                            title="เปลี่ยนโหมดแสง/มืด">
                        <template x-if="darkMode">
                            <i class="fas fa-sun text-sm"></i>
                        </template>
                        <template x-if="!darkMode">
                            <i class="fas fa-moon text-sm"></i>
                        </template>
                    </button>

                    <livewire:notification-dropdown />

                    <!-- Quick Actions (เฉพาะเดสก์ท็อป) -->
                    <div class="hidden md:flex items-center space-x-2">
                        @if(!request()->routeIs('trade'))
                        <a href="{{ route('trade') }}"
                           class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            บันทึกเทรด
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6">
            @if(request()->routeIs('dashboard'))
            <!-- Dashboard gets full width -->
            {{ $slot }}
            @else
            <!-- Other pages get max width container -->
            <div class="max-w-7xl mx-auto">
                {{ $slot }}
            </div>
            @endif
        </main>
    </div>

    @livewireScripts
</body>
</html>
