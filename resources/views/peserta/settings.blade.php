    @php
    /** @var \App\Models\User $user */
@endphp

@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="max-w-4xl px-6 py-6 mx-auto">
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

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="p-4 border rounded-xl bg-slate-50 border-slate-100">
                    <p class="mb-1 text-xs font-bold tracking-tight uppercase text-slate-500">Username</p>
                    <p class="font-semibold text-slate-900">{{ $user->username }}</p>
                </div>

                <div class="p-4 border rounded-xl bg-slate-50 border-slate-100">
                    <p class="mb-1 text-xs font-bold tracking-tight uppercase text-slate-500">Email</p>
                    <p class="font-semibold text-slate-900">{{ $user->email }}</p>
                </div>

                <div class="relative p-4 border opacity-75 rounded-xl bg-slate-50 border-slate-200">
                    <p class="mb-1 text-xs font-bold tracking-tight uppercase text-slate-500">Role</p>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-1 text-xs font-bold text-indigo-700 bg-indigo-100 border border-indigo-200 rounded-lg uppercase">
                            {{ $user->role }}
                        </span>
                        <i class='bx bx-lock-alt text-slate-400' title="Role tidak dapat diubah"></i>
                    </div>
                </div>

                <div class="relative p-4 border opacity-75 rounded-xl bg-slate-50 border-slate-200">
                    <p class="mb-1 text-xs font-bold tracking-tight uppercase text-slate-500">Status Akun</p>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <p class="font-semibold text-slate-900">Aktif</p>
                        <i class='ml-auto bx bx-lock-alt text-slate-400' title="Status tidak dapat diubah"></i>
                    </div>
                </div>
            </div>
        </div>

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
        <form action="{{ route('peserta.settings.update') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div class="space-y-2">
                    <label for="current_password" class="text-sm font-bold text-slate-700">Kata Sandi Saat Ini</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 transition-colors pointer-events-none group-focus-within:text-primary text-slate-400">
                            <i class='text-xl bx bx-lock-alt'></i>
                        </div>
                        <input type="password" name="current_password" id="current_password"
                            class="w-full py-3 pl-10 pr-4 font-medium transition-all border bg-slate-50 border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary text-slate-700"
                            placeholder="••••••••" required>
                    </div>
                    @error('current_password')
                        <p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="space-y-2">
                        <label for="password" class="text-sm font-bold text-slate-700">Kata Sandi Baru</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 transition-colors pointer-events-none group-focus-within:text-primary text-slate-400">
                                <i class='text-xl bx bx-key'></i>
                            </div>
                            <input type="password" name="password" id="password"
                                class="w-full py-3 pl-10 pr-4 font-medium transition-all border bg-slate-50 border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary text-slate-700"
                                placeholder="••••••••" required>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-sm font-bold text-slate-700">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 transition-colors pointer-events-none group-focus-within:text-primary text-slate-400">
                                <i class='text-xl bx bx-check-double'></i>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full py-3 pl-10 pr-4 font-medium transition-all border bg-slate-50 border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary text-slate-700"
                                placeholder="••••••••" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-6 mt-10 border-t border-gray-50">
                <button type="submit" class="inline-flex items-center px-8 py-3.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary-dark focus:ring-4 focus:ring-primary/20 transition-all shadow-lg shadow-primary/20 hover:-translate-y-0.5 active:translate-y-0">
                    <i class='mr-2 text-lg bx bx-shield-quarter'></i>
                    Perbarui Kata Sandi
                </button>
            </div>
        </form>
        </div>
    </div>

    <div class="flex gap-4 p-6 mt-8 border border-blue-100 bg-blue-50/50 rounded-2xl">
        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 text-blue-600 bg-white border border-blue-100 shadow-sm rounded-xl">
            <i class='text-2xl bx bx-info-circle'></i>
        </div>
        <div>
            <h4 class="text-sm font-bold text-blue-900">Mengapa perbarui kata sandi?</h4>
            <p class="mt-1 text-sm font-medium leading-relaxed text-blue-700/80">
                Mengganti kata sandi secara berkala membantu melindungi akun Anda dari akses yang tidak sah. Pastikan Anda menggunakan kombinasi karakter yang unik dan kuat yang tidak Anda gunakan di platform lain.
            </p>
        </div>
    </div>
</div>
@endsection
