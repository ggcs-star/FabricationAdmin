<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admin = User::firstOrCreate(
            [
                'email' => 'admin@example.com'
            ],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin@123')
            ]
        );

        $admin->assignRole('admin');
    }
}
