@extends('layouts.app')

@section('title', 'Review Laporan Akhir: ' . $laporan->peserta->nama)

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.laporan.akhir.index') }}" class="flex items-center justify-center w-10 h-10 transition-all bg-white border border-slate-200 rounded-xl hover:bg-slate-50 shadow-sm text-slate-600">
                <i class='bx bx-arrow-back text-xl'></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Review Laporan Akhir</h1>
                <p class="text-sm text-slate-500">Oleh: {{ $laporan->peserta->nama }} ({{ $laporan->peserta->asal_sekolah_universitas }})</p>
            </div>
        </div>

        @if (session('error'))
            <div class="p-4 mb-6 border-l-4 rounded-lg shadow-sm bg-red-50 border-red-500 animate-fade-in text-red-700">
                <div class="flex items-center gap-3">
                    <i class='text-xl bx bx-error-circle'></i>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="p-6 md:p-8 card shadow-soft animate-fade-in">
                    <div class="flex items-center gap-3 pb-5 mb-6 border-b border-slate-100">
                        <div class="flex items-center justify-center w-10 h-10 text-xl text-blue-600 rounded-lg bg-blue-50">
                            <i class='bx bx-file'></i>
                        </div>
                        <h4 class="text-lg font-bold uppercase text-slate-800">Detail Laporan</h4>
                    </div>

                    <div class="space-y-6">
                        <div class="p-4 border rounded-xl bg-slate-50 border-slate-100">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Judul Laporan</label>
                            <h2 class="text-xl font-bold text-slate-900 mt-1">{{ $laporan->judul }}</h2>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Ringkasan Kegiatan</label>
                            <div class="p-5 mt-2 overflow-y-auto text-sm leading-relaxed text-slate-700 whitespace-pre-wrap bg-white border border-slate-100 shadow-inner rounded-xl min-h-[150px]">
                                {{ $laporan->deskripsi }}
                            </div>
                        </div>

                        @if($laporan->file_path)
                            <div>
                                <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Dokumen Lampiran</label>
                                <div class="mt-2">
                                    <a href="{{ Storage::url($laporan->file_path) }}" target="_blank" 
                                       class="inline-flex items-center gap-3 px-6 py-3 text-sm font-bold text-blue-600 transition-all bg-white border-2 border-blue-50 rounded-xl hover:bg-blue-50 hover:border-blue-100">
                                        <i class='text-xl bx bxs-file-pdf'></i>
                                        <span>Lihat Dokumen Laporan</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="p-6 card shadow-soft animate-fade-in" style="animation-delay: 100ms">
                    <div class="flex items-center gap-3 pb-5 mb-6 border-b border-slate-100">
                        <div class="flex items-center justify-center w-10 h-10 text-xl text-purple-600 rounded-lg bg-purple-50">
                            <i class='bx bx-check-shield'></i>
                        </div>
                        <h4 class="text-lg font-bold uppercase text-slate-800">Hasil Review</h4>
                    </div>

                    <form action="{{ route('admin.laporan.akhir.update-status', $laporan->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="status" class="block mb-2 text-xs font-bold tracking-widest uppercase text-slate-500">Tentukan Keputusan</label>
                            <div class="space-y-3">
                                <label class="relative flex items-center p-4 border-2 rounded-2xl cursor-pointer transition-all hover:bg-green-50/50 group">
                                    <input type="radio" name="status" value="Disetujui" class="w-5 h-5 text-green-600 focus:ring-green-500" required>
                                    <div class="ml-4">
                                        <span class="text-sm font-bold text-slate-800">Setujui</span>
                                    </div>
                                    <i class='absolute text-xl bx bx-check-circle text-green-600 right-4 opacity-0 transition-opacity group-has-[:checked]:opacity-100'></i>
                                </label>

                                <label class="relative flex items-center p-4 border-2 rounded-2xl cursor-pointer transition-all hover:bg-amber-50/50 group">
                                    <input type="radio" name="status" value="Revisi" class="w-5 h-5 text-amber-600 focus:ring-amber-500" {{ $laporan->status == 'Revisi' ? 'checked' : '' }}>
                                    <div class="ml-4">
                                        <span class="text-sm font-bold text-slate-800">Perlu Revisi</span>
                                    </div>
                                    <i class='absolute text-xl bx bx-error-circle text-amber-600 right-4 opacity-0 transition-opacity group-has-[:checked]:opacity-100'></i>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label for="catatan_admin" class="block mb-2 text-xs font-bold tracking-widest uppercase text-slate-500">Catatan Revisi / Feedback</label>
                            <textarea name="catatan_admin" id="catatan_admin" rows="6" 
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 text-sm"
                                placeholder="Tuliskan catatan revisi atau feedback jika ada...">{{ old('catatan_admin', $laporan->catatan_admin) }}</textarea>
                            <p class="mt-2 text-[10px] text-slate-400 italic">Catatan ini akan dilihat oleh peserta jika status diset ke 'Revisi'.</p>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full px-6 py-4 text-sm font-extrabold text-white transition-all bg-purple-600 rounded-xl hover:bg-purple-700 hover:shadow-lg shadow-purple-100">
                                Simpan Keputusan Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
