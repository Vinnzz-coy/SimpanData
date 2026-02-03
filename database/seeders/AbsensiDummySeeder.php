<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Peserta;
use App\Models\User;

class AbsensiDummySeeder extends Seeder
{
    public function run(): void
    {
        $pesertaIds = Peserta::pluck('id');

        if ($pesertaIds->isEmpty()) {
            $user = User::create([
                'username' => 'peserta_dummy',
                'email' => 'peserta_dummy@example.com',
                'password' => Hash::make('password'),
                'role' => 'peserta',
            ]);

            $peserta = Peserta::create([
                'user_id' => $user->id,
                'nama' => 'Peserta Dummy',
                'asal_sekolah_universitas' => 'SMK Dummy',
                'jurusan' => 'Teknik Informatika',
                'alamat' => 'Jl. Dummy No. 1',
                'no_telepon' => '081234567890',
                'jenis_kegiatan' => 'PKL',
                'tanggal_mulai' => Carbon::now()->subWeeks(2)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addMonths(3)->toDateString(),
                'status' => 'Aktif',
            ]);

            $pesertaIds = collect([$peserta->id]);
        }

        $statuses = ['Hadir', 'Izin', 'Sakit'];
        $modes = ['WFO', 'WFA'];
        $absenTypes = ['Masuk', 'Pulang'];

        for ($i = 0; $i < 20; $i++) {
            $pesertaId = $pesertaIds->random();
            $status = $statuses[array_rand($statuses)];
            $jenisAbsen = $absenTypes[array_rand($absenTypes)];

            $date = Carbon::now()->subDays(rand(0, 14))->toDateString();
            $time = $jenisAbsen === 'Masuk'
                ? Carbon::createFromTime(rand(7, 9), rand(0, 59))
                : Carbon::createFromTime(rand(16, 18), rand(0, 59));

            Absensi::create([
                'peserta_id' => $pesertaId,
                'jenis_absen' => $jenisAbsen,
                'waktu_absen' => Carbon::parse($date . ' ' . $time->format('H:i:s')),
                'mode_kerja' => $status === 'Hadir' ? $modes[array_rand($modes)] : null,
                'status' => $status,
                'wa_pengirim' => null,
            ]);
        }
    }
}
