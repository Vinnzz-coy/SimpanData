@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="px-6 py-6 mx-auto max-w-4xl">
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Pengaturan Akun</h1>
        <p class="text-sm font-medium text-slate-600">Kelola informasi akun dan keamanan Anda.</p>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-3 p-4 mb-6 text-sm text-green-800 border border-green-100 rounded-2xl bg-green-50 animate-fade-in">
            <i class='text-xl bx bx-check-circle'></i>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-8 mb-8">
        <!-- Account Info Card -->
        <div class="p-8 bg-white border border-gray-100 shadow-soft rounded-2xl">
            <div class="flex items-center gap-4 mb-6">
                <div class="flex items-center justify-center w-12 h-12 text-indigo-600 bg-indigo-50 rounded-xl">
                    <i class='text-2xl bx bx-user-circle'></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Informasi Akun</h2>
                    <p class="text-sm font-medium text-slate-500">Detail identitas akun Anda saat ini.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-tight mb-1">Username</p>
                    <p class="text-slate-900 font-semibold">{{ Auth::user()->username }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-tight mb-1">Email</p>
                    <p class="text-slate-900 font-semibold">{{ Auth::user()->email }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 relative group/info">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-tight mb-1">Role</p>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-1 text-xs font-bold text-indigo-700 bg-indigo-100 rounded-lg uppercase">
                            {{ Auth::user()->role }}
                        </span>
                    </div>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 relative group/info">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-tight mb-1">Status Akun</p>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <p class="text-slate-900 font-semibold">Aktif</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.profile.index') }}" class="inline-flex items-center justify-center w-8 h-8 text-indigo-600 bg-white border border-slate-100 rounded-lg hover:bg-indigo-50 transition-colors shadow-sm" title="Edit Profil">
                            <i class='bx bx-edit-alt'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Password Card -->
        <div class="p-8 bg-white border border-gray-100 shadow-soft rounded-2xl">
            <div class="flex items-center gap-4 mb-6">
                <div class="flex items-center justify-center w-12 h-12 text-amber-600 bg-amber-50 rounded-xl">
                    <i class='text-2xl bx bx-lock-open-alt'></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Keamanan & Kata Sandi</h2>
                    <p class="text-sm font-medium text-slate-500">Ubah kata sandi Anda secara berkala.</p>
                </div>
            </div>
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <!-- Current Password -->
                <div class="space-y-2">
                    <label for="current_password" class="text-sm font-bold text-slate-700">Kata Sandi Saat Ini</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none transition-colors group-focus-within:text-primary text-slate-400">
                            <i class='text-xl bx bx-lock-alt'></i>
                        </div>
                        <input type="password" name="current_password" id="current_password" 
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-slate-700 font-medium" 
                            placeholder="••••••••" required>
                    </div>
                    @error('current_password')
                        <p class="text-xs font-bold text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- New Password -->
                    <div class="space-y-2">
                        <label for="password" class="text-sm font-bold text-slate-700">Kata Sandi Baru</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none transition-colors group-focus-within:text-primary text-slate-400">
                                <i class='text-xl bx bx-key'></i>
                            </div>
                            <input type="password" name="password" id="password" 
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-slate-700 font-medium" 
                                placeholder="••••••••" required>
                        </div>
                        @error('password')
                            <p class="text-xs font-bold text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-sm font-bold text-slate-700">Konfirmasi Kata Sandi</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none transition-colors group-focus-within:text-primary text-slate-400">
                                <i class='text-xl bx bx-check-double'></i>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-slate-700 font-medium" 
                                placeholder="••••••••" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-10 pt-6 border-t border-gray-50">
                <button type="submit" class="inline-flex items-center px-8 py-3 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary-dark focus:ring-4 focus:ring-primary/20 transition-all shadow-lg shadow-primary/20">
                    <i class='mr-2 text-lg bx bx-shield-quarter'></i>
                    Perbarui Kata Sandi
                </button>
            </div>
        </form>
        </div>
    </div>

    <!-- Security Tips -->
    <div class="mt-8 p-6 bg-blue-50 border border-blue-100 rounded-2xl">
        <div class="flex gap-4">
            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                <i class='text-2xl bx bx-info-circle'></i>
            </div>
            <div>
                <h4 class="text-sm font-bold text-blue-900">Tips Keamanan</h4>
                <p class="text-xs font-medium text-blue-700 mt-1 leading-relaxed">
                    Gunakan kata sandi yang kuat dengan kombinasi huruf besar, huruf kecil, angka, dan simbol. Hindari menggunakan kata sandi yang mudah ditebak seperti tanggal lahir atau nama hewan peliharaan.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
