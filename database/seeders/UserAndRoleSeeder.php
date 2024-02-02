<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;

class UserAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::updateOrCreate([
            'name' => 'exim',
            'guard_name' => 'web',
        ], []);
        
        $exim = User::updateOrCreate(
            [
                'username' => 'exim',
                'name' => 'EXIM',
                'password' => bcrypt('123123123'),
            ],
        );
        $exim->assignRole('exim');
    

        $finance = User::updateOrCreate(
            [
                'username' => 'dhita@pt-prasasti.com',
            ],
            [
                'name' => 'Fitri',
                'password' => bcrypt('cp4NO170902'),
                'email' => 'fitri@pt-prasasti.com'
            ]
        );
        $finance->assignRole('purchasing');
    }
}