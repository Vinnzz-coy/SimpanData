<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Peserta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data peserta dan user peserta yang sudah ada (opsional, untuk fresh seed)
        // Uncomment baris di bawah jika ingin menghapus data lama setiap kali seed
        // Peserta::truncate();
        // User::where('role', 'peserta')->delete();

        $sekolah = [
            'SMK Negeri 1 Jakarta',
            'SMK Negeri 2 Bandung',
            'SMK Negeri 3 Surabaya',
            'SMK Negeri 4 Yogyakarta',
            'SMK Negeri 5 Semarang',
            'SMK Negeri 6 Medan',
            'SMK Negeri 7 Makassar',
            'SMK Negeri 8 Palembang',
            'SMK Negeri 9 Denpasar',
            'SMK Negeri 10 Malang',
        ];

        $jurusan = [
            'Teknik Informatika',
            'Teknik Komputer dan Jaringan',
            'Rekayasa Perangkat Lunak',
            'Multimedia',
            'Teknik Elektronika',
            'Teknik Mesin',
            'Teknik Otomotif',
            'Akuntansi',
            'Administrasi Perkantoran',
            'Pemasaran',
        ];

        $alamat = [
            'Jl. Merdeka No. 123, Jakarta Pusat',
            'Jl. Sudirman No. 45, Bandung',
            'Jl. Diponegoro No. 67, Surabaya',
            'Jl. Malioboro No. 89, Yogyakarta',
            'Jl. Pemuda No. 12, Semarang',
            'Jl. Gatot Subroto No. 34, Medan',
            'Jl. Ahmad Yani No. 56, Makassar',
            'Jl. Jenderal Sudirman No. 78, Palembang',
            'Jl. Raya Denpasar No. 90, Denpasar',
            'Jl. Ijen No. 11, Malang',
        ];

        $nama = [
            'Ahmad Rizki Pratama',
            'Siti Nurhaliza',
            'Budi Santoso',
            'Dewi Lestari',
            'Eko Wijaya',
            'Fitri Handayani',
            'Gunawan Setiawan',
            'Hesti Purnama',
            'Indra Kurniawan',
            'Jihan Safitri',
            'Kurniawan Adi',
            'Lina Marlina',
            'Muhammad Fauzi',
            'Nurul Aisyah',
            'Oki Setiawan',
            'Putri Ayu',
            'Rizki Ramadhan',
            'Sari Dewi',
            'Teguh Prasetyo',
            'Wulan Sari',
        ];

        $jenisKegiatan = ['PKL', 'Magang'];
        $status = ['Aktif', 'Selesai'];

        for ($i = 0; $i < 20; $i++) {
            $username = 'peserta' . ($i + 1);
            $email = 'peserta' . ($i + 1) . '@example.com';

            // Cek apakah user sudah ada
            $user = User::where('username', $username)->orWhere('email', $email)->first();

            if (!$user) {
                // Buat user untuk peserta
                $user = User::create([
                    'username' => $username,
                    'email' => $email,
                    'password' => Hash::make('password123'),
                    'role' => 'peserta',
                ]);
            }

            // Cek apakah peserta sudah ada
            $pesertaExist = Peserta::where('user_id', $user->id)->first();
            if ($pesertaExist) {
                continue; // Skip jika peserta sudah ada
            }

            // Tentukan jenis kegiatan dan status
            $jenis = $jenisKegiatan[array_rand($jenisKegiatan)];
            $stat = $status[array_rand($status)];

            // Tentukan tanggal mulai dan selesai
            $tanggalMulai = Carbon::now()->subMonths(rand(1, 6))->subDays(rand(0, 30));
            $tanggalSelesai = $tanggalMulai->copy()->addMonths(rand(3, 6));

            // Jika status Selesai, pastikan tanggal selesai sudah lewat
            if ($stat === 'Selesai') {
                $tanggalSelesai = Carbon::now()->subDays(rand(1, 30));
                $tanggalMulai = $tanggalSelesai->copy()->subMonths(rand(3, 6));
            }

            // Buat data peserta
            Peserta::create([
                'user_id' => $user->id,
                'nama' => $nama[$i],
                'asal_sekolah' => $sekolah[array_rand($sekolah)],
                'jurusan' => $jurusan[array_rand($jurusan)],
                'alamat' => $alamat[array_rand($alamat)],
                'jenis_kegiatan' => $jenis,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'status' => $stat,
            ]);
        }
    }
}
