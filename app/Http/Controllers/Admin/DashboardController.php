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

            

            $pesertaPerSekolah = Peserta::select(
                    'asal_sekolah_universitas',
                    DB::raw('count(*) as total')
                )
                ->whereNotNull('asal_sekolah_universitas')
                ->where('asal_sekolah_universitas', '!=', '')
                ->groupBy('asal_sekolah_universitas')
                ->orderBy('total', 'desc')
                ->get();


            return view('admin.dashboard', compact(
                'totalPkl',
                'totalMagang',
                'aktif',
                'selesai',
                'peserta',
                'sekolahs',
                'asal',
                'feedbacks',
                'pesertaPerSekolah'
            ));

    }


}