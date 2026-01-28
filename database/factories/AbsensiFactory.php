<?php

namespace Database\Factories;

use App\Models\Peserta;
use App\Models\Absensi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class AbsensiFactory extends Factory
{
    protected $model = Absensi::class;

    public function definition(): array
    {
        $waktuAbsen = fake()->dateTimeBetween('-30 days', 'now');
        $jenisAbsen = fake()->randomElement(['Masuk', 'Pulang']);
        $status = fake()->randomElement(['Hadir', 'Izin', 'Sakit']);
        $keteranganKehadiran = fake()->randomElement(['Tepat Waktu', 'Terlambat']);
        $alasanTerlambat = $keteranganKehadiran === 'Terlambat' ? fake()->sentence() : null;

        return [
            'peserta_id' => Peserta::factory(),
            'jenis_absen' => $jenisAbsen,
            'waktu_absen' => $waktuAbsen,
            'mode_kerja' => fake()->randomElement(['WFO', 'WFA']),
            'keterangan_kehadiran' => $keteranganKehadiran,
            'alasan_terlambat' => $alasanTerlambat,
            'bukti_terlambat' => $alasanTerlambat ? fake()->imageUrl() : null,
            'status' => $status,
            'wa_pengirim' => fake()->phoneNumber(),
        ];
    }
}
