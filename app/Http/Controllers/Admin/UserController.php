<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = User::where('role', 'peserta')
            ->with('peserta')
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $baseQuery->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('peserta', function ($pesertaQuery) use ($search) {
                        $pesertaQuery->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('profile_status')) {
            if ($request->profile_status === 'complete') {
                $baseQuery->has('peserta');
            } elseif ($request->profile_status === 'incomplete') {
                $baseQuery->doesntHave('peserta');
            }
        }

        if ($request->filled('asal_sekolah_universitas')) {
            $baseQuery->whereHas('peserta', function ($pesertaQuery) use ($request) {
                $pesertaQuery->where('asal_sekolah_universitas', $request->asal_sekolah_universitas);
            });
        }

        $users = (clone $baseQuery)->paginate(9);

        $statsQuery = clone $baseQuery;
        $totalPeserta = (clone $statsQuery)->count();
        $profileComplete = (clone $statsQuery)->has('peserta')->count();
        $profileIncomplete = (clone $statsQuery)->doesntHave('peserta')->count();

        if ($request->ajax()) {
            return response()->json([
                'grid' => view('admin.user.partials.user-grid', compact('users'))->render(),
                'stats' => [
                    'total' => $totalPeserta,
                    'complete' => $profileComplete,
                    'incomplete' => $profileIncomplete,
                ],
            ]);
        }

        $sekolahs = \App\Models\Peserta::select('asal_sekolah_universitas')
            ->whereNotNull('asal_sekolah_universitas')
            ->where('asal_sekolah_universitas', '!=', '')
            ->distinct()
            ->orderBy('asal_sekolah_universitas')
            ->get();

        return view('admin.user.index', compact(
            'users',
            'totalPeserta',
            'profileComplete',
            'profileIncomplete',
            'sekolahs'
        ));
    }

    public function show($id)
    {
        $user = User::with('peserta')->findOrFail($id);

        if (request()->ajax()) {
            $html = view('admin.user.partials.modal-show', compact('user'))->render();
            return response()->json(['html' => $html]);
        }

        return redirect()->route('admin.user.index');
    }
}
