<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            //USER
            'create-user',
            'edit-user',
            'view-user',
            'delete-user',
            'list-user',

            //FIXED 
            'create-role',
            'edit-role',
            'view-role',
            'delete-role',
            'list-role',
            'create-permission',
            'edit-permission',
            'view-permission',
            'delete-permission',
            'list-permission',
            //FIXED END

            'assign-role',
            // 'assign-to',

            //IP-PERMISSION
            'list-ip',
            'ip-featured_download',
            'ip-non_featured_download',

            //OTT
            'list-ott',
            'ott-download',

            //CMOT
            'list-cmot',
            'cmot-download',

            //JURY
            'create-jury',
            'edit-jury',
            'view-jury',
            'delete-jury',
            'list-jury',

            //GLOBAL PERMISSION
            'assign-jury',
            'submit_feedback'
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
