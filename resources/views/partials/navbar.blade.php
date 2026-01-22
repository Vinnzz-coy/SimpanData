<!-- Navbar -->
<nav class="sticky top-0 z-40 px-3 py-2.5 md:px-4 md:py-3 bg-white border-b border-gray-200 shadow-sm transition-all duration-300">
    <div class="flex items-center justify-between">
        <div class="flex items-center flex-1 min-w-0">
            <button id="mobileSidebarToggle" class="p-2 text-gray-600 rounded-lg hover:bg-gray-100 active:bg-gray-200 lg:hidden transition-all duration-200 touch-manipulation">
                <i class='text-2xl bx bx-menu'></i>
            </button>
            <!-- Page Title -->
            <div class="ml-2 md:ml-3 min-w-0 flex-1">
                <h1 class="text-lg md:text-xl font-semibold text-gray-800 truncate">@yield('page-title', 'Dashboard')</h1>
                <p class="text-xs md:text-sm text-gray-600 truncate hidden sm:block">@yield('page-subtitle', 'Sistem Pendataan PKL')</p>
            </div>
        </div>

        <!-- Right side items -->
        <div class="flex items-center space-x-2 md:space-x-4 flex-shrink-0">
            <!-- Notifications -->
            <button class="relative p-2 text-gray-600 rounded-lg hover:bg-gray-100 active:bg-gray-200 transition-all duration-200 touch-manipulation">
                <i class='text-lg md:text-xl bx bx-bell'></i>
                <span class="absolute w-2 h-2 bg-red-500 rounded-full top-1 right-1"></span>
            </button>

            <!-- User dropdown -->
            <div class="flex items-center space-x-2 md:space-x-3">
                <div class="hidden text-right md:block">
                    <p class="text-sm font-medium text-gray-800 truncate max-w-[120px]">{{ Auth::user()->username ?? 'Admin' }}</p>
                    <p class="text-xs text-gray-600">
                        {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Peserta' }}
                    </p>
                </div>
                <div class="flex items-center justify-center w-9 h-9 md:w-10 md:h-10 font-semibold text-white rounded-full bg-gradient-to-r from-purple-500 to-indigo-600 text-sm md:text-base transition-transform duration-200 active:scale-95">
                    {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Smooth navbar transitions */
    nav {
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
    }

    /* Touch-friendly interactions */
    @media (max-width: 768px) {
        button {
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0.1);
            touch-action: manipulation;
        }

        /* Smooth button press animation */
        button:active {
            transform: scale(0.95);
            transition: transform 0.1s ease;
        }
    }
</style>
