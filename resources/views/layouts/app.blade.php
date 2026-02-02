<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard PKL')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --sidebar-width: 80px;
            --sidebar-expanded-width: 260px;
            --transition-speed: 0.4s;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }

        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            transition: all var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }

        .sidebar-expanded .main-content {
            margin-left: var(--sidebar-expanded-width);
            width: calc(100% - var(--sidebar-expanded-width));
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        .btn-transition {
            transition: all 0.2s ease-in-out;
        }

        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .shadow-soft {
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }

        .focus-primary:focus {
            outline: none;
            border-color: #695CFE;
            box-shadow: 0 0 0 3px rgba(105, 92, 254, 0.1);
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        * {
            -webkit-tap-highlight-color: transparent;
        }

        @media (max-width: 1200px) {
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .sidebar-expanded .main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }

            main {
                animation: fadeInUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }
        }

        @media (max-width: 768px) {
            .grid-cols-1 {
                grid-template-columns: 1fr !important;
            }

            .lg\:grid-cols-3 > * {
                grid-column: span 1;
            }

            .lg\:col-span-2 {
                grid-column: span 1;
            }

            .card {
                animation: slideInUp 0.5s cubic-bezier(0.4, 0, 0.2, 1);
                transform: translateY(0);
                opacity: 1;
            }

            .card:nth-child(1) { animation-delay: 0.1s; }
            .card:nth-child(2) { animation-delay: 0.2s; }
            .card:nth-child(3) { animation-delay: 0.3s; }
            .card:nth-child(4) { animation-delay: 0.4s; }
        }

        @media (max-width: 640px) {
            .main-content {
                padding: 0.75rem !important;
            }

            .card {
                border-radius: 0.75rem;
                margin-bottom: 1rem;
            }

            .stat-card {
                padding: 1rem !important;
            }

            button, a {
                min-height: 44px;
                min-width: 44px;
            }

            html {
                scroll-behavior: smooth;
                -webkit-overflow-scrolling: touch;
            }
        }

        .chart-container {
            position: relative;
            width: 100%;
        }

        @media (max-width: 768px) {
            .chart-container {
                height: 250px !important;
                transition: height 0.3s ease;
            }
        }

        /* Table Responsive */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
        }

        @media (max-width: 640px) {
            table {
                font-size: 0.875rem;
            }

            th, td {
                padding: 0.75rem 0.5rem !important;
            }

            .table-responsive {
                scroll-behavior: smooth;
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .stat-card {
            animation: fadeInScale 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s;         }

        @media (prefers-reduced-motion: no-preference) {
            html {
                scroll-behavior: smooth;
            }
        }

        @media (max-width: 768px) {
            .card, .stat-card {
                will-change: transform;
                transform: translateZ(0);
                -webkit-transform: translateZ(0);
            }

            * {
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
        }

        @media (hover: hover) {
            .card:hover {
                transform: translateY(-2px);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
        }

        @media (max-width: 768px) {
            img, canvas {
                max-width: 100%;
                height: auto;
            }
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10367D',
                        secondary: '#FF6B35',
                        accent: '#A5CE00',
                        light: '#EBEBEB',
                        'primary-light': 'rgba(16, 54, 125, 0.1)',
                        'secondary-light': 'rgba(255, 107, 53, 0.1)',
                        'accent-light': 'rgba(165, 206, 0, 0.1)'
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif']
                    },
                    borderRadius: {
                        'xl': '1rem',
                        '2xl': '1.5rem'
                    },
                    transitionDuration: {
                        '400': '400ms',
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="relative min-h-screen font-sans bg-gray-50">
    <div id="toastContainer" class="fixed z-50 max-w-full space-y-3 top-5 right-5 w-80"></div>

    <!-- Include Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content Area -->
    <div class="main-content" id="mainContent">
        <!-- Include Navbar -->
        @include('partials.navbar')

        <!-- Main Content -->
        <main class="p-4 md:p-6 animate-fade-in">
            @yield('content')
        </main>

        <!-- Include Footer -->
        @include('partials.footer')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.getElementById('mainContent');
            const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
            const body = document.body;

            function updateMainContentLayout() {
                if (window.innerWidth > 1200) {
                    if (sidebar.classList.contains('open')) {
                        mainContent.style.setProperty('--sidebar-width', '260px');
                        mainContent.classList.add('sidebar-expanded');
                    } else {
                        mainContent.style.setProperty('--sidebar-width', '80px');
                        mainContent.classList.remove('sidebar-expanded');
                    }
                } else {
                    mainContent.style.setProperty('--sidebar-width', '0px');
                    mainContent.classList.remove('sidebar-expanded');
                }
            }

            updateMainContentLayout();

            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        updateMainContentLayout();

                        if (window.innerWidth <= 1200) {
                            const overlay = document.getElementById('sidebar-overlay');
                            if (sidebar.classList.contains('open')) {
                                overlay?.classList.add('active');
                                body.style.overflow = 'hidden';
                            } else {
                                overlay?.classList.remove('active');
                                body.style.overflow = '';
                            }
                        }
                    }
                });
            });

            if (sidebar) {
                observer.observe(sidebar, { attributes: true });
            }

            if (mobileSidebarToggle) {
                mobileSidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('open');
                    const overlay = document.getElementById('sidebar-overlay');
                    if (sidebar.classList.contains('open')) {
                        overlay?.classList.add('active');
                        body.style.overflow = 'hidden';
                    } else {
                        overlay?.classList.remove('active');
                        body.style.overflow = '';
                    }
                });
            }

            const overlay = document.getElementById('sidebar-overlay');
            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('open');
                    this.classList.remove('active');
                    body.style.overflow = '';
                });
            }

            window.addEventListener('resize', function() {
                updateMainContentLayout();

                if (window.innerWidth > 1200) {
                    const overlay = document.getElementById('sidebar-overlay');
                    overlay?.classList.remove('active');
                    body.style.overflow = '';
                }
            });

            window.showToast = function(message, type = 'info') {
                const container = document.getElementById('toastContainer');
                const toast = document.createElement('div');

                const icons = {
                    success: '✓',
                    error: '✗',
                    warning: '⚠',
                    info: 'ℹ'
                };

                const colors = {
                    success: 'bg-green-600',
                    error: 'bg-red-600',
                    warning: 'bg-yellow-600',
                    info: 'bg-indigo-600'
                };

                toast.className = `${colors[type]} text-white p-4 rounded-xl shadow-lg animate-fade-in-up flex items-center justify-between glass`;
                toast.innerHTML = `
                    <div class="flex items-center">
                        <span class="mr-3 font-bold">${icons[type]}</span>
                        <span class="text-sm">${message}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                `;

                container.appendChild(toast);

                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.style.opacity = '0';
                        toast.style.transform = 'translateX(20px)';
                        toast.style.transition = 'all 0.3s ease';

                        setTimeout(() => {
                            if (toast.parentElement) toast.remove();
                        }, 300);
                    }
                }, 3500);
            };

            @if(session('success'))
                showToast('{{ session('success') }}', 'success');
            @endif
            @if(session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif

            const interactiveElements = document.querySelectorAll('button, input, a, .card, .stat-card');
            interactiveElements.forEach(el => {
                el.classList.add('transition-colors', 'duration-200');
            });

            if (window.innerWidth <= 768) {
                document.documentElement.style.scrollBehavior = 'smooth';
            }

            if (window.innerWidth <= 768) {
                const cards = document.querySelectorAll('.card');
                cards.forEach(card => {
                    card.style.willChange = 'transform';
                });
            }

            window.addEventListener('orientationchange', function() {
                setTimeout(() => {
                    updateMainContentLayout();
                }, 100);
            });
        });
    </script>

    @stack('modals')
    @yield('scripts')
</body>
</html>
