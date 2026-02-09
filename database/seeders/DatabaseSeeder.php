<?php

namespace Database\Seeders;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);
        $this->call(FeedbackSeeder::class);
        $this->call(AbsensiDummySeeder::class);
        $this->call(AbsensiSeeder::class);
        $this->call(IpinSeeder::class);
        $this->call(PesertaDummySeeder::class);
    }
}
