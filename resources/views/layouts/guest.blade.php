<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'WickFill Trade Journal')</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.7;
            animation: blob 7s infinite;
        }

        @keyframes blob {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .input-focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .social-btn {
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }


        /* //resgister page */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        /* Optional: เพิ่ม pulse animation สำหรับปุ่ม */
        .loading-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .8; }
        }
    </style>
</head>
<body class="min-h-screen gradient-bg overflow-hidden">
    <!-- Background Elements -->
    <div class="blob w-72 h-72 bg-purple-300 top-10 left-10"></div>
    <div class="blob w-96 h-96 bg-blue-300 top-20 right-10" style="animation-delay: 2s;"></div>
    <div class="blob w-64 h-64 bg-indigo-300 bottom-20 left-20" style="animation-delay: 4s;"></div>

    <div class="relative z-10 flex items-center justify-center min-h-screen px-4">
        {{ $slot }}
    </div>

    <!-- Success Toast -->
    <div id="success-toast" class="fixed top-6 right-6 z-50 hidden">
        <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            <span>เข้าสู่ระบบสำเร็จ!</span>
        </div>
    </div>

    <!-- Error Toast -->
    <div id="error-toast" class="fixed top-6 right-6 z-50 hidden">
        <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
            <i class="fas fa-exclamation-triangle"></i>
            <span id="error-message">เกิดข้อผิดพลาด</span>
        </div>
    </div>

    <script>
        // Auto-hide toasts
        function showToast(type, message) {
            const toast = document.getElementById(type + '-toast');
            if (type === 'error') {
                document.getElementById('error-message').textContent = message;
            }
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }
    </script>
</body>
</html>
