<?php

namespace Database\Seeders;

use App\Models\Feedback;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada data peserta
        if (Peserta::count() < 30) {
            $this->command->info('Membuat data user dan peserta dummy...');

            // Jika Peserta Factory belum tentu ada atau valid, kita buat manual user + peserta
            // Tapi karena file PesertaFactory ditemukan, kita coba pakai itu,
            // Namun untuk aman saya buat manual loop saja biar terkontrol relasinya

            for ($i = 1; $i <= 30; $i++) {
                $user = User::create([
                    'username' => 'peserta' . $i,
                    'email' => 'peserta' . $i . '@example.com',
                    'password' => bcrypt('password'),
                    'role' => 'peserta',
                ]);

                Peserta::create([
                    'user_id' => $user->id,
                    'nama' => 'Peserta Dummy ' . $i,
                    'asal_sekolah_universitas' => 'Universitas Contoh ' . $i,
                    'jurusan' => 'Teknik Informatika',
                    'alamat' => 'Jl. Contoh No. ' . $i,
                    'no_telepon' => '08123456789' . $i,
                    'jenis_kegiatan' => 'pkl',
                    'tanggal_mulai' => now()->subMonths(3),
                    'tanggal_selesai' => now()->addMonths(3),
                    'status' => 'Aktif',
                ]);
            }
        }

        $pesertas = Peserta::all();

        $feedbacksData = [
            [
                'pesan' => 'Sistem SimpanData sangat membantu saya dalam mengelola kegiatan magang. Fitur presensinya mudah digunakan dan sangat akurat.',
                'pengirim' => 'Peserta',
            ],
            [
                'pesan' => 'Tampilan aplikasinya bersih dan modern. Saya suka sekali dengan dashboard yang informatif. Semangat terus buat tim pengembang!',
                'pengirim' => 'Peserta',
            ],
            [
                'pesan' => 'Fitur laporan kegiatannya sangat praktis. Saya tidak perlu lagi buat laporan manual di kertas yang sering hilang.',
                'pengirim' => 'Peserta',
            ],
            [
                'pesan' => 'Awalnya agak bingung, tapi setelah dijelaskan ternyata sangat mudah. Mungkin bisa ditambahkan tutorial video biar lebih jelas lagi.',
                'pengirim' => 'Peserta',
            ],
            [
                'pesan' => 'Sangat memuaskan! Proses administrasi magang jadi jauh lebih cepat dan transparan. Terima kasih SimpanData.',
                'pengirim' => 'Peserta',
            ],
            [
                'pesan' => 'Mohon ditambahkan fitur notifikasi ke WhatsApp kalau ada pengumuman penting. Selebihnya sudah oke banget.',
                'pengirim' => 'Peserta',
            ],
            [
                'pesan' => 'UI/UX-nya juara! Enak dilihat berlama-lama. loading data juga cepat.',
                'pengirim' => 'Peserta',
            ],
            [
                'pesan' => 'Sangat membantu koordinasi dengan pembimbing lapangan. Semua progres terekam dengan baik.',
                'pengirim' => 'Peserta',
            ],
        ];

        foreach ($feedbacksData as $index => $data) {
            // Ambil peserta secara acak/bergiliran
            $peserta = $pesertas->random();

            Feedback::create([
                'peserta_id' => $peserta->id,
                'pengirim' => $data['pengirim'],
                'pesan' => $data['pesan'],
                'dibaca' => true,

                'created_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        $this->command->info('Berhasil membuat dummy data feedback!');
    }
}
