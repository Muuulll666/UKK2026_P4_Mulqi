<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama'     => 'Administrator',
                'email'    => 'admin@ukk2026.com',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        ]);
    }
}