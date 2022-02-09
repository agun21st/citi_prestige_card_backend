<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Razib",
            'email' => "mhrazib.cit.bd@gmail.com",
            'password' => bcrypt('raz0172834621'),
            'mobile' => "01712834621",
            'auth_id' => 2,
        ]);
        DB::table('users')->insert([
            'name' => "Admin",
            'email' => "admin@creativeitinstitute.com",
            'password' => bcrypt('creativeItInstitute99999'),
            'mobile' => "",
            'auth_id' => 1,
        ]);
    }
}
