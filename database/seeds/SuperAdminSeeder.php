<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'younes',
            'username' => 'younes',
            'email' => 'nejat.andimeh@gmail.com',
            'role' => 1,
            'password' => bcrypt('NaSarjatdar#0812'),
        ]);
    }
}
