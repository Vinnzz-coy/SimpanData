<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $query = Peserta::with('user')->latest();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('asal_sekolah_universitas', 'like', "%{$search}%")
                    ->orWhere('jurusan', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('email', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%");
                    });
            });
        }

        // Filter jenis kegiatan
        if ($request->filled('jenis_kegiatan')) {
            $query->where('jenis_kegiatan', $request->jenis_kegiatan);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peserta = $query->paginate(9);

        // Jika request AJAX, kembalikan JSON dengan grid partial
        if ($request->ajax()) {
            return response()->json([
                'grid' => view('admin.peserta.partials.peserta-grid', compact('peserta'))->render()
            ]);
        }

        // Hitung statistik untuk tampilan awal
        $totalPkl = Peserta::where('jenis_kegiatan', 'PKL')->count();
        $totalMagang = Peserta::where('jenis_kegiatan', 'Magang')->count();
        $aktif = Peserta::where('status', 'Aktif')->count();
        $selesai = Peserta::where('status', 'Selesai')->count();

        return view('admin.peserta.index', compact('peserta', 'totalPkl', 'totalMagang', 'aktif', 'selesai'));
    }

    public function create()
    {
        // Hanya untuk AJAX modal
        if (request()->ajax()) {
            $html = view('admin.peserta.partials.modal-create')->render();
            return response()->json(['html' => $html]);
        }

        return redirect()->route('admin.peserta.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:user,username|max:255',
            'email' => 'required|email|unique:user,email|max:255',
            'password' => 'required|string|min:6',
            'nama' => 'required|string|max:255',
            'asal_sekolah_universitas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'jenis_kegiatan' => 'required|in:PKL,Magang',
            'status' => 'required|in:Aktif,Selesai,Arsip',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();

        try {
            // Create user
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'peserta'
            ]);

            // Handle foto upload
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('peserta/foto', 'public');
            }

            // Create peserta
            Peserta::create([
                'user_id' => $user->id,
                'nama' => $validated['nama'],
                'asal_sekolah_universitas' => $validated['asal_sekolah_universitas'],
                'jurusan' => $validated['jurusan'],
                'alamat' => $validated['alamat'],
                'no_telepon' => $validated['no_telepon'],
                'jenis_kegiatan' => $validated['jenis_kegiatan'],
                'status' => $validated['status'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'foto' => $fotoPath
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Peserta berhasil ditambahkan!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'errors' => []
            ], 500);
        }
    }

    public function show($id)
    {
        $peserta = Peserta::with(['user', 'absensis', 'laporans', 'feedbacks'])->findOrFail($id);

        if (request()->ajax()) {
            $html = view('admin.peserta.partials.modal-show', compact('peserta'))->render();
            return response()->json(['html' => $html]);
        }

        return redirect()->route('admin.peserta.index');
    }

    public function edit($id)
    {
        $peserta = Peserta::with('user')->findOrFail($id);

        if (request()->ajax()) {
            $html = view('admin.peserta.partials.modal-edit', compact('peserta'))->render();
            return response()->json(['html' => $html]);
        }

        return redirect()->route('admin.peserta.index');
    }

    public function update(Request $request, $id)
    {
        $peserta = Peserta::with('user')->findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|unique:user,username,' . $peserta->user_id,
            'email' => 'required|email|unique:user,email,' . $peserta->user_id,
            'password' => 'nullable|string|min:6',
            'nama' => 'required|string|max:255',
            'asal_sekolah_universitas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'jenis_kegiatan' => 'required|in:PKL,Magang',
            'status' => 'required|in:Aktif,Selesai,Arsip',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();

        try {
            // Update user
            $userData = [
                'username' => $validated['username'],
                'email' => $validated['email']
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $peserta->user->update($userData);

            // Handle foto upload
            $fotoPath = $peserta->foto;
            if ($request->hasFile('foto')) {
                // Delete old foto if exists
                if ($fotoPath) {
                    Storage::disk('public')->delete($fotoPath);
                }
                $fotoPath = $request->file('foto')->store('peserta/foto', 'public');
            }

            // Update peserta
            $peserta->update([
                'nama' => $validated['nama'],
                'asal_sekolah_universitas' => $validated['asal_sekolah_universitas'],
                'jurusan' => $validated['jurusan'],
                'alamat' => $validated['alamat'],
                'no_telepon' => $validated['no_telepon'],
                'jenis_kegiatan' => $validated['jenis_kegiatan'],
                'status' => $validated['status'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'foto' => $fotoPath
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Peserta berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'errors' => []
            ], 500);
        }
    }

    public function destroy($id)
    {
        $peserta = Peserta::with('user')->findOrFail($id);

        DB::beginTransaction();

        try {
            // Delete foto if exists
            if ($peserta->foto) {
                Storage::disk('public')->delete($peserta->foto);
            }

            // Delete user
            $peserta->user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Peserta berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
