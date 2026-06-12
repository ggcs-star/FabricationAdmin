<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // First Admin
        $admin1 = User::firstOrCreate(
            [
                'email' => 'admin@example.com'
            ],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin@123')
            ]
        );

        $admin1->assignRole('admin');

        // Second Admin
        $admin2 = User::firstOrCreate(
            [
                'email' => 'navin@admin.com'
            ],
            [
                'name' => 'Navin Admin',
                'password' => Hash::make('pass123')
            ]
        );

        $admin2->assignRole('admin');
    }
}