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
                  method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
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
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('judul') border-red-500 @else border-gray-300 @enderror"
                                placeholder="Contoh: Laporan Akhir Praktik Kerja Lapangan di PT. Contoh Jaya" required {{ $laporanAkhir && $laporanAkhir->status == 'Dikirim' ? 'disabled' : '' }}>
                        </div>

                        <div>
                            <label for="deskripsi" class="block mb-3 text-xs font-bold tracking-widest uppercase text-slate-500">
                                Ringkasan Kegiatan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="deskripsi" name="deskripsi" rows="6"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('deskripsi') border-red-500 @else border-gray-300 @enderror"
                                placeholder="Tuliskan ringkasan singkat hasil kegiatan PKL Anda..." required {{ $laporanAkhir && $laporanAkhir->status == 'Dikirim' ? 'disabled' : '' }}>{{ old('deskripsi', $laporanAkhir->deskripsi ?? '') }}</textarea>
                        </div>

                        <div>
                            <label for="file" class="block mb-3 text-xs font-bold tracking-widest uppercase text-slate-500">
                                File Laporan (PDF/ZIP) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="file" id="file" name="file" accept=".pdf,.doc,.docx,.zip"
                                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 @error('file') border-red-500 @else border-gray-300 @enderror"
                                    {{ $laporanAkhir && $laporanAkhir->status == 'Dikirim' ? 'disabled' : '' }}>
                            </div>
                            @if($laporanAkhir && $laporanAkhir->file_path)
                                <div class="flex items-center gap-2 p-3 mt-3 border rounded-lg bg-slate-50 border-slate-200">
                                    <i class='text-lg bx bx-file text-slate-600'></i>
                                    <a href="{{ Storage::url($laporanAkhir->file_path) }}" target="_blank" class="text-sm font-medium text-blue-600 hover:underline">
                                        File saat ini: {{ basename($laporanAkhir->file_path) }}
                                    </a>
                                </div>
                            @endif
                            <p class="mt-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Format: PDF, DOCX, ZIP (Maks. 10MB)</p>
                        </div>

                        <div>
                            <label class="block mb-3 text-xs font-bold tracking-widest uppercase text-slate-500">Status Laporan</label>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <label class="relative flex items-center p-4 border-2 rounded-2xl cursor-pointer transition-all hover:border-purple-300 hover:bg-purple-50/30 group {{ ($laporanAkhir && $laporanAkhir->status == 'Dikirim') ? 'opacity-50 cursor-not-allowed' : '' }}">
                                    <input type="radio" name="status" value="Draft" class="w-5 h-5 text-purple-600"
                                        {{ old('status', $laporanAkhir->status ?? 'Draft') == 'Draft' ? 'checked' : '' }}
                                        {{ $laporanAkhir && $laporanAkhir->status == 'Dikirim' ? 'disabled' : '' }}>
                                    <div class="ml-4">
                                        <span class="text-base font-bold text-slate-800">Draft</span>
                                        <p class="text-xs font-medium text-slate-500">Simpan untuk dikirim nanti</p>
                                    </div>
                                    <i class='absolute text-xl bx bx-check-circle text-purple-600 right-4 opacity-0 transition-opacity group-has-[:checked]:opacity-100'></i>
                                </label>

                                <label class="relative flex items-center p-4 border-2 rounded-2xl cursor-pointer transition-all hover:border-green-400 hover:bg-green-50/50 group {{ ($laporanAkhir && $laporanAkhir->status == 'Dikirim') ? 'opacity-100 bg-green-50 border-green-500' : '' }}">
                                    <input type="radio" name="status" value="Dikirim" class="w-5 h-5 text-green-600"
                                        {{ old('status', $laporanAkhir->status ?? '') == 'Dikirim' ? 'checked' : '' }}
                                        {{ $laporanAkhir && $laporanAkhir->status == 'Dikirim' ? 'disabled' : '' }}>
                                    <div class="ml-4">
                                        <span class="text-base font-bold text-slate-800">Kirim</span>
                                        <p class="text-xs font-medium text-slate-500">Kirim untuk review admin</p>
                                    </div>
                                    <i class='absolute text-xl bx bx-check-circle text-green-600 right-4 opacity-0 transition-opacity group-has-[:checked]:opacity-100'></i>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end pt-6 border-t border-slate-100">
                             @if(!$laporanAkhir || $laporanAkhir->status != 'Dikirim')
                                <button type="submit" class="px-8 py-3 text-sm font-extrabold text-white transition-all bg-purple-600 rounded-xl hover:bg-purple-700 hover:shadow-lg">
                                    <div class="flex items-center gap-2">
                                        <i class='text-lg bx bx-save'></i>
                                        <span>{{ $laporanAkhir ? 'Simpan Perubahan' : 'Kirim Laporan Akhir' }}</span>
                                    </div>
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
    </div>
@endsection
