<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\LaporanAkhir;
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

    public function laporanAkhir()
    {
        $user = Auth::user();
        $peserta = Peserta::where('user_id', $user->id)->first();

        if (!$peserta) {
            return redirect()->route('peserta.dashboard')
                ->with('error', 'Data peserta tidak ditemukan.');
        }

        $laporanAkhir = LaporanAkhir::where('peserta_id', $peserta->id)->first();

        return view('peserta.laporan.laporan-akhir', compact('user', 'peserta', 'laporanAkhir'));
    }

    public function laporanAkhirStore(Request $request)
    {
        $user = Auth::user();
        $peserta = Peserta::where('user_id', $user->id)->first();

        if (!$peserta) {
            return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:10240', // Final reports usually require a file
            'status' => 'required|in:Draft,Dikirim',
        ], [
            'judul.required' => 'Judul laporan akhir harus diisi.',
            'judul.max' => 'Judul laporan akhir maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi laporan akhir harus diisi.',
            'file.required' => 'File laporan akhir wajib diunggah.',
            'file.mimes' => 'File harus berformat: PDF, DOC, DOCX, XLS, XLSX, atau ZIP.',
            'file.max' => 'Ukuran file maksimal 10MB.',
            'status.required' => 'Status laporan harus dipilih.',
            'status.in' => 'Status laporan tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $existing = LaporanAkhir::where('peserta_id', $peserta->id)->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Laporan akhir sudah ada.');
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = 'Final_' . time() . '_' . $peserta->id . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('laporan_akhir', $fileName, 'public');
        }

        LaporanAkhir::create([
            'peserta_id' => $peserta->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'status' => $request->status,
        ]);

        return redirect()->route('peserta.laporan.akhir')
            ->with('success', 'Laporan akhir berhasil disimpan.');
    }

    public function laporanAkhirUpdate(Request $request, $id)
    {
        $user = Auth::user();
        $peserta = Peserta::where('user_id', $user->id)->first();

        if (!$peserta) {
            return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
        }

        $laporanAkhir = LaporanAkhir::where('id', $id)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        if ($laporanAkhir->status == 'Disetujui') {
            return redirect()->back()->with('error', 'Laporan yang sudah disetujui tidak dapat diperbarui.');
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:10240',
            'status' => 'required|in:Draft,Dikirim',
        ], [
            'judul.required' => 'Judul laporan akhir harus diisi.',
            'deskripsi.required' => 'Deskripsi laporan akhir harus diisi.',
            'file.mimes' => 'File harus berformat: PDF, DOC, DOCX, XLS, XLSX, atau ZIP.',
            'file.max' => 'Ukuran file maksimal 10MB.',
            'status.required' => 'Status laporan harus dipilih.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $filePath = $laporanAkhir->file_path;
        if ($request->hasFile('file')) {
            if ($laporanAkhir->file_path && Storage::disk('public')->exists($laporanAkhir->file_path)) {
                Storage::disk('public')->delete($laporanAkhir->file_path);
            }
            $file = $request->file('file');
            $fileName = 'Final_' . time() . '_' . $peserta->id . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('laporan_akhir', $fileName, 'public');
        }

        $laporanAkhir->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'status' => $request->status,
            'catatan_admin' => ($request->status == 'Dikirim') ? $laporanAkhir->catatan_admin : null, // Reset notes if resent or draft? Actually better keep it until Approved.
        ]);

        return redirect()->route('peserta.laporan.akhir')
            ->with('success', 'Laporan akhir berhasil diperbarui.');
    }
}
