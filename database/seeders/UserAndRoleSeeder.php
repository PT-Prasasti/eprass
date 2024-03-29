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
        // $hrd = User::updateOrCreate(
        //     [
        //         'username' => 'hrd',
        //     ],
        //     [
        //         'name' => 'hrd',
        //         'password' => bcrypt('123123123'),
        //         'email' => 'hrd'
        //     ]
        // );
        // $hrd->assignRole('hrd');

        Role::create([
            'name' => 'logistic',
            'guard_name' => 'web'
        ]);

        $logistic = User::updateOrCreate(
            [
                'username' => 'logistic',
            ],
            [
                'name' => 'logistic',
                'password' => bcrypt('123123123'),
                'email' => 'logistic'
            ]
        );
        $logistic->assignRole('logistic');
    }
}