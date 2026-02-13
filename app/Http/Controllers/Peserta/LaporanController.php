<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LaporanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $peserta = Peserta::where('user_id', $user->id)->first();

        if (!$peserta) {
            return redirect()->route('peserta.dashboard')
                ->with('error', 'Data peserta tidak ditemukan.');
        }

        $todayReport = Laporan::where('peserta_id', $peserta->id)
            ->where('tanggal_laporan', date('Y-m-d'))
            ->first();

        $recentReports = Laporan::where('peserta_id', $peserta->id)
            ->where('tanggal_laporan', '!=', date('Y-m-d'))
            ->orderBy('tanggal_laporan', 'desc')
            ->limit(5)
            ->get();

        $hasMoreReports = Laporan::where('peserta_id', $peserta->id)
            ->where('tanggal_laporan', '!=', date('Y-m-d'))
            ->count() > 5;

        $pendingRevisions = Laporan::where('peserta_id', $peserta->id)
            ->where('status', 'Revisi')
            ->orderBy('tanggal_laporan', 'desc')
            ->get();

        return view('peserta.laporan.laporan', compact('user', 'peserta', 'todayReport', 'recentReports', 'hasMoreReports', 'pendingRevisions'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $peserta = Peserta::where('user_id', $user->id)->first();

        if (!$peserta) {
            return redirect()->back()
                ->with('error', 'Data peserta tidak ditemukan.');
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:5120',
            'tanggal_laporan' => 'required|date',
            'status' => 'required|in:Draft,Dikirim',
        ], [
            'judul.required' => 'Judul laporan harus diisi.',
            'judul.max' => 'Judul laporan maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi kegiatan harus diisi.',
            'file.mimes' => 'File harus berformat: PDF, DOC, DOCX, JPG, PNG, atau ZIP.',
            'file.max' => 'Ukuran file maksimal 5MB.',
            'tanggal_laporan.required' => 'Tanggal laporan harus diisi.',
            'status.required' => 'Status laporan harus dipilih.',
            'status.in' => 'Status laporan tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $existingReport = Laporan::where('peserta_id', $peserta->id)
            ->where('tanggal_laporan', $request->tanggal_laporan)
            ->first();

        if ($existingReport) {
            return redirect()->back()
                ->with('error', 'Anda sudah membuat laporan untuk tanggal ini. Silakan edit laporan yang sudah ada.')
                ->withInput();
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $peserta->id . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('laporan', $fileName, 'public');
        }

        $laporan = Laporan::create([
            'peserta_id' => $peserta->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'tanggal_laporan' => $request->tanggal_laporan,
            'status' => $request->status,
        ]);

        $message = $request->status == 'Draft'
            ? 'Laporan berhasil disimpan sebagai draft.'
            : 'Laporan berhasil dikirim untuk review.';

        return redirect()->route('peserta.laporan.index')
            ->with('success', $message);
    }

    public function show(string $id)
    {
        $user = Auth::user();
        $peserta = Peserta::where('user_id', $user->id)->first();

        if (!$peserta) {
            return redirect()->route('peserta.dashboard')
                ->with('error', 'Data peserta tidak ditemukan.');
        }

        $laporan = Laporan::where('id', $id)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        return view('peserta.laporan.laporan-show', compact('user', 'peserta', 'laporan'));
    }

    public function edit(string $id)
    {
        $user = Auth::user();
        $peserta = Peserta::where('user_id', $user->id)->first();

        if (!$peserta) {
            return redirect()->route('peserta.dashboard')
                ->with('error', 'Data peserta tidak ditemukan.');
        }

        $laporan = Laporan::where('id', $id)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        if ($laporan->status == 'Disetujui') {
            return redirect()->route('peserta.laporan.show', $id)
                ->with('error', 'Laporan yang sudah disetujui tidak dapat diedit.');
        }

        return view('peserta.laporan.laporan-edit', compact('user', 'peserta', 'laporan'));
    }

    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $peserta = Peserta::where('user_id', $user->id)->first();

        if (!$peserta) {
            return redirect()->back()
                ->with('error', 'Data peserta tidak ditemukan.');
        }

        $laporan = Laporan::where('id', $id)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        if ($laporan->status == 'Disetujui') {
            return redirect()->route('peserta.laporan.show', $id)
                ->with('error', 'Laporan yang sudah disetujui tidak dapat diedit.');
        }
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:5120', // 5MB
            'status' => 'required|in:Draft,Dikirim',
        ], [
            'judul.required' => 'Judul laporan harus diisi.',
            'judul.max' => 'Judul laporan maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi kegiatan harus diisi.',
            'file.mimes' => 'File harus berformat: PDF, DOC, DOCX, JPG, PNG, atau ZIP.',
            'file.max' => 'Ukuran file maksimal 5MB.',
            'status.required' => 'Status laporan harus dipilih.',
            'status.in' => 'Status laporan tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $filePath = $laporan->file_path;
        if ($request->hasFile('file')) {
            if ($laporan->file_path && Storage::disk('public')->exists($laporan->file_path)) {
                Storage::disk('public')->delete($laporan->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $peserta->id . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('laporan', $fileName, 'public');
        }

        $laporan->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'status' => $request->status,
        ]);

        $message = $request->status == 'Draft'
            ? 'Laporan berhasil diupdate sebagai draft.'
            : 'Laporan berhasil dikirim untuk review.';

        return redirect()->route('peserta.laporan.index')
            ->with('success', $message);
    }

    public function destroy(string $id)
    {
        $user = Auth::user();
        $peserta = Peserta::where('user_id', $user->id)->first();

        if (!$peserta) {
            return redirect()->back()
                ->with('error', 'Data peserta tidak ditemukan.');
        }

        $laporan = Laporan::where('id', $id)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        if ($laporan->status != 'Draft') {
            return redirect()->back()
                ->with('error', 'Hanya laporan dengan status Draft yang dapat dihapus.');
        }
        if ($laporan->file_path && Storage::disk('public')->exists($laporan->file_path)) {
            Storage::disk('public')->delete($laporan->file_path);
        }

        $laporan->delete();

        return redirect()->route('peserta.laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
