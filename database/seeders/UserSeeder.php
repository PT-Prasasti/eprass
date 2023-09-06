<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $superadmin = User::create([
            'name' => 'superadmin',
            'username' => 'superadmin',
            'password' => bcrypt('123123123')
        ]);
        $superadmin->assignRole('superadmin');

        $manager = User::create([
            'name' => 'manager',
            'username' => 'manager',
            'password' => bcrypt('123123123')
        ]);
        $manager->assignRole('manager');

        $processing = User::create([
            'name' => 'processing',
            'username' => 'processing',
            'password' => bcrypt('123123123')
        ]);
        $processing->assignRole('processing');

        $admin_sales = User::create([
            'name' => 'admin_sales',
            'username' => 'admin_sales',
            'password' => bcrypt('123123123')
        ]);
        $admin_sales->assignRole('admin_sales');

        $purchasing = User::create([
            'name' => 'purchasing',
            'username' => 'purchasing',
            'password' => bcrypt('123123123')
        ]);
        $purchasing->assignRole('purchasing');
    }
}
