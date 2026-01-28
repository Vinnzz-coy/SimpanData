<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Absensi;
use App\Models\Laporan;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function index()
    {
        try {
            $totalPeserta = Peserta::count();

            $totalLaporan = Laporan::count();

            $pesertaAktif = Peserta::where('status', 'Aktif')->count();

            $startDate = Carbon::now()->subDays(30);
            $totalAbsensiHadir = Absensi::where('status', 'Hadir')
                ->where('waktu_absen', '>=', $startDate)
                ->select('peserta_id')
                ->distinct()
                ->count('peserta_id');

            $tingkatKehadiran = $pesertaAktif > 0
                ? round(($totalAbsensiHadir / $pesertaAktif) * 100)
                : 0;

            $laporanMasuk = Laporan::where('status', 'Dikirim')->count();

            $feedbackSelesai = Feedback::where('dibaca', true)->count();

            $laporanProgress = $pesertaAktif > 0
                ? round(($laporanMasuk / $pesertaAktif) * 100)
                : 0;

            $feedbackProgress = $pesertaAktif > 0
                ? round(($feedbackSelesai / $pesertaAktif) * 100)
                : 0;

            $recentAbsensi = Absensi::with('peserta:id,nama')
                ->latest('waktu_absen')
                ->first();

            $recentLaporan = Laporan::with('peserta:id,nama')
                ->latest('tanggal_laporan')
                ->first();

            $feedbacks = Feedback::with('peserta:id,nama,jenis_kegiatan')
                ->where('pengirim', 'Peserta')
                ->where('dibaca', true)
                ->latest()
                ->limit(20)
                ->get();

            return view('index', compact(
                'totalPeserta',
                'totalLaporan',
                'tingkatKehadiran',
                'pesertaAktif',
                'laporanMasuk',
                'feedbackSelesai',
                'laporanProgress',
                'feedbackProgress',
                'recentAbsensi',
                'recentLaporan',
                'feedbacks'
            ));
        } catch (\Exception $e) {
            return view('index', [
                'totalPeserta' => 0,
                'totalLaporan' => 0,
                'tingkatKehadiran' => 0,
                'pesertaAktif' => 0,
                'laporanMasuk' => 0,
                'feedbackSelesai' => 0,
                'laporanProgress' => 0,
                'feedbackProgress' => 0,
                'recentAbsensi' => null,
                'recentLaporan' => null,
                'feedbacks' => collect(),
            ]);
        }
    }
}
