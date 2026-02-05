@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="px-6 py-6 mx-auto max-w-4xl">
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Pengaturan Keamanan</h1>
        <p class="text-sm font-medium text-slate-600">Perbarui kata sandi Anda untuk menjaga keamanan akun Anda.</p>
    </div>

    @if (session('success'))
        <div class="p-4 mb-6 text-sm text-green-800 rounded-2xl bg-green-50 border border-green-100 flex items-center gap-3 animate-fade-in">
            <i class='bx bx-check-circle text-xl'></i>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="p-8 bg-white border border-gray-100 shadow-soft rounded-2xl">
        <form action="{{ route('peserta.settings.update') }}" method="POST">
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
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-slate-700 font-medium" 
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
                                class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-slate-700 font-medium" 
                                placeholder="••••••••" required>
                        </div>
                        @error('password')
                            <p class="text-xs font-bold text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-sm font-bold text-slate-700">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none transition-colors group-focus-within:text-primary text-slate-400">
                                <i class='text-xl bx bx-check-double'></i>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-slate-700 font-medium" 
                                placeholder="••••••••" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-10 pt-6 border-t border-gray-50">
                <button type="submit" class="inline-flex items-center px-8 py-3.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary-dark focus:ring-4 focus:ring-primary/20 transition-all shadow-lg shadow-primary/20 hover:-translate-y-0.5 active:translate-y-0">
                    <i class='mr-2 text-lg bx bx-shield-quarter'></i>
                    Perbarui Kata Sandi
                </button>
            </div>
        </form>
    </div>

    <!-- Security Information -->
    <div class="mt-8 p-6 bg-blue-50/50 border border-blue-100 rounded-2xl flex gap-4">
        <div class="flex-shrink-0 w-12 h-12 bg-white rounded-xl shadow-sm border border-blue-100 flex items-center justify-center text-blue-600">
            <i class='text-2xl bx bx-info-circle'></i>
        </div>
        <div>
            <h4 class="text-sm font-bold text-blue-900">Mengapa perbarui kata sandi?</h4>
            <p class="text-sm font-medium text-blue-700/80 mt-1 leading-relaxed">
                Mengganti kata sandi secara berkala membantu melindungi akun Anda dari akses yang tidak sah. Pastikan Anda menggunakan kombinasi karakter yang unik dan kuat yang tidak Anda gunakan di platform lain.
            </p>
        </div>
    </div>
</div>
@endsection
