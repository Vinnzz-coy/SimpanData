<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        $peserta = $user->peserta;
        $filter = $request->get('filter', 'hari');

        // Statistics
        $totalHadir = 0;
        $totalLaporan = 0;
        $absensiHariIni = null;
        $progress = 0;
        $performanceScore = 0;
        $recentActivities = collect();
        $absensiData = [
            'labels' => [],
            'data' => []
        ];

        if ($peserta) {
            $totalHadir = \App\Models\Absensi::where('peserta_id', $peserta->id)
                ->where('status', 'Hadir')
                ->count();

            $totalLaporan = \App\Models\Laporan::where('peserta_id', $peserta->id)->count();

            $absensiHariIni = \App\Models\Absensi::where('peserta_id', $peserta->id)
                ->whereDate('waktu_absen', \Carbon\Carbon::today())
                ->first();

            // Progres PKL
            if ($peserta->tanggal_mulai && $peserta->tanggal_selesai) {
                $start = $peserta->tanggal_mulai;
                $end = $peserta->tanggal_selesai;
                $now = \Carbon\Carbon::now();
                $totalDays = $start->diffInDays($end);
                $passedDays = $start->diffInDays($now);
                
                if ($now < $start) $progress = 0;
                elseif ($now > $end) $progress = 100;
                else $progress = $totalDays > 0 ? round(($passedDays / $totalDays) * 100) : 0;
            }

            // Filtered Chart Data
            $absensiData = match($filter) {
                'hari' => $this->getAbsensiDataHariIni($peserta->id),
                'minggu' => $this->getAbsensiDataMingguan($peserta->id),
                'bulan' => $this->getAbsensiDataBulanan($peserta->id),
                default => $this->getAbsensiDataHariIni($peserta->id),
            };

            // Recent Activities (Still used for display logic)
            $recentActivities = \App\Models\Absensi::where('peserta_id', $peserta->id)
                ->latest('waktu_absen')
                ->limit(5)
                ->get();

            // Perhitungan Kinerja (Speedometer)
            // 1. Kehadiran (50%)
            if ($peserta->tanggal_mulai) {
                $start = \Carbon\Carbon::parse($peserta->tanggal_mulai);
                $end = $peserta->tanggal_selesai ? \Carbon\Carbon::parse($peserta->tanggal_selesai) : \Carbon\Carbon::now();
                $refDate = \Carbon\Carbon::now()->min($end);
                $totalExpectedDays = $start->diffInDays($refDate) + 1;
                $attendanceRate = $totalExpectedDays > 0 ? ($totalHadir / $totalExpectedDays) : 0;
            } else {
                $attendanceRate = 0;
            }

            // 2. Laporan (50%) - Idealnya 1 laporan per hari hadir
            $reportRate = $totalHadir > 0 ? ($totalLaporan / $totalHadir) : 0;
            $reportRate = min($reportRate, 1); // Max 100%

            $performanceScore = round((($attendanceRate * 0.5) + ($reportRate * 0.5)) * 100);
            $performanceScore = min($performanceScore, 100);
        } else {
            // Default Empty Data
            $absensiData = match($filter) {
                'hari' => ['labels' => ['08:00','10:00','12:00','14:00','16:00','18:00'], 'data' => [0,0,0,0,0,0]],
                'minggu' => ['labels' => ['Minggu 1','Minggu 2','Minggu 3','Minggu 4', 'Minggu 5'], 'data' => [0,0,0,0,0]],
                'bulan' => ['labels' => ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'], 'data' => [0,0,0,0,0,0,0,0,0,0,0,0]],
                default => ['labels' => ['08:00','10:00','12:00','14:00','16:00','18:00'], 'data' => [0,0,0,0,0,0]],
            };
        }

        if ($request->ajax()) {
            return response()->json($absensiData);
        }

        return view('peserta.dashboard', compact(
            'user', 'peserta', 'totalHadir', 'totalLaporan', 'absensiHariIni', 
            'progress', 'absensiData', 'performanceScore', 'recentActivities', 'filter'
        ));
    }

    private function getAbsensiDataHariIni($pesertaId)
    {
        $absensi = \App\Models\Absensi::selectRaw("EXTRACT(HOUR FROM waktu_absen) as jam, COUNT(*) as jumlah")
            ->where('peserta_id', $pesertaId)
            ->whereDate('waktu_absen', \Carbon\Carbon::now()->toDateString())
            ->where('status', 'Hadir')
            ->groupBy('jam')
            ->get()
            ->pluck('jumlah', 'jam');

        $labels = []; $data = [];
        // Rentang jam kerja: 08:00 - 19:00 (Mencakup lembur/pulang telat)
        for ($i = 8; $i <= 19; $i++) {
            $labels[] = sprintf("%02d:00", $i);
            $val = $absensi->get($i) ?? $absensi->get("$i") ?? 0;
            $data[] = (int)$val;
        }
        return ['labels' => $labels, 'data' => $data];
    }

    private function getAbsensiDataMingguan($pesertaId)
    {
        // Menampilkan Minggu 1 - Minggu 5 dalam bulan berjalan
        $absensi = \App\Models\Absensi::selectRaw("EXTRACT(DAY FROM waktu_absen) as hari, COUNT(*) as jumlah")
            ->where('peserta_id', $pesertaId)
            ->whereMonth('waktu_absen', \Carbon\Carbon::now()->month)
            ->whereYear('waktu_absen', \Carbon\Carbon::now()->year)
            ->where('status', 'Hadir')
            ->groupBy('hari')
            ->get();

        $labels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5'];
        $data = [0, 0, 0, 0, 0];
        
        foreach($absensi as $row) {
            $day = (int)$row->hari;
            $weekIndex = (int)ceil($day / 7) - 1;
            if ($weekIndex >= 0 && $weekIndex < 5) {
                $data[$weekIndex] += (int)$row->jumlah;
            }
        }
        return ['labels' => $labels, 'data' => $data];
    }

    private function getAbsensiDataBulanan($pesertaId)
    {
        // Menampilkan Bulan 1 - Bulan 12 dalam tahun berjalan
        $absensi = \App\Models\Absensi::selectRaw("EXTRACT(MONTH FROM waktu_absen) as bulan, COUNT(*) as jumlah")
            ->where('peserta_id', $pesertaId)
            ->whereYear('waktu_absen', \Carbon\Carbon::now()->year)
            ->where('status', 'Hadir')
            ->groupBy('bulan')
            ->get()
            ->pluck('jumlah', 'bulan');

        $labels = []; $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = "Bulan " . $i;
            $val = $absensi->get($i) ?? $absensi->get("$i") ?? 0;
            $data[] = (int)$val;
        }
        return ['labels' => $labels, 'data' => $data];
    }
}
