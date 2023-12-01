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
            'name' => 'hod',
            'guard_name' => 'web',
        ], []);

        $finance = User::updateOrCreate(
            [
                'username' => 'hod',
            ],
            [
                'name' => 'Hod',
                'password' => bcrypt('123123123')
            ]
        );
        $finance->assignRole('hod');
    }
}
