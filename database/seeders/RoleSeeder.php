<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        Role::create([
            'name' => 'superadmin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'manager',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'processing',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'sales',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'customer',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'admin_sales',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'purchasing',
            'guard_name' => 'web'
        ]);
    }
}
