<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'vendor', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);

        // Create Admin User if it doesn't exist
        if (! User::where('email', 'admin@example.com')->exists()) {
            $adminUser = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'phone' => '9876543210',
                'password' => Hash::make('password'),
                'status' => 'active',
            ]);

            $adminUser->assignRole($adminRole);
        }
    }
}