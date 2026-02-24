@extends('layouts.app')

@section('title', 'Laporan Akhir')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col justify-between gap-4 p-6 md:flex-row md:items-center card shadow-soft animate-fade-in">
            <div class="flex items-center space-x-4">
                <div class="flex items-center justify-center w-12 h-12 text-2xl text-purple-600 shadow-inner rounded-xl bg-purple-50">
                    <i class='bx bx-file'></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Halaman Laporan Akhir (Admin)</h1>
                    <p class="text-sm font-medium text-slate-500">Halaman ini digunakan untuk mengelola Laporan Akhir dari Peserta.</p>
                </div>
            </div>
        </div>

        <div class="p-8 text-center border-2 border-dashed rounded-xl border-slate-200 bg-slate-50 animate-fade-in-up">
            <div class="flex flex-col items-center justify-center gap-4">
                <div class="flex items-center justify-center w-20 h-20 mb-2 rounded-full bg-purple-100 text-purple-600">
                    <i class='text-4xl bx bx-info-circle'></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Content Coming Soon</h3>
                    <p class="mt-2 text-slate-500">Fitur Laporan Akhir sedang dalam tahap pengembangan.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
