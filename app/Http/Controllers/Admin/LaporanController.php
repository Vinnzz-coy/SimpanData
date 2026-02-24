<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\LaporanAkhir;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $sekolah = $request->asal_sekolah_universitas;
        $tanggal = $request->tanggal ?? null;

        $query = Laporan::with('peserta');

        $baseStatsQuery = Laporan::query();
        if ($tanggal) {
            $baseStatsQuery->whereDate('tanggal_laporan', $tanggal);
        }
        if ($sekolah) {
            $baseStatsQuery->whereHas('peserta', function ($q) use ($sekolah) {
                $q->where('asal_sekolah_universitas', $sekolah);
            });
        }

        $totalReports = (clone $baseStatsQuery)->count();
        $pendingReports = (clone $baseStatsQuery)->where('status', 'Dikirim')->count();
        $approvedReports = (clone $baseStatsQuery)->where('status', 'Disetujui')->count();
        $revisedReports = (clone $baseStatsQuery)->where('status', 'Revisi')->count();

        if ($status) {
            $query->where('status', $status);
        }

        if ($sekolah) {
            $query->whereHas('peserta', function ($q) use ($sekolah) {
                $q->where('asal_sekolah_universitas', $sekolah);
            });
        }

        if ($tanggal) {
            $query->whereDate('tanggal_laporan', $tanggal);
        }

        $laporans = $query->orderBy('tanggal_laporan', 'desc')
            ->paginate(10)
            ->withQueryString();

        $sekolahs = Peserta::select('asal_sekolah_universitas')
            ->whereNotNull('asal_sekolah_universitas')
            ->distinct()
            ->orderBy('asal_sekolah_universitas')
            ->get();

        return view('admin.laporan.index', compact(
            'laporans',
            'sekolahs',
            'status',
            'sekolah',
            'tanggal',
            'totalReports',
            'pendingReports',
            'approvedReports',
            'revisedReports'
        ));
    }

    public function show($id)
    {
        $laporan = Laporan::with('peserta')->findOrFail($id);

        return view('admin.laporan.show', compact('laporan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Revisi',
        ]);

        $laporan = Laporan::findOrFail($id);

        if ($laporan->status !== 'Dikirim') {
            return redirect()->back()->with('error', 'Hanya laporan dengan status "Dikirim" yang dapat disetujui atau direvisi.');
        }

        $laporan->update([
            'status' => $request->status
        ]);

        $message = $request->status == 'Disetujui'
            ? 'Laporan berhasil disetujui.'
            : 'Laporan ditandai untuk revisi.';

        return redirect()->back()->with('success', $message);
    }

    public function laporanAkhirIndex(Request $request)
    {
        $status = $request->status;
        $sekolah = $request->asal_sekolah_universitas;

        $query = LaporanAkhir::with('peserta');

        if ($status) {
            $query->where('status', $status);
        }

        if ($sekolah) {
            $query->whereHas('peserta', function ($q) use ($sekolah) {
                $q->where('asal_sekolah_universitas', $sekolah);
            });
        }

        $laporans = $query->latest()
            ->paginate(10)
            ->withQueryString();

        $sekolahs = Peserta::select('asal_sekolah_universitas')
            ->whereNotNull('asal_sekolah_universitas')
            ->distinct()
            ->orderBy('asal_sekolah_universitas')
            ->get();

        return view('admin.laporan.laporan-akhir-index', compact('laporans', 'sekolahs', 'status', 'sekolah'));
    }

    public function laporanAkhirShow($id)
    {
        $laporan = LaporanAkhir::with('peserta')->findOrFail($id);
        return view('admin.laporan.laporan-akhir-show', compact('laporan'));
    }

    public function laporanAkhirUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Revisi',
            'catatan_admin' => 'nullable|string',
        ]);

        $laporan = LaporanAkhir::findOrFail($id);

        if ($laporan->status !== 'Dikirim') {
            return redirect()->back()->with('error', 'Hanya laporan dengan status "Dikirim" yang dapat diproses.');
        }

        $laporan->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin
        ]);

        $message = $request->status == 'Disetujui'
            ? 'Laporan akhir berhasil disetujui.'
            : 'Laporan akhir ditandai untuk revisi dengan catatan.';

        return redirect()->route('admin.laporan.akhir.index')->with('success', $message);
    }
}
