<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
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

        $statsQuery = Laporan::query();
        if ($tanggal) {
            $statsQuery->whereDate('tanggal_laporan', $tanggal);
        }
        if ($sekolah) {
            $statsQuery->whereHas('peserta', function ($q) use ($sekolah) {
                $q->where('asal_sekolah_universitas', $sekolah);
            });
        }
        if ($status) {
            $statsQuery->where('status', $status);
        }

        $totalReports = (clone $statsQuery)->count();
        $pendingReports = (clone $statsQuery)->where('status', 'Dikirim')->count();
        $approvedReports = (clone $statsQuery)->where('status', 'Disetujui')->count();
        $revisedReports = (clone $statsQuery)->where('status', 'Revisi')->count();

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

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Revisi',
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'status' => $request->status
        ]);

        $message = $request->status == 'Disetujui'
            ? 'Laporan berhasil disetujui.'
            : 'Laporan ditandai untuk revisi.';

        return redirect()->back()->with('success', $message);
    }
}
