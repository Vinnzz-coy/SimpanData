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

            $peserta = Peserta::select('id', 'nama', 'jenis_kegiatan', 'status')
                ->orderBy('nama')
                ->paginate(10);

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

            $absensiDataHarian = $this->getAbsensiDataHarian();
            $absensiDataBulanan = $this->getAbsensiDataBulanan();
            $absensiDataTahunan = $this->getAbsensiDataTahunan();

            return view('admin.dashboard', compact(
                'totalPkl',
                'totalMagang',
                'aktif',
                'selesai',
                'peserta',
                'feedbacks',
                'absensiDataHarian',
                'absensiDataBulanan',
                'absensiDataTahunan'
            ));
        } catch (\Exception $e) {
            return view('admin.dashboard', [
                'totalPkl' => 0,
                'totalMagang' => 0,
                'aktif' => 0,
                'selesai' => 0,
                'peserta' => collect(),
                'feedbacks' => collect(),
                'absensiDataHarian' => $this->getDefaultAbsensiData(),
                'absensiDataBulanan' => $this->getDefaultAbsensiData('bulan'),
                'absensiDataTahunan' => $this->getDefaultAbsensiData('tahun'),
            ]);
        }
    }

    private function getAbsensiDataHarian()
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

            $days = ['Ming', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $dateStr = $date->format('Y-m-d');
                $absensiData['labels'][] = $days[$date->dayOfWeek] ?? 'Hari';

                $dayData = $absensi->get($dateStr, collect());
                $absensiData['Hadir'][] = $dayData->where('status', 'Hadir')->sum('jumlah') ?? 0;
                $absensiData['Izin'][] = $dayData->where('status', 'Izin')->sum('jumlah') ?? 0;
                $absensiData['Sakit'][] = $dayData->where('status', 'Sakit')->sum('jumlah') ?? 0;
            }

            return $absensiData;
        } catch (\Exception $e) {
            return $this->getDefaultAbsensiData();
        }
    }

    private function getAbsensiDataBulanan()
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

    private function getAbsensiDataTahunan()
    {
        try {
            $startDate = Carbon::now()->subMonths(5)->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();

            $absensi = Absensi::selectRaw('YEAR(waktu_absen) as tahun, MONTH(waktu_absen) as bulan, status, COUNT(*) as jumlah')
                ->whereBetween('waktu_absen', [$startDate, $endDate])
                ->whereIn('status', ['Hadir', 'Izin', 'Sakit'])
                ->groupBy('tahun', 'bulan', 'status')
                ->get()
                ->groupBy(function($item) {
                    return $item->tahun . '-' . $item->bulan;
                });

            $absensiData = [
                'labels' => [],
                'Hadir' => [],
                'Izin' => [],
                'Sakit' => []
            ];

            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $key = $date->format('Y-n');
                $absensiData['labels'][] = $months[$date->month - 1];

                $monthData = $absensi->get($key, collect());
                $absensiData['Hadir'][] = $monthData->where('status', 'Hadir')->sum('jumlah') ?? 0;
                $absensiData['Izin'][] = $monthData->where('status', 'Izin')->sum('jumlah') ?? 0;
                $absensiData['Sakit'][] = $monthData->where('status', 'Sakit')->sum('jumlah') ?? 0;
            }

            return $absensiData;
        } catch (\Exception $e) {
            return $this->getDefaultAbsensiData('tahun');
        }
    }

    private function getDefaultAbsensiData($type = 'harian')
    {
        if ($type === 'bulan') {
            return [
                'labels' => ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                'Hadir' => [0, 0, 0, 0],
                'Izin' => [0, 0, 0, 0],
                'Sakit' => [0, 0, 0, 0]
            ];
        } elseif ($type === 'tahun') {
            return [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                'Hadir' => [0, 0, 0, 0, 0, 0],
                'Izin' => [0, 0, 0, 0, 0, 0],
                'Sakit' => [0, 0, 0, 0, 0, 0]
            ];
        } else {
            return [
                'labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                'Hadir' => [0, 0, 0, 0, 0, 0, 0],
                'Izin' => [0, 0, 0, 0, 0, 0, 0],
                'Sakit' => [0, 0, 0, 0, 0, 0, 0]
            ];
        }
    }
}
