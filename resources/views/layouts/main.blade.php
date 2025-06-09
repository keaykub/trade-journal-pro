<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Trade Journal') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
            input.setSelectionRange(0, 99999); // For mobile devices
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

        function openPreviewModal(imageSrc, title) {
    const modal = document.getElementById('previewModal');
    const previewImage = document.getElementById('previewImage');
    const previewTitle = document.getElementById('previewTitle');

    previewImage.src = imageSrc;
    previewTitle.textContent = title;

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// ปิด Modal
function closePreviewModal() {
    const modal = document.getElementById('previewModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Keyboard support
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePreviewModal();
    }
});
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .sidebar-transition { transition: all 0.3s ease; }
        .theme-transition { transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease; }

        /* Custom animations */
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slide-in-right {
            animation: slideInRight 0.3s ease-out;
        }

        @keyframes slide-in-right {
            0% {
                transform: translateX(100%);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in-right {
            animation: slide-in-right 0.3s ease-out;
        }

        /* Additional custom styles for enhanced visual appeal */
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Gradient background for better visual hierarchy */
        .category-gradient {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(147, 51, 234, 0.05) 100%);
        }

        /* Enhanced hover effects */
        .metric-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.5);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.7);
        }

        /* /new image */
        /* เพิ่ม CSS นี้ในไฟล์ layout ของคุณ หรือใส่ใน <style> tag */

        /* Mobile Modal Improvements */
        @media (max-width: 768px) {
            /* ซ่อน hover effects บนมือถือ */
            .group:hover .group-hover\\:opacity-100,
            .group:hover .group-hover\\:bg-opacity-20 {
                opacity: 0 !important;
                background-opacity: 0 !important;
            }

            /* Grid 2 columns บนมือถือ */
            .grid.md\\:grid-cols-2.lg\\:grid-cols-3 {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            /* รูปเล็กลง */
            .h-64 {
                height: 12rem;
            }

            /* ===== MODAL FIXES ===== */

            /* Modal controls ให้ใหญ่ขึ้นและจัดตำแหน่งใหม่ */
            #imageModal .absolute.top-4.right-4 {
                top: 0.75rem !important;
                right: 0.75rem !important;
                width: 2.75rem !important;
                height: 2.75rem !important;
                background: rgba(0, 0, 0, 0.8) !important;
                backdrop-filter: blur(8px);
            }

            #imageModal .absolute.left-4,
            #imageModal .absolute.right-4.transform {
                width: 2.75rem !important;
                height: 2.75rem !important;
                background: rgba(0, 0, 0, 0.8) !important;
                backdrop-filter: blur(8px);
            }

            /* ปรับ left/right buttons ให้อยู่ตรงกลางและห่างจากขอบ */
            #imageModal .absolute.left-4.top-1\\/2 {
                left: 0.75rem !important;
            }

            #imageModal .absolute.right-4.top-1\\/2 {
                right: 0.75rem !important;
            }

            /* ===== INFO BAR FIXES ===== */

            /* Info bar ด้านล่าง - ย้ายขึ้นมาไม่ให้บังรูป */
            #imageModal .absolute.bottom-4 {
                position: fixed !important;
                bottom: 2rem !important;
                left: 1rem !important;
                right: 1rem !important;
                transform: none !important;
                max-width: none !important;
                background: rgba(0, 0, 0, 0.9) !important;
                backdrop-filter: blur(12px);
                border-radius: 0.75rem !important;
                padding: 0.75rem 1rem !important;
                border: 1px solid rgba(255, 255, 255, 0.1);
                margin: 0 auto;
                z-index: 60 !important;
            }

            /* Text ใน Info bar */
            #imageModal .text-sm {
                font-size: 0.875rem !important;
                line-height: 1.25rem !important;
            }

            #imageModal .text-xs {
                font-size: 0.75rem !important;
                opacity: 0.9 !important;
            }

            /* ===== IMAGE CONTAINER ===== */

            /* รูปใน Modal ให้เหมาะกับหน้าจอ */
            #imageModal img {
                max-height: calc(100vh - 8rem) !important; /* เว้นที่สำหรับ controls และ info bar */
                max-width: calc(100vw - 2rem) !important;
                border-radius: 0.5rem !important;
            }

            /* Modal container */
            #imageModal {
                padding: 1rem !important;
            }

            /* Image container */
            #imageModal .relative.max-w-full.max-h-full {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                max-height: calc(100vh - 6rem) !important;
            }
        }

        @media (max-width: 480px) {
            /* Grid 1 column บนมือถือเล็ก */
            .grid.md\\:grid-cols-2.lg\\:grid-cols-3 {
                grid-template-columns: 1fr;
            }

            /* รูปเล็กลงอีก */
            .h-64 {
                height: 10rem;
            }

            /* ===== VERY SMALL SCREEN FIXES ===== */

            /* Controls เล็กลงบนจอเล็กมาก */
            #imageModal .absolute.top-4.right-4,
            #imageModal .absolute.left-4,
            #imageModal .absolute.right-4.transform {
                width: 2.5rem !important;
                height: 2.5rem !important;
            }

            /* Info bar เล็กลง */
            #imageModal .absolute.bottom-4 {
                bottom: 1.5rem !important;
                left: 0.75rem !important;
                right: 0.75rem !important;
                padding: 0.5rem 0.75rem !important;
            }

            #imageModal .text-sm {
                font-size: 0.8rem !important;
            }

            #imageModal .text-xs {
                font-size: 0.7rem !important;
            }

            /* รูปให้เล็กลงบนจอเล็กมาก */
            #imageModal img {
                max-height: calc(100vh - 7rem) !important;
                max-width: calc(100vw - 1.5rem) !important;
            }
        }

        /* ===== LANDSCAPE MODE ===== */
        @media (max-width: 768px) and (orientation: landscape) {
            /* โหมด landscape บนมือถือ */
            #imageModal .absolute.bottom-4 {
                bottom: 1rem !important;
                padding: 0.5rem 0.75rem !important;
            }

            #imageModal img {
                max-height: calc(100vh - 5rem) !important;
            }
        }

        /* ===== TOUCH IMPROVEMENTS ===== */
        @media (hover: none) and (pointer: coarse) {
            /* Touch devices specific */
            #imageModal button {
                min-width: 44px !important;
                min-height: 44px !important;
            }

            /* เพิ่ม visual feedback เมื่อแตะ */
            #imageModal button:active {
                background: rgba(255, 255, 255, 0.4) !important;
                transform: scale(0.95);
            }
        }

        /* ===== BLUR EFFECTS ===== */
        @supports (backdrop-filter: blur(8px)) or (-webkit-backdrop-filter: blur(8px)) {
            #imageModal .absolute.bottom-4 {
                backdrop-filter: blur(12px) !important;
                -webkit-backdrop-filter: blur(12px) !important;
            }

            #imageModal button {
                backdrop-filter: blur(8px) !important;
                -webkit-backdrop-filter: blur(8px) !important;
            }
        }

        /* Fixed Aspect Ratio Solution new fixed*/
        .trade-image-container {
            position: relative;
            width: 100%;
            padding-bottom: 66.67%; /* 3:2 aspect ratio */
            overflow: hidden;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        }

        .trade-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        /* สำหรับรูปที่เล็กมาก */
        .trade-image.small-image {
            object-fit: contain;
            padding: 1rem;
        }

        .trade-image-container:hover .trade-image {
            transform: scale(1.05);
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
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-lg sidebar-transition"
         :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        <!-- Logo -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('logo/WICK TRADE.png') }}"
                        alt="Trade Journal Logo"
                        class="w-12 h-12 object-contain">
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">WickFill</h1>
                    <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">
                        Trade Journal
                    </h2>
                </div>
            </div>
        </div>

      <!-- Navigation -->
      <nav class="p-4 space-y-2">
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
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors text-gray-600 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
          <i class="fas fa-robot"></i>
          <span>AI โค้ช</span>
        </a>
        <a href="#"
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors text-gray-600 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
          <i class="fas fa-cog"></i>
          <span>ตั้งค่า</span>
        </a>
      </nav>

      <!-- User Info -->
      <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
          </div>
          <div class="flex-1">
            @auth
                <p class="font-semibold text-gray-800 dark:text-gray-100 truncate max-w-32">
                    {{ Auth::user()->email }}
                </p>
                {{-- <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p> --}}
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {{ Auth::user()->currentPlanName() ?? 'Free Plan' }}
                </p>
            @else
                <p class="font-semibold text-gray-800 dark:text-gray-100">Guest</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">No email</p>
            @endauth
          </div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-gray-400 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors" title="ออกจากระบบ">
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
      <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 px-6 py-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-4">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden text-gray-600 dark:text-gray-200">
              <i class="fas fa-bars text-xl"></i>
            </button>
            <div>
              <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $title ?? 'Dashboard' }}</h2>
              <p class="text-gray-600 dark:text-gray-400">{{ $description ?? 'ภาพรวมการเทรดของคุณ' }}</p>
            </div>
          </div>
          <div class="flex items-center space-x-2">
            <!-- Toggle Dark Mode Button -->
            <button @click="toggleDarkMode"
                    class="p-2 rounded-lg transition-colors text-gray-600 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
                    title="เปลี่ยนโหมดแสง/มืด">
                <template x-if="darkMode">
                <i class="fas fa-sun"></i>
                </template>
                <template x-if="!darkMode">
                <i class="fas fa-moon"></i>
                </template>
            </button>
            <!-- Notifications -->
            <button class="relative p-2 rounded-lg transition-colors text-gray-600 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-bell"></i>
            </button>
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
