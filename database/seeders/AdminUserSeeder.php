<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user')->updateOrInsert(
            ['email' => 'adminsimpandata@gmail.com'],
            [
                'username' => 'admin SimpanData',
                'password' => Hash::make('SimpanData123!'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
