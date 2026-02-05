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
        $weekFilter = $request->get('week'); // Date string Y-m-d

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
        $availableWeeks = [];

        if ($peserta) {
            $totalHadir = \App\Models\Absensi::where('peserta_id', $peserta->id)
                ->where('status', 'Hadir')
                ->count();

            $totalLaporan = \App\Models\Laporan::where('peserta_id', $peserta->id)->count();

            $absensiHariIni = \App\Models\Absensi::where('peserta_id', $peserta->id)
                ->whereDate('waktu_absen', \Carbon\Carbon::today())
                ->first();

            // Calculate Available Weeks for Dropdown
            $start = $peserta->tanggal_mulai ? \Carbon\Carbon::parse($peserta->tanggal_mulai) : \Carbon\Carbon::now()->subMonths(6);
            $end = $peserta->tanggal_selesai ? \Carbon\Carbon::parse($peserta->tanggal_selesai) : \Carbon\Carbon::now();
            
            // Limit to 6 months back if no explicit start date
            if (!$peserta->tanggal_mulai && $start->diffInMonths($end) > 6) {
                $start = $end->copy()->subMonths(6);
            }
            // Align start to start of week (Monday)
            $start = $start->copy()->startOfWeek();
            $period = \Carbon\CarbonPeriod::create($start, '1 week', $end);

            $weekCounter = 1;
            foreach($period as $date) {
                $weekEnd = $date->copy()->endOfWeek();
                $availableWeeks[] = [
                    'value' => $date->format('Y-m-d'),
                    'label' => "Minggu $weekCounter (" . $date->format('d M') . " - " . $weekEnd->format('d M') . ")"
                ];
                $weekCounter++;
            }

            // Default to latest week if not specified
            if (!$weekFilter && count($availableWeeks) > 0) {
                 // Optionally default to current week, or last week in list
                 // Let's default to the *current* week if within range, otherwise last available
                 $latestWeek = end($availableWeeks)['value'];
                 $weekFilter = $latestWeek;
            }

            // Progres PKL
            $totalDays = 0;
            $passedDays = 0;
            
            if ($peserta->tanggal_mulai && $peserta->tanggal_selesai) {
                $startPkl = $peserta->tanggal_mulai;
                $endPkl = $peserta->tanggal_selesai;
                
                $totalDays = $startPkl->diffInDays($endPkl) + 1; // Inclusive
                
                // Count actual active days (attendance)
                // Postgres compatible date extraction
                $passedDays = \App\Models\Absensi::where('peserta_id', $peserta->id)
                    ->where('status', 'Hadir')
                    ->distinct()
                    ->count(\DB::raw('DATE(waktu_absen)'));
                
                // Progress based on Activity Count vs Duration (Note: This might be lower than time-based progress)
                $progress = $totalDays > 0 ? round(($passedDays / $totalDays) * 100) : 0;
            }

            // Filtered Chart Data
            $absensiData = match($filter) {
                'hari' => $this->getAbsensiDataHariIni($peserta->id),
                'minggu' => $this->getAbsensiDataMingguan($peserta, $weekFilter),
                'bulan' => $this->getAbsensiDataBulanan($peserta),
                default => $this->getAbsensiDataHariIni($peserta->id),
            };

            // Recent Activities
            $recentActivities = \App\Models\Absensi::where('peserta_id', $peserta->id)
                ->latest('waktu_absen')
                ->limit(5)
                ->get();

            // Perhitungan Kinerja (Speedometer)
            if ($peserta->tanggal_mulai) {
                $start = \Carbon\Carbon::parse($peserta->tanggal_mulai);
                $end = $peserta->tanggal_selesai ? \Carbon\Carbon::parse($peserta->tanggal_selesai) : \Carbon\Carbon::now();
                $refDate = \Carbon\Carbon::now()->min($end);
                $totalExpectedDays = $start->diffInDays($refDate) + 1;
                $attendanceRate = $totalExpectedDays > 0 ? ($totalHadir / $totalExpectedDays) : 0;
            } else {
                $attendanceRate = 0;
            }

            // 2. Laporan (50%)
            $reportRate = $totalHadir > 0 ? ($totalLaporan / $totalHadir) : 0;
            $reportRate = min($reportRate, 1); // Max 100%

            $performanceScore = round((($attendanceRate * 0.5) + ($reportRate * 0.5)) * 100);
            $performanceScore = min($performanceScore, 100);
        } else {
            // Default Empty Data
            $absensiData = match($filter) {
                'hari' => ['labels' => ['08:00','10:00','12:00','14:00','16:00','18:00'], 'data' => [0,0,0,0,0,0]],
                'minggu' => ['labels' => ['Sen','Sel','Rab','Kam', 'Jum', 'Sab', 'Min'], 'data' => [0,0,0,0,0,0,0]],
                'bulan' => ['labels' => ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'], 'data' => [0,0,0,0,0,0,0,0,0,0,0,0]],
                default => ['labels' => ['08:00','10:00','12:00','14:00','16:00','18:00'], 'data' => [0,0,0,0,0,0]],
            };
        }

        if ($request->ajax()) {
            return response()->json($absensiData);
        }

        return view('peserta.dashboard', compact(
            'user', 'peserta', 'totalHadir', 'totalLaporan', 'absensiHariIni', 
            'progress', 'absensiData', 'performanceScore', 'recentActivities', 'filter', 'availableWeeks', 'weekFilter',
            'passedDays', 'totalDays'
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
        // Rentang jam kerja: 08:00 - 19:00
        for ($i = 8; $i <= 19; $i++) {
            $labels[] = sprintf("%02d:00", $i);
            $val = $absensi->get($i) ?? $absensi->get("$i") ?? 0;
            $data[] = (int)$val;
        }
        return ['labels' => $labels, 'data' => $data];
    }

    private function getAbsensiDataMingguan($peserta, $weekStartDate)
    {
        if (!$weekStartDate) {
             return ['labels' => [], 'data' => []];
        }

        $start = \Carbon\Carbon::parse($weekStartDate)->startOfWeek(); // Ensure Monday
        $end = $start->copy()->endOfWeek();

        // Get Daily Attendance for that week
        // We select Day Of Week (1=Sunday, 2=Monday... in ODBC? No, EXTRACT(ISODOW) is better in Postgres)
        // PostgreSQL: EXTRACT(ISODOW FROM ...) Returns 1 (Monday) to 7 (Sunday)
        $absensi = \App\Models\Absensi::selectRaw("EXTRACT(ISODOW FROM waktu_absen) as hari_ke, COUNT(*) as jumlah")
            ->where('peserta_id', $peserta->id)
            ->whereBetween('waktu_absen', [$start->startOfDay(), $end->endOfDay()])
            ->where('status', 'Hadir')
            ->groupBy('hari_ke')
            ->get()
            ->pluck('jumlah', 'hari_ke');

        $labels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $data = [];
        
        // ISODOW: 1=Monday, 7=Sunday. Array index 0=Monday.
        for ($i = 1; $i <= 7; $i++) {
            $val = $absensi->get($i) ?? 0;
            $data[] = (int)$val; // Usually 1 or 2 (In/Out) -> divide by 2? Or just raw count? 
            // Previous chart was count. If Masuk+Pulang = 2. 
            // If we want "Hadir" (Present), maybe divide by 2 or just show raw activity count.
            // Dashboard summary says "Total Hadir 10 Hari". 
            // Let's show distinct days? No, query is count(*). 
            // If user did Masuk & Pulang, count is 2. The chart Y-axis will show 2.
            // That's acceptable for "Activity".
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getAbsensiDataBulanan($peserta)
    {
        $start = $peserta->tanggal_mulai ? \Carbon\Carbon::parse($peserta->tanggal_mulai) : \Carbon\Carbon::now()->subMonths(6);
        $end = $peserta->tanggal_selesai ? \Carbon\Carbon::parse($peserta->tanggal_selesai) : \Carbon\Carbon::now();

        if ($start->diffInMonths($end) > 12) {
             $start = $end->copy()->subMonths(12);
        }

        // PostgreSQL compatible query
        $absensi = \App\Models\Absensi::selectRaw("TO_CHAR(waktu_absen, 'YYYY-MM') as periode, COUNT(*) as jumlah")
            ->where('peserta_id', $peserta->id)
            ->whereBetween('waktu_absen', [$start->startOfMonth(), $end->endOfMonth()])
            ->where('status', 'Hadir')
            ->groupBy('periode')
            ->get()
            ->pluck('jumlah', 'periode');

        $labels = [];
        $data = [];
        
        $period = \Carbon\CarbonPeriod::create($start->startOfMonth(), '1 month', $end->endOfMonth());

        foreach ($period as $date) {
            $key = $date->format('Y-m');
            $labels[] = $date->format('M Y');
            $val = $absensi->get($key) ?? 0;
            $data[] = (int)$val;
        }

        return ['labels' => $labels, 'data' => $data];
    }
}
