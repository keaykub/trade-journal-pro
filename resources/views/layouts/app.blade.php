<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<<<<<<< HEAD
    <title>@yield('title', '#1 Trade Journal - ระบบบันทึกการเทรดของคุณ')</title>
    <link rel="icon" href="{{ asset('logo/logo-40-40.png') }}" type="image/x-icon">
=======
    <link rel="icon" href="{{ asset('logo/logo-40-40.png') }}" type="image/png">
    <title>@yield('title', '#2 Trade Journal - ระบบบันทึกการเทรดของคุณ')</title>
>>>>>>> dev-keaykub

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
        /* Essential animations only */
        .floating {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .slide-in-right {
            animation: slide-in-right 0.3s ease-out;
        }

        @keyframes slide-in-right {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Simplified blob animation */
        .blob {
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.6;
            animation: blob 8s infinite ease-in-out;
        }

        @keyframes blob {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            50% { transform: translate(20px, -30px) scale(1.1); }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Focus styles */
        .focus-ring:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        /* Card hover effect */
        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .feature-icon {
            transition: transform 0.3s ease;
        }

        .card-hover:hover .feature-icon {
            transform: scale(1.1);
        }

        .learn-more {
            transition: all 0.3s ease;
        }

        .learn-more:hover {
            transform: translateX(4px);
        }

        .timeline-line {
            background: linear-gradient(to right, #3b82f6 0%, #3b82f6 50%, #e5e7eb 50%, #e5e7eb 100%);
        }

        .step-completed {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .step-current {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            animation: pulse 2s infinite;
        }

        .step-future {
            background: linear-gradient(135deg, #94a3b8, #64748b);
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
    </style>
</head>
<body class=" bg-gray-50 text-gray-900 overflow-x-hidden">
    @yield('content')
</body>
</html>
