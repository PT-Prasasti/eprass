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
        // Role::updateOrCreate([
        //     'name' => 'exim',
        //     'guard_name' => 'web',
        // ], []);

        $finance = User::updateOrCreate(
            [
                'username' => 'dhita@pt-prasasti.com',
            ],
            [
                'name' => 'Retno Dhita',
                'password' => bcrypt('*dhita*34932'),
                'email' => 'dhita@pt-prasasti.com'
            ]
        );
        $finance->assignRole('hod');
    }
}
