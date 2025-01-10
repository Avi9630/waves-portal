<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'SUPERADMIN']);
                
        $admin      =   Role::create(['name' => 'ADMIN']);
        $admin->givePermissionTo([
            'list-role',
            'create-permission',
            'edit-permission',
            'view-permission',
            'delete-permission',
            'list-permission',
        ]);

        $jury  =   Role::create(['name' => 'JURY']);
        $jury->givePermissionTo([
            'list-cmot',
        ]);

        $grandjury  =   Role::create(['name' => 'GRANDJURY']);
        $grandjury->givePermissionTo([
            'list-cmot',
        ]);
    }
}
