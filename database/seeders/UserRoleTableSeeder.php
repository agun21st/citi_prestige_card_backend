<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('roles')->insert([
        //     'name' => "Student",
        // ]);
        DB::table('roles')->insert([
            'name' => "Admin",
        ]);
        DB::table('roles')->insert([
            'name' => "Super_Admin",
        ]);
    }
}
