<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [

            'manage-users',

            'manage-vendors',

            'manage-services',

            'manage-bookings',

            'manage-payments'
        ];

        foreach($permissions as $permission)
        {
            Permission::firstOrCreate([
                'name'=>$permission
            ]);
        }
    }
}