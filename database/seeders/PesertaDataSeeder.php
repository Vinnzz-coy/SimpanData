<?php

namespace Database\Seeders;

use App\Models\Peserta;
use App\Models\Absensi;
use App\Models\Laporan;
use App\Models\Feedback;
use App\Models\Arsip;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PesertaDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peserta = Peserta::all();

        if ($peserta->isEmpty()) {
            $this->command->warn('Tidak ada data peserta. Silakan jalankan PesertaSeeder terlebih dahulu.');
            return;
        }

        foreach ($peserta as $p) {
            // 1. Buat data Absensi
            $this->createAbsensi($p);

            // 2. Buat data Laporan
            $this->createLaporan($p);

            // 3. Buat data Feedback
            $this->createFeedback($p);

            // 4. Buat data Arsip untuk peserta yang selesai
            if (in_array($p->status, ['Selesai', 'Arsip'])) {
                $this->createArsip($p);
            }
        }

        $this->command->info('Data dummy untuk Absensi, Laporan, Feedback, dan Arsip berhasil dibuat!');
    }

    private function createAbsensi($peserta)
    {
        $tanggalMulai = Carbon::parse($peserta->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($peserta->tanggal_selesai);
        $now = Carbon::now();

        // Batasi sampai hari ini jika tanggal selesai belum lewat
        $endDate = $tanggalSelesai->isFuture() ? $now : $tanggalSelesai;

        // Buat absensi untuk 30 hari kerja terakhir (skip weekend)
        $currentDate = $endDate->copy();
        $absensiCount = 0;
        $maxAbsensi = 30; // Maksimal 30 hari absensi

        while ($absensiCount < $maxAbsensi && $currentDate->gte($tanggalMulai)) {
            // Skip weekend (Sabtu dan Minggu)
            if ($currentDate->isWeekend()) {
                $currentDate->subDay();
                continue;
            }

            // 80% chance Hadir, 15% Izin, 5% Sakit
            $rand = rand(1, 100);
            if ($rand <= 80) {
                $status = 'Hadir';
            } elseif ($rand <= 95) {
                $status = 'Izin';
            } else {
                $status = 'Sakit';
            }

            // Buat absensi Masuk
            $waktuMasuk = $currentDate->copy()->setTime(rand(7, 9), rand(0, 59), 0);
            
            // Pastikan waktu tidak melewati sekarang
            if ($waktuMasuk->gt($now)) {
                $waktuMasuk = $now->copy()->subHours(rand(1, 3));
            }
            
            // Cek apakah sudah ada absensi untuk hari ini dengan jenis yang sama
            $existingMasuk = Absensi::where('peserta_id', $peserta->id)
                ->whereDate('waktu_absen', $currentDate->format('Y-m-d'))
                ->where('jenis_absen', 'Masuk')
                ->first();

            if (!$existingMasuk) {
                try {
                    Absensi::create([
                        'peserta_id' => $peserta->id,
                        'jenis_absen' => 'Masuk',
                        'waktu_absen' => $waktuMasuk,
                        'wa_pengirim' => '08' . rand(100000000, 999999999),
                        'status' => $status,
                    ]);

                    // Jika Hadir, buat absensi Pulang juga
                    if ($status === 'Hadir') {
                        $waktuPulang = $currentDate->copy()->setTime(rand(15, 17), rand(0, 59), 0);
                        
                        // Pastikan waktu pulang tidak melewati sekarang dan setelah waktu masuk
                        if ($waktuPulang->gt($now)) {
                            $waktuPulang = $now->copy()->subMinutes(rand(30, 120));
                        }
                        
                        if ($waktuPulang->gt($waktuMasuk)) {
                            $existingPulang = Absensi::where('peserta_id', $peserta->id)
                                ->whereDate('waktu_absen', $currentDate->format('Y-m-d'))
                                ->where('jenis_absen', 'Pulang')
                                ->first();

                            if (!$existingPulang) {
                                try {
                                    Absensi::create([
                                        'peserta_id' => $peserta->id,
                                        'jenis_absen' => 'Pulang',
                                        'waktu_absen' => $waktuPulang,
                                        'wa_pengirim' => '08' . rand(100000000, 999999999),
                                        'status' => 'Hadir',
                                    ]);
                                } catch (\Exception $e) {
                                    // Skip jika ada error (kemungkinan duplikasi)
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    // Skip jika ada error (kemungkinan duplikasi)
                }
            }

            $currentDate->subDay();
            $absensiCount++;
        }
    }

    private function createLaporan($peserta)
    {
        $judulLaporan = [
            'Laporan Mingguan PKL',
            'Laporan Bulanan Kegiatan',
            'Laporan Progress Harian',
            'Laporan Evaluasi Mingguan',
            'Laporan Kegiatan Praktik',
            'Laporan Hasil Belajar',
            'Laporan Pencapaian Target',
            'Laporan Refleksi Diri',
        ];

        $deskripsiLaporan = [
            'Pada minggu ini saya telah menyelesaikan beberapa tugas yang diberikan oleh pembimbing. Saya belajar banyak tentang sistem yang digunakan di perusahaan ini.',
            'Laporan ini berisi ringkasan kegiatan yang telah dilakukan selama periode ini. Saya telah mengikuti berbagai pelatihan dan workshop yang sangat bermanfaat.',
            'Progress yang telah dicapai pada periode ini cukup baik. Saya telah berhasil menyelesaikan beberapa project kecil dan belajar banyak hal baru.',
            'Evaluasi mingguan menunjukkan perkembangan yang positif. Saya akan terus meningkatkan kemampuan dan produktivitas kerja.',
            'Kegiatan praktik yang dilakukan meliputi pengembangan aplikasi, testing, dan dokumentasi. Semua berjalan dengan baik sesuai rencana.',
            'Hasil belajar yang diperoleh sangat memuaskan. Saya telah menguasai beberapa teknologi baru dan dapat mengaplikasikannya dalam pekerjaan.',
            'Target yang ditetapkan telah tercapai dengan baik. Saya akan terus berusaha untuk mencapai target-target berikutnya.',
            'Refleksi diri menunjukkan bahwa masih ada beberapa hal yang perlu diperbaiki. Saya akan terus belajar dan berkembang.',
        ];

        $statusLaporan = ['Draft', 'Dikirim', 'Disetujui', 'Revisi'];

        $tanggalMulai = Carbon::parse($peserta->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($peserta->tanggal_selesai);
        $now = Carbon::now();
        $endDate = $tanggalSelesai->isFuture() ? $now : $tanggalSelesai;

        // Buat 3-5 laporan per peserta
        $jumlahLaporan = rand(3, 5);

        for ($i = 0; $i < $jumlahLaporan; $i++) {
            // Tentukan tanggal laporan (mingguan)
            $tanggalLaporan = $tanggalMulai->copy()->addWeeks($i + 1);
            
            if ($tanggalLaporan->gt($endDate)) {
                break;
            }

            // Cek apakah sudah ada laporan untuk tanggal ini
            $existingLaporan = Laporan::where('peserta_id', $peserta->id)
                ->where('tanggal_laporan', $tanggalLaporan->format('Y-m-d'))
                ->first();

            if (!$existingLaporan) {
                try {
                    Laporan::create([
                        'peserta_id' => $peserta->id,
                        'judul' => $judulLaporan[array_rand($judulLaporan)] . ' - ' . ($i + 1),
                        'deskripsi' => $deskripsiLaporan[array_rand($deskripsiLaporan)],
                        'file_path' => 'laporan/laporan_' . $peserta->id . '_' . ($i + 1) . '.pdf',
                        'tanggal_laporan' => $tanggalLaporan,
                        'status' => $statusLaporan[array_rand($statusLaporan)],
                    ]);
                } catch (\Exception $e) {
                    // Skip jika ada error (kemungkinan duplikasi)
                }
            }
        }
    }

    private function createFeedback($peserta)
    {
        $pesanFeedback = [
            'Terima kasih atas bimbingannya selama ini. Saya sangat terbantu dengan program PKL ini.',
            'Program ini sangat bermanfaat untuk pengembangan skill saya. Saya belajar banyak hal baru.',
            'Pembimbing sangat membantu dan sabar dalam membimbing saya. Terima kasih banyak.',
            'Fasilitas yang disediakan sangat memadai. Saya merasa nyaman selama menjalani program ini.',
            'Saran saya, mungkin bisa ditambahkan lebih banyak workshop atau pelatihan untuk peserta.',
            'Saya sangat senang bisa mengikuti program ini. Pengalaman yang sangat berharga.',
            'Program ini membantu saya memahami dunia kerja yang sebenarnya. Sangat bermanfaat.',
            'Terima kasih untuk semua dukungan dan bimbingannya. Saya akan terus belajar dan berkembang.',
            'Saya merasa program ini sangat terorganisir dengan baik. Semua berjalan lancar.',
            'Harapan saya, program seperti ini bisa terus dilanjutkan untuk generasi berikutnya.',
        ];

        // Buat 2-4 feedback per peserta
        $jumlahFeedback = rand(2, 4);

        for ($i = 0; $i < $jumlahFeedback; $i++) {
            $tanggalFeedback = Carbon::now()->subDays(rand(1, 60));

            Feedback::create([
                'peserta_id' => $peserta->id,
                'pengirim' => 'Peserta',
                'pesan' => $pesanFeedback[array_rand($pesanFeedback)],
                'dibaca' => rand(0, 1) == 1, // Random true/false
            ]);
        }
    }

    private function createArsip($peserta)
    {
        // Cek apakah sudah ada arsip
        $existingArsip = Arsip::where('peserta_id', $peserta->id)->first();

        if (!$existingArsip) {
            $catatanArsip = [
                'Peserta telah menyelesaikan program PKL dengan baik. Semua dokumen telah lengkap.',
                'Peserta telah menyelesaikan program Magang sesuai dengan ketentuan yang berlaku.',
                'Arsip lengkap untuk peserta yang telah menyelesaikan program.',
                'Dokumen peserta telah diverifikasi dan diarsipkan dengan baik.',
                'Peserta telah menyelesaikan semua kewajiban dan dokumen telah lengkap.',
            ];

            Arsip::create([
                'peserta_id' => $peserta->id,
                'file_path' => 'arsip/arsip_peserta_' . $peserta->id . '.zip',
                'diarsipkan_pada' => Carbon::parse($peserta->tanggal_selesai)->addDays(rand(1, 7)),
                'catatan' => $catatanArsip[array_rand($catatanArsip)],
            ]);
        }
    }
}
