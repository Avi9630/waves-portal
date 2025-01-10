<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperadminSeeder extends Seeder
{
    public function run(): void
    {
        //Create SUPERADMIN 
        $superadmin = User::create([
            'name'      =>  'Shankar',
            'email'     =>  'shankar@gmail.com',
            'mobile'    =>  '9999999999',
            'role_id'   =>  1,
            'password'  =>  Hash::make('password'),
        ]);
        $superadmin->assignRole('SUPERADMIN');

        //Create ADMIN
        $admin = User::create([
            'name'      =>  'Avinash kumar',
            'email'     =>  'avinash_kumar@sislinfotech.com',
            'mobile'    =>  '9958991657',
            'role_id'   =>  2,
            'password'  =>  Hash::make('password'),
        ]);
        $admin->assignRole('ADMIN');

        //Create JURY
        // $juryOne = User::create([
        //     'name'      =>  'Jury One',
        //     'email'     =>  'juryone@gmail.com',
        //     'mobile'    =>  '8899776677',
        //     'role_id'   =>  3,
        //     'password'  =>  Hash::make('password'),
        // ]);
        // $juryOne->assignRole('JURY');

        // $juryTwo = User::create([
        //     'name'      =>  'Jury Two',
        //     'email'     =>  'jurytwo@gmail.com',
        //     'mobile'    =>  '2233443344',
        //     'role_id'   =>  3,
        //     'password'  =>  Hash::make('password'),
        // ]);
        // $juryTwo->assignRole('JURY');

        //Create GRAND-JURY
        // $grandJury = User::create([
        //     'name'      =>  'Grand Jury',
        //     'email'     =>  'grandjury@gmail.com',
        //     'mobile'    =>  '6655442244',
        //     'role_id'   =>  4,
        //     'password'  =>  Hash::make('password'),
        // ]);
        // $grandJury->assignRole('GRANDJURY');
    }
}
