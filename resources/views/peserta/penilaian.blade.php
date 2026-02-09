@extends('layouts.app')

@section('title', 'Hasil Penilaian')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col justify-between gap-4 p-6 md:flex-row md:items-center card shadow-soft animate-fade-in">
            <div class="flex items-center space-x-4">
                <div class="flex items-center justify-center w-12 h-12 text-2xl text-indigo-600 rounded-xl bg-indigo-50">
                    <i class='bx bx-award'></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Hasil Penilaian</h1>
                    <p class="text-sm font-medium text-slate-500">Evaluasi kinerja Anda selama masa program.</p>
                </div>
            </div>

            @if($peserta && $peserta->penilaian)
                <div class="px-4 py-2 border border-emerald-100 bg-emerald-50 rounded-xl animate-fade-in" style="animation-delay: 200ms">
                    <p class="text-xs font-bold text-emerald-600 uppercase">Status Evaluasi</p>
                    <p class="text-sm font-extrabold text-emerald-900">Selesai Dinilai</p>
                </div>
            @else
                <div class="px-4 py-2 border border-amber-100 bg-amber-50 rounded-xl animate-fade-in" style="animation-delay: 200ms">
                    <p class="text-xs font-bold text-amber-600 uppercase">Status Evaluasi</p>
                    <p class="text-sm font-extrabold text-amber-900">Sedang Diproses</p>
                </div>
            @endif
        </div>

        @if($peserta && $peserta->penilaian)
            @php $n = $peserta->penilaian; @endphp

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
                <div class="flex flex-col items-center justify-center p-8 lg:col-span-4 card shadow-soft bg-gradient-to-br from-indigo-600 to-purple-700 animate-fade-in-up" style="animation-delay: 100ms">
                    <p class="mb-4 text-sm font-bold tracking-widest text-white/80 uppercase">Nilai Akhir</p>
                    <div class="relative flex items-center justify-center w-40 h-40 mb-6 bg-white/10 rounded-full backdrop-blur-sm border border-white/20 animate-pulse-subtle">
                        <div class="text-center">
                            <h2 class="text-6xl font-black text-white leading-none">{{ $n->nilai_akhir }}</h2>
                            <p class="mt-1 text-xs font-bold text-white/70 uppercase">Skor Indeks</p>
                        </div>
                    </div>
                    <div class="px-6 py-2 bg-white rounded-full shadow-lg transform transition hover:scale-105 duration-300">
                        <p class="text-lg font-black text-indigo-900">Grade: <span class="text-2xl">{{ $n->grade }}</span></p>
                    </div>
                </div>

                <div class="p-6 lg:col-span-8 card shadow-soft animate-fade-in-up" style="animation-delay: 200ms">
                    <h4 class="mb-6 text-lg font-bold uppercase text-slate-800">Rincian Kompetensi</h4>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        @php
                            $aspek = [
                                ['label' => 'Kedisiplinan', 'icon' => 'bx-time', 'val' => $n->kedisiplinan, 'color' => 'indigo', 'delay' => '300ms'],
                                ['label' => 'Keterampilan', 'icon' => 'bx-code-alt', 'val' => $n->keterampilan, 'color' => 'purple', 'delay' => '400ms'],
                                ['label' => 'Kerjasama', 'icon' => 'bx-group', 'val' => $n->kerjasama, 'color' => 'emerald', 'delay' => '500ms'],
                                ['label' => 'Inisiatif', 'icon' => 'bx-bulb', 'val' => $n->inisiatif, 'color' => 'amber', 'delay' => '600ms'],
                                ['label' => 'Komunikasi', 'icon' => 'bx-message-dots', 'val' => $n->komunikasi, 'color' => 'blue', 'delay' => '700ms'],
                            ];
                        @endphp

                        @foreach($aspek as $a)
                            <div class="space-y-2 animate-fade-in-right" style="animation-delay: {{ $a['delay'] }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-{{ $a['color'] }}-50 text-{{ $a['color'] }}-600">
                                            <i class='bx {{ $a['icon'] }} text-lg'></i>
                                        </div>
                                        <span class="text-sm font-bold text-slate-700">{{ $a['label'] }}</span>
                                    </div>
                                    <span class="text-sm font-black text-{{ $a['color'] }}-600">{{ $a['val'] }}</span>
                                </div>
                                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                    <div class="bg-{{ $a['color'] }}-500 h-full rounded-full transition-all duration-1000 bar-fill" style="width: 0%; --target-width: {{ $a['val'] }}%;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="p-6 lg:col-span-12 card shadow-soft border-l-4 border-primary animate-fade-in-up" style="animation-delay: 400ms">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex items-center justify-center w-10 h-10 text-xl text-primary rounded-lg bg-primary/5">
                            <i class='bx bx-comment-dots'></i>
                        </div>
                        <h4 class="text-lg font-bold uppercase text-slate-800">Catatan & Feedback Pembimbing</h4>
                    </div>

                    <div class="p-5 italic rounded-xl bg-slate-50 text-slate-600 border border-slate-100 transform transition hover:bg-white duration-300">
                        @if($n->catatan)
                            "{{ $n->catatan }}"
                        @else
                            "Tidak ada catatan khusus untuk penilaian ini."
                        @endif
                    </div>

                    <div class="flex items-center justify-between mt-6 pt-6 border-t border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold border-2 border-white shadow-sm">
                                {{ strtoupper(substr($n->user->username, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase">Dinilai Oleh</p>
                                <p class="text-sm font-bold text-slate-800">{{ $n->user->username }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-400 uppercase">Tanggal Penilaian</p>
                            <p class="text-sm font-bold text-slate-800">{{ $n->updated_at->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 card shadow-soft animate-fade-in">
                <div class="w-48 h-48 mb-6 bg-slate-50 rounded-full flex items-center justify-center">
                    <i class='bx bx-hourglass text-8xl text-slate-200 animate-pulse'></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Penilaian Belum Tersedia</h3>
                <p class="text-slate-500 max-w-md text-center">
                    Sabar ya! Pembimbing Anda sedang melakukan proses evaluasi terhadap kinerja Anda selama program ini berlangsung. Tetap semangat!
                </p>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/peserta/penilaian.css') }}">
@endpush
