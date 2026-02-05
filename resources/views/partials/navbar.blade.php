<nav
    class="sticky top-0 z-40 w-full px-4 py-3 transition-all duration-300 bg-white/80 border-b border-gray-200 supports-backdrop-blur:bg-white/60 backdrop-blur-md">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <button id="mobileSidebarToggle"
                class="p-2 text-slate-500 rounded-xl hover:bg-slate-100 active:bg-slate-200 lg:hidden transition-all duration-200">
                <i class='text-2xl bx bx-menu'></i>
            </button>

            <div class="flex flex-col">
                <h1 class="text-xl font-bold tracking-tight text-slate-800">
                    @yield('title', 'Dashboard')
                </h1>
                <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                    <span class="hidden sm:inline">SimpanData</span>
                    <span class="hidden sm:inline">•</span>
                    <span id="currentDate" class="text-primary font-bold"></span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 sm:gap-4">
            <div class="relative" id="profileDropdownContainer">
                @php
                    /** @var \App\Models\User $user */
                    $user = Auth::user();
                    $peserta = $user->peserta ?? null;
                    $role = $user->role ?? 'User';
                    $profilePhoto = ($role === 'peserta' && $peserta) ? $peserta->foto : null;
                    $displayName = $peserta->nama ?? $user->name ?? $user->username ?? 'User';
                    $initial = strtoupper(substr($displayName, 0, 1));
                @endphp
                <button id="profileDropdownBtn"
                    class="flex items-center gap-3 pl-1 pr-1 sm:pr-4 py-1 rounded-full sm:rounded-xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-200 group">
                    <div class="relative flex-shrink-0 w-9 h-9">
                        @if ($profilePhoto)
                            <img src="{{ asset('storage/' . $profilePhoto) }}" alt="Profile"
                                class="object-cover w-full h-full shadow-md rounded-full ring-2 ring-white group-hover:shadow-lg transition-all">
                        @else
                            <div
                                class="flex items-center justify-center w-full h-full font-bold text-white rounded-full shadow-md bg-gradient-to-br from-primary to-blue-600 ring-2 ring-white group-hover:shadow-lg transition-all text-xs">
                                {{ $initial }}
                            </div>
                        @endif
                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
                    </div>
                    <div class="hidden text-left sm:block">
                        <p class="text-sm font-bold leading-tight text-slate-700 group-hover:text-primary transition-colors">
                            {{ Str::limit($user->username ?? 'User', 15) }}
                        </p>
                        <p class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                            {{ $role }}
                        </p>
                    </div>
                    <i class='hidden text-slate-400 bx bx-chevron-down sm:block group-hover:text-slate-600'></i>
                </button>

                <div id="profileDropdown"
                    class="absolute right-0 w-48 mt-2 origin-top-right bg-white border border-gray-100 shadow-xl rounded-2xl ring-1 ring-black ring-opacity-5 focus:outline-none opacity-0 invisible transform scale-95 transition-all duration-200">
                    <div class="p-1.5">
                        <div class="px-3 py-2 border-b border-gray-50 bg-gray-50/50 rounded-t-xl mb-1 sm:hidden">
                            <p class="text-sm font-bold text-slate-700 truncate">{{ $user->name ?? 'User' }}</p>
                            <p class="text-[10px] font-bold text-slate-500 uppercase">{{ $role }}</p>
                        </div>
                        <a href="{{ $role === 'admin' ? route('admin.profile.index') : route('peserta.profil') }}"
                            class="flex items-center w-full px-3 py-2 text-sm font-medium text-slate-600 rounded-xl hover:bg-blue-50 hover:text-primary group transition-colors">
                            <i class='mr-2 text-lg bx bx-user group-hover:text-primary'></i>
                            Profil Saya
                        </a>
                        <a href="{{ $role === 'admin' ? route('admin.settings.index') : route('peserta.settings.index') }}"
                            class="flex items-center w-full px-3 py-2 text-sm font-medium text-slate-600 rounded-xl hover:bg-blue-50 hover:text-primary group transition-colors">
                            <i class='mr-2 text-lg bx bx-cog group-hover:text-primary'></i>
                            Pengaturan
                        </a>
                        <div class="my-1 border-t border-gray-100"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full px-3 py-2 text-sm font-medium text-red-600 rounded-xl hover:bg-red-50 group transition-colors">
                                <i class='mr-2 text-lg bx bx-log-out group-hover:text-red-600'></i>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateElement = document.getElementById('currentDate');
        if (dateElement) {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const today = new Date();
            dateElement.textContent = today.toLocaleDateString('id-ID', options);
        }

        const dropdownBtn = document.getElementById('profileDropdownBtn');
        const dropdownMenu = document.getElementById('profileDropdown');

        if (dropdownBtn && dropdownMenu) {
            dropdownBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = !dropdownMenu.classList.contains('invisible');

                if (isOpen) {
                    closeDropdown();
                } else {
                    openDropdown();
                }
            });

            document.addEventListener('click', (e) => {
                if (!dropdownMenu.contains(e.target) && !dropdownBtn.contains(e.target)) {
                    closeDropdown();
                }
            });

            function openDropdown() {
                dropdownMenu.classList.remove('invisible', 'opacity-0', 'scale-95');
                dropdownMenu.classList.add('visible', 'opacity-100', 'scale-100');
            }

            function closeDropdown() {
                dropdownMenu.classList.add('invisible', 'opacity-0', 'scale-95');
                dropdownMenu.classList.remove('visible', 'opacity-100', 'scale-100');
            }
        }
    });
</script>
