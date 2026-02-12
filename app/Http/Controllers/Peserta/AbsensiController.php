<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $peserta = Peserta::where('user_id', $user->id)->firstOrFail();

        $todayAttendance = Absensi::where('peserta_id', $peserta->id)
            ->whereDate('waktu_absen', Carbon::today())
            ->get();

        $hasMasuk = $todayAttendance->where('jenis_absen', 'Masuk')->where('status', 'Hadir')->isNotEmpty();
        $hasPulang = $todayAttendance->where('jenis_absen', 'Pulang')->isNotEmpty();
        $isIzinSakit = $todayAttendance->whereIn('status', ['Izin', 'Sakit'])->isNotEmpty();

        return view('peserta.absensi', compact(
            'peserta',
            'todayAttendance',
            'hasMasuk',
            'hasPulang',
            'isIzinSakit'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:checkin,checkout',
            'latitude' => 'required',
            'longitude' => 'required',
            'mode_kerja' => 'nullable|in:WFO,WFA',
            'status' => 'required|in:Hadir,Izin,Sakit',
            'notes' => 'nullable|string|max:500',
        ]);

        // Validate mode_kerja is required only when status is "Hadir"
        if ($request->status === 'Hadir' && !$request->mode_kerja) {
            return redirect()->back()
                ->withErrors(['mode_kerja' => 'Mode kerja wajib diisi untuk status Hadir.'])
                ->withInput();
        }

        $user = Auth::user();
        $peserta = Peserta::where('user_id', $user->id)->firstOrFail();

        $jenisAbsen = $request->type == 'checkin' ? 'Masuk' : 'Pulang';

        $existingAbsensi = Absensi::where('peserta_id', $peserta->id)
            ->where('jenis_absen', $jenisAbsen)
            ->whereDate('waktu_absen', Carbon::today())
            ->first();

        if ($existingAbsensi) {
            return redirect()->route('peserta.absensi')
                ->with('error', 'Anda sudah melakukan absensi ' . strtolower($jenisAbsen) . ' hari ini.');
        }

        if ($jenisAbsen == 'Pulang') {
            $checkinToday = Absensi::where('peserta_id', $peserta->id)
                ->where('jenis_absen', 'Masuk')
                ->whereDate('waktu_absen', Carbon::today())
                ->first();

            if (!$checkinToday) {
                return redirect()->route('peserta.absensi')
                    ->with('error', 'Anda harus melakukan absensi masuk terlebih dahulu sebelum absensi pulang.');
            }
        }

        $absensi = new Absensi();
        $absensi->peserta_id = $peserta->id;
        $absensi->jenis_absen = $jenisAbsen;
        $absensi->waktu_absen = Carbon::now();
        $absensi->mode_kerja = $request->mode_kerja;
        $absensi->status = $request->status;
        $absensi->wa_pengirim = $request->notes;
        $absensi->save();

        return redirect()->route('peserta.absensi')
            ->with('success', 'absensi berhasil');
    }

    public function history()
    {
        $user = Auth::user();
        $peserta = Peserta::where('user_id', $user->id)->firstOrFail();

        $absensiHistory = Absensi::where('peserta_id', $peserta->id)
            ->orderBy('waktu_absen', 'desc')
            ->paginate(20);

        return view('peserta.absensi.history', compact('absensiHistory', 'peserta'));
    }
}
