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
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Laporan Akhir</h1>
                    <p class="text-sm font-medium text-slate-500">Kirimkan laporan akhir kegiatan PKL/Magang Anda.</p>
                </div>
            </div>

            @if($laporanAkhir)
                <div class="px-4 py-2 border rounded-xl animate-fade-in {{ $laporanAkhir->status == 'Disetujui' ? 'border-green-100 bg-green-50' : ($laporanAkhir->status == 'Revisi' ? 'border-yellow-100 bg-yellow-50' : 'border-blue-100 bg-blue-50') }}">
                    <p class="text-xs font-bold tracking-tighter uppercase {{ $laporanAkhir->status == 'Disetujui' ? 'text-green-600' : ($laporanAkhir->status == 'Revisi' ? 'text-yellow-600' : 'text-blue-600') }}">
                        Status Laporan Akhir
                    </p>
                    <p class="text-sm font-extrabold {{ $laporanAkhir->status == 'Disetujui' ? 'text-green-900' : ($laporanAkhir->status == 'Revisi' ? 'text-yellow-900' : 'text-blue-900') }}">
                        {{ $laporanAkhir->status }}
                    </p>
                </div>
            @endif
        </div>

        @if (session('success'))
            <div class="p-4 mb-6 text-green-700 bg-green-100 border-l-4 border-green-500 rounded-r-lg shadow-sm animate-fade-in" role="alert">
                <div class="flex items-center">
                    <i class='mr-2 text-xl bx bx-check-circle'></i>
                    <p class="font-bold">Berhasil!</p>
                </div>
                <p class="mt-1 text-sm">{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-6 text-red-700 bg-red-100 border-l-4 border-red-500 rounded-r-lg shadow-sm animate-fade-in" role="alert">
                <div class="flex items-center">
                    <i class='mr-2 text-xl bx bx-error-circle'></i>
                    <p class="font-bold">Terdapat Kesalahan!</p>
                </div>
                <ul class="pl-5 mt-1 text-sm list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($laporanAkhir && $laporanAkhir->status == 'Revisi' && $laporanAkhir->catatan_admin)
            <div class="p-4 border-l-4 border-yellow-500 rounded-lg shadow-sm bg-yellow-50 animate-fade-in">
                <div class="flex items-center gap-2 mb-2 text-yellow-700">
                    <i class='text-xl bx bx-info-circle'></i>
                    <h5 class="font-bold">Catatan Revisi dari Admin:</h5>
                </div>
                <div class="p-3 bg-white border border-yellow-100 rounded-lg text-slate-700">
                    {!! nl2br(e($laporanAkhir->catatan_admin)) !!}
                </div>
                <p class="mt-2 text-sm text-yellow-800">Silakan perbaiki laporan Anda sesuai dengan catatan di atas dan kirimkan kembali.</p>
            </div>
        @endif

        @if($laporanAkhir && $laporanAkhir->status == 'Disetujui')
            <div class="p-8 text-center border-2 border-dashed rounded-xl border-green-200 bg-green-50 animate-fade-in-up">
                <div class="flex flex-col items-center justify-center gap-4">
                    <div class="flex items-center justify-center w-20 h-20 mb-2 rounded-full bg-green-100 text-green-600">
                        <i class='text-4xl bx bx-check-double'></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">Laporan Akhir Terverifikasi</h3>
                        <p class="mt-2 text-slate-500">Selamat! Laporan akhir Anda telah disetujui oleh admin.</p>
                    </div>
                    @if($laporanAkhir->file_path)
                        <a href="{{ Storage::url($laporanAkhir->file_path) }}" target="_blank" class="flex items-center gap-2 px-6 py-3 font-bold text-white transition-all bg-green-600 rounded-xl hover:bg-green-700">
                            <i class='text-xl bx bx-download'></i>
                            <span>Unduh Laporan Saya</span>
                        </a>
                    @endif
                </div>
            </div>
        @else
            <form action="{{ $laporanAkhir ? route('peserta.laporan.akhir.update', $laporanAkhir->id) : route('peserta.laporan.akhir.store') }}"
                method="POST" enctype="multipart/form-data" id="report-form" class="space-y-6">
                @csrf
                <input type="hidden" name="status" id="status-field" value="Dikirim">
                @if($laporanAkhir)
                    @method('PUT')
                @endif

                <div class="p-6 card shadow-soft md:p-8 animate-fade-in-up">
                    <div class="flex items-center gap-3 pb-5 mb-8 border-b border-slate-100">
                        <div class="flex items-center justify-center w-10 h-10 text-xl text-purple-600 rounded-lg bg-purple-50">
                            <i class='bx bx-edit'></i>
                        </div>
                        <h4 class="text-lg font-bold uppercase text-slate-800">Form Laporan Akhir</h4>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label for="judul" class="block mb-3 text-xs font-bold tracking-widest uppercase text-slate-500">
                                Judul Laporan Akhir <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="judul" name="judul" value="{{ old('judul', $laporanAkhir->judul ?? '') }}"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('judul') border-red-500 @else @enderror"
                                placeholder="Contoh: Laporan Akhir Praktik Kerja Lapangan di PT. Contoh Jaya" required>
                        </div>

                        <div>
                            <label for="deskripsi" class="block mb-3 text-xs font-bold tracking-widest uppercase text-slate-500">
                                Ringkasan Kegiatan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="deskripsi" name="deskripsi" rows="6"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('deskripsi') border-red-500 @else @enderror"
                                placeholder="Tuliskan ringkasan singkat hasil kegiatan PKL Anda..." required>{{ old('deskripsi', $laporanAkhir->deskripsi ?? '') }}</textarea>
                        </div>

                        <div>
                            <label for="file" class="block mb-3 text-xs font-bold tracking-widest uppercase text-slate-500">
                                File Laporan (PDF/ZIP) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="file" id="file" name="file" accept="application/pdf"
                                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 @error('file') border-red-500 @else @enderror">
                            </div>
                            @if($laporanAkhir && $laporanAkhir->file_path)
                                <div class="flex items-center gap-2 p-3 mt-3 border rounded-lg bg-slate-50 border-slate-200">
                                    <i class='text-lg bx bx-file text-slate-600'></i>
                                    <a href="{{ Storage::url($laporanAkhir->file_path) }}" target="_blank" class="text-sm font-medium text-blue-600 hover:underline">
                                        File saat ini: {{ basename($laporanAkhir->file_path) }}
                                    </a>
                                </div>
                            @endif
                            <p class="mt-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Format: PDF | Maksimal 10MB</p>
                        </div>



                        <div class="flex flex-col gap-3 pt-6 border-t border-slate-100 sm:flex-row sm:justify-end">
                        @if(!$laporanAkhir || $laporanAkhir->status != 'Dikirim')
                            <button type="submit" name="status" value="Dikirim"
                                class="flex items-center justify-center gap-2 px-8 py-3 text-sm font-extrabold text-white transition-all duration-200 bg-purple-600 rounded-xl hover:bg-purple-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                <i class='text-lg bx bx-send'></i>
                                <span>{{ $laporanAkhir ? 'Update & Kirim' : 'Kirim Laporan' }}</span>
                            </button>
                        @else
                            <div class="flex items-center gap-2 px-6 py-3 text-sm font-bold text-amber-600 bg-amber-50 rounded-xl border border-amber-200">
                                <i class='text-lg bx bx-time'></i>
                                <span>Laporan sedang dalam peninjauan admin</span>
                            </div>
                        @endif
                    </div>
                    </div>
                </div>
            </form>
        @endif

        @if (isset($historyLaporanAkhir) && $historyLaporanAkhir->count() > 0)
            <div class="p-6 card shadow-soft md:p-8 animate-fade-in-up" style="animation-delay: 200ms">
                <div class="flex items-center gap-3 pb-5 mb-6 border-b border-slate-100">
                    <div class="flex items-center justify-center w-10 h-10 text-xl text-blue-600 rounded-lg bg-blue-50">
                        <i class='bx bx-history'></i>
                    </div>
                    <h4 class="text-lg font-bold uppercase text-slate-800">Riwayat Laporan Akhir ({{ $historyLaporanAkhir->total() }})</h4>
                </div>

                <div class="space-y-4">
                    @foreach ($historyLaporanAkhir as $item)
                        <div class="p-4 transition-all duration-200 border-2 border-gray-200 rounded-xl hover:border-purple-300 hover:shadow-md">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-base font-bold text-slate-900">{{ $item->judul }}</h3>
                                        <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full
                                            {{ $item->status == 'Disetujui' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $item->status == 'Dikirim' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $item->status == 'Draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $item->status == 'Revisi' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                            {{ $item->status }}
                                        </span>
                                    </div>
                                    <p class="mb-2 text-sm text-slate-600 line-clamp-2">{{ Str::limit($item->deskripsi, 150) }}</p>
                                    <div class="flex items-center gap-4 text-xs font-medium text-slate-500">
                                        <span class="flex items-center gap-1">
                                            <i class='bx bx-calendar'></i>
                                            {{ $item->created_at->format('d M Y, H:i') }}
                                        </span>
                                        @if ($item->file_path)
                                            <span class="flex items-center gap-1">
                                                <i class='bx bx-paperclip'></i>
                                                Ada lampiran
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 ml-4 sm:flex-row">
                                    <a href="{{ route('peserta.laporan.akhir.show', $item->id) }}"
                                        class="flex items-center justify-center gap-2 px-4 py-2 text-xs font-bold text-blue-600 transition-all rounded-lg bg-blue-50 hover:bg-blue-100"
                                        title="Lihat Detail">
                                        <i class='text-lg bx bx-show'></i>
                                        <span>Detail</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $historyLaporanAkhir->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
