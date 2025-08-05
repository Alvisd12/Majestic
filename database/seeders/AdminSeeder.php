<?php
// database/seeders/AdminSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('123'),
            'phone' => '081234567890',
            'email' => 'admin@motorental.com',
        ]);

        Admin::create([
            'nama' => 'Super Admin',
            'username' => 'superadmin',
            'password' => Hash::make('superadmin123'),
            'phone' => '081234567891',
            'email' => 'superadmin@motorental.com',
        ]);
    }
}