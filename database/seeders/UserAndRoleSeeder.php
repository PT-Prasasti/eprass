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
   
    

        $sales = User::updateOrCreate(
            [
                'username' => 'adisti@pt-prasasti.com',
            ],
            [
                'name' => 'Adisti',
                'password' => bcrypt('cp4NO170855'),
                'email' => 'adisti@pt-prasasti.com'
            ]
        );
        $sales->assignRole('sales');
    }
}