<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Peserta;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesertaFactory extends Factory
{
    protected $model = Peserta::class;

    public function definition(): array
    {
        $tanggalMulai = fake()->dateTimeBetween('-6 months', 'now');
        $tanggalSelesai = fake()->dateTimeBetween($tanggalMulai, '+6 months');

        return [
            'user_id' => User::factory(),
            'foto' => null,
            'nama' => fake()->name(),
            'asal_sekolah_universitas' => fake()->company() . ' ' . fake()->randomElement(['University', 'School', 'Institute', 'College']),
            'jurusan' => fake()->randomElement([
                'Teknik Informatika',
                'Sistem Informasi',
                'Teknik Komputer',
                'Manajemen Informatika',
                'Teknik Elektro',
                'Teknik Industri',
                'Akuntansi',
                'Manajemen',
                'Psikologi',
                'Hukum',
            ]),
            'alamat' => fake()->address(),
            'no_telepon' => fake()->phoneNumber(),
            'jenis_kegiatan' => fake()->randomElement(['PKL', 'Magang']),
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'status' => fake()->randomElement(['Aktif', 'Selesai', 'Arsip']),
        ];
    }
}
