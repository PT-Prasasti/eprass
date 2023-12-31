<?php

namespace Database\Seeders;

use App\Models\Sales;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sales::create([
            'name' => 'superadmin',
            'email' => 'superadmin@app.com',
            'phone' => '0888888888888',
            'username' => 'superadmin',
        ]);
    }
}
