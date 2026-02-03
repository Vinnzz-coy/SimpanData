<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Feedback;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $totalPkl = Peserta::where('jenis_kegiatan', 'PKL')->count();
            $totalMagang = Peserta::where('jenis_kegiatan', 'Magang')->count();
            $aktif = Peserta::where('status', 'Aktif')->count();
            $selesai = Peserta::where('status', 'Selesai')->count();

            $asal = request('asal_sekolah_universitas');

            $pesertaQuery = Peserta::select('id', 'nama', 'jenis_kegiatan', 'status', 'asal_sekolah_universitas')
                ->orderBy('nama');

            if (!empty($asal)) {
                $pesertaQuery->where('asal_sekolah_universitas', $asal);
            }

            $peserta = $pesertaQuery->paginate(10)->withQueryString();

            $sekolahs = Peserta::select('asal_sekolah_universitas')
                ->whereNotNull('asal_sekolah_universitas')
                ->where('asal_sekolah_universitas', '!=', '')
                ->distinct()
                ->orderBy('asal_sekolah_universitas')
                ->get();

            if (request()->ajax()) {
                return response()->json([
                    'rows' => view('admin.partials.peserta-rows', compact('peserta'))->render(),
                    'pagination' => $peserta->links()->toHtml(),
                ]);
            }

            $feedbacks = Feedback::select('id', 'peserta_id', 'pesan', 'created_at')
                ->with(['peserta:id,nama'])
                ->where('pengirim', 'Peserta')
                ->latest()
                ->limit(20)
                ->get();

            $absensiDataHari = $this->getAbsensiDataHariIni();
            $absensiDataMinggu = $this->getAbsensiDataMingguIni();
            $absensiDataBulan = $this->getAbsensiDataBulanIni();

            return view('admin.dashboard', compact(
                'totalPkl',
                'totalMagang',
                'aktif',
                'selesai',
                'peserta',
                'sekolahs',
                'asal',
                'feedbacks',
                'absensiDataHari',
                'absensiDataMinggu',
                'absensiDataBulan'
            ));
        } catch (\Exception $e) {
            return view('admin.dashboard', [
                'totalPkl' => 0,
                'totalMagang' => 0,
                'aktif' => 0,
                'selesai' => 0,
                'peserta' => collect(),
                'sekolahs' => collect(),
                'asal' => null,
                'feedbacks' => collect(),
                'absensiDataHari' => $this->getDefaultAbsensiData('hari'),
                'absensiDataMinggu' => $this->getDefaultAbsensiData('minggu'),
                'absensiDataBulan' => $this->getDefaultAbsensiData('bulan'),
            ]);
        }
    }

    private function getAbsensiDataHariIni()
    {
        try {
            $today = Carbon::today();
            
            $absensi = Absensi::selectRaw('HOUR(waktu_absen) as jam, status, COUNT(*) as jumlah')
                ->whereDate('waktu_absen', $today)
                ->whereIn('status', ['Hadir', 'Izin', 'Sakit'])
                ->groupBy('jam', 'status')
                ->get()
                ->groupBy('jam');

            $absensiData = [
                'labels' => [],
                'Hadir' => [],
                'Izin' => [],
                'Sakit' => []
            ];

            // Show hours from 07:00 to 17:00 (work hours)
            for ($i = 7; $i <= 17; $i++) {
                $absensiData['labels'][] = sprintf("%02d:00", $i);
                $hourData = $absensi->get($i, collect());
                $absensiData['Hadir'][] = $hourData->where('status', 'Hadir')->sum('jumlah') ?? 0;
                $absensiData['Izin'][] = $hourData->where('status', 'Izin')->sum('jumlah') ?? 0;
                $absensiData['Sakit'][] = $hourData->where('status', 'Sakit')->sum('jumlah') ?? 0;
            }

            return $absensiData;
        } catch (\Exception $e) {
            return $this->getDefaultAbsensiData('hari');
        }
    }

    private function getAbsensiDataMingguIni()
    {
        try {
            $startDate = Carbon::now()->subDays(6)->startOfDay();
            $endDate = Carbon::now()->endOfDay();

            $absensi = Absensi::selectRaw('DATE(waktu_absen) as tanggal, status, COUNT(*) as jumlah')
                ->whereBetween('waktu_absen', [$startDate, $endDate])
                ->whereIn('status', ['Hadir', 'Izin', 'Sakit'])
                ->groupBy('tanggal', 'status')
                ->get()
                ->groupBy('tanggal');

            $absensiData = [
                'labels' => [],
                'Hadir' => [],
                'Izin' => [],
                'Sakit' => []
            ];

            $days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $dateStr = $date->format('Y-m-d');
                $absensiData['labels'][] = $days[$date->dayOfWeek];

                $dayData = $absensi->get($dateStr, collect());
                $absensiData['Hadir'][] = $dayData->where('status', 'Hadir')->sum('jumlah') ?? 0;
                $absensiData['Izin'][] = $dayData->where('status', 'Izin')->sum('jumlah') ?? 0;
                $absensiData['Sakit'][] = $dayData->where('status', 'Sakit')->sum('jumlah') ?? 0;
            }

            return $absensiData;
        } catch (\Exception $e) {
            return $this->getDefaultAbsensiData('minggu');
        }
    }

    private function getAbsensiDataBulanIni()
    {
        try {
            $startDate = Carbon::now()->subWeeks(3)->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();

            $absensi = Absensi::selectRaw('WEEK(waktu_absen) as minggu, status, COUNT(*) as jumlah')
                ->whereBetween('waktu_absen', [$startDate, $endDate])
                ->whereIn('status', ['Hadir', 'Izin', 'Sakit'])
                ->groupBy('minggu', 'status')
                ->get()
                ->groupBy('minggu');

            $absensiData = [
                'labels' => [],
                'Hadir' => [],
                'Izin' => [],
                'Sakit' => []
            ];

            for ($i = 3; $i >= 0; $i--) {
                $week = Carbon::now()->subWeeks($i)->week;
                $absensiData['labels'][] = "Minggu " . (4 - $i);

                $weekData = $absensi->get($week, collect());
                $absensiData['Hadir'][] = $weekData->where('status', 'Hadir')->sum('jumlah') ?? 0;
                $absensiData['Izin'][] = $weekData->where('status', 'Izin')->sum('jumlah') ?? 0;
                $absensiData['Sakit'][] = $weekData->where('status', 'Sakit')->sum('jumlah') ?? 0;
            }

            return $absensiData;
        } catch (\Exception $e) {
            return $this->getDefaultAbsensiData('bulan');
        }
    }

    private function getDefaultAbsensiData($type = 'hari')
    {
        if ($type === 'bulan') {
            return [
                'labels' => ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                'Hadir' => [0, 0, 0, 0],
                'Izin' => [0, 0, 0, 0],
                'Sakit' => [0, 0, 0, 0]
            ];
        } elseif ($type === 'minggu') {
            return [
                'labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                'Hadir' => [0, 0, 0, 0, 0, 0, 0],
                'Izin' => [0, 0, 0, 0, 0, 0, 0],
                'Sakit' => [0, 0, 0, 0, 0, 0, 0]
            ];
        } else {
            $labels = [];
            for ($i = 7; $i <= 17; $i++) {
                $labels[] = sprintf("%02d:00", $i);
            }
            return [
                'labels' => $labels,
                'Hadir' => array_fill(0, count($labels), 0),
                'Izin' => array_fill(0, count($labels), 0),
                'Sakit' => array_fill(0, count($labels), 0)
            ];
        }
    }
}
