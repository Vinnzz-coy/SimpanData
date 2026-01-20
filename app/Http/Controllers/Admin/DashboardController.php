<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Feedback;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPkl = Peserta::where('jenis_kegiatan', 'pkl')->count();
        $totalMagang = Peserta::where('jenis_kegiatan', 'magang')->count();
        $aktif = Peserta::where('status', 'aktif')->count();
        $selesai = Peserta::where('status', 'selesai')->count();
        $feedbacks = Feedback::with('peserta')->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalPkl',
            'totalMagang',
            'aktif',
            'selesai',
            'feedbacks'
        ));
    }
}
