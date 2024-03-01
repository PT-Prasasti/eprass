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

        Role::updateOrCreate([
            'name' => 'hrd',
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

        $hrd = User::updateOrCreate(
            [
                'username' => 'hrd',
                'name' => 'HRD',
                'password' => bcrypt('123123123'),
            ],
        );
        $hrd->assignRole('hrd');
    

        $finance = User::updateOrCreate(
            [
                'username' => 'adisti@pt-prasasti.com',
            ],
            [
                'name' => 'Adisti',
                'password' => bcrypt('cp4NO170855'),
                'email' => 'adisti@pt-prasasti.com'
            ]
        );
        $finance->assignRole('sales');
    }
}