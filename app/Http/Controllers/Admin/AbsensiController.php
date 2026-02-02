<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\AbsensiExport;
use Maatwebsite\Excel\Facades\Excel;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $tanggal   = $request->tanggal ?? Carbon::today()->toDateString();
        $pesertaId = $request->peserta_id;
        $jenis     = $request->jenis_absen;
        $status    = $request->status;
        $sekolah = request('asal_sekolah_universitas');

        $query = Absensi::with('peserta')
            ->whereDate('waktu_absen', $tanggal);

        if ($pesertaId) {
            $query->where('peserta_id', $pesertaId);
        }

        if ($jenis) {
            $query->where('jenis_absen', $jenis);
        }

        if ($status) {
            $query->where('status', $status);
        }

         if ($sekolah) {
            $query->whereHas('peserta', function ($q) use ($sekolah) {
                $q->where('asal_sekolah_universitas', $sekolah);
            });
        }

        if ($request->export === 'excel') {
            $data = $query
                ->orderBy('waktu_absen', 'desc')
                ->get();

            return Excel::download(
                new AbsensiExport($data),
                'absensi_' . $tanggal . '.xlsx'
            );
        }

        $absensis = $query
            ->orderBy('waktu_absen', 'desc')
            ->paginate(10)
            ->withQueryString();

        $hadirMasuk = Absensi::whereDate('waktu_absen', $tanggal)
            ->where('status', 'Hadir')
            ->where('jenis_absen', 'Masuk')
            ->count();

        $hadirPulang = Absensi::whereDate('waktu_absen', $tanggal)
            ->where('status', 'Hadir')
            ->where('jenis_absen', 'Pulang')
            ->count();

        $izin = Absensi::whereDate('waktu_absen', $tanggal)
            ->where('status', 'Izin')
            ->count();

        $sakit = Absensi::whereDate('waktu_absen', $tanggal)
            ->where('status', 'Sakit')
            ->count();

        $wfo = Absensi::whereDate('waktu_absen', $tanggal)
            ->where('status', 'Hadir')
            ->where('jenis_absen', 'Masuk')
            ->where('mode_kerja', 'WFO')
            ->count();

        $wfa = Absensi::whereDate('waktu_absen', $tanggal)
            ->where('status', 'Hadir')
            ->where('jenis_absen', 'Masuk')
            ->where('mode_kerja', 'WFA')
            ->count();
            
        $sekolahs = Peserta::select('asal_sekolah_universitas')
            ->whereNotNull('asal_sekolah_universitas')
            ->distinct()
            ->orderBy('asal_sekolah_universitas')
            ->get();


        return view('admin.absensi.index', compact(
  'sekolahs',
 'sekolah',
            'absensis',
            'hadirMasuk',
            'hadirPulang',
            'izin',
            'sakit',
            'wfo',
            'wfa',
            'tanggal',
            'pesertaId',
            'jenis',
            'status'
        ))->with([
            'pesertas' => Peserta::orderBy('nama')->get()
        ]);
    }
}
