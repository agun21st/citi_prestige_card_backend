<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Razib',
                'email' => 'mhrazib.cit.bd@gmail.com',
                'password' => '$2y$10$1CCP4MgecepdmYaQ7ytw6u5P7T1BsR0dJKlBQuy8zczaa5ojQMEem',
                'email_verified_at' => NULL,
                'mobile' => '01712834621',
                'image' => NULL,
                'auth_id' => 2,
                'system_ip' => NULL,
                'status' => 1,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Admin',
                'email' => 'admin@creativeitinstitute.com',
                'password' => '$2y$10$mSBqj.2tYdc59efDwWwTKe.3hXDYPOtm/HJqCkQYXbSzvlESpnqeq',
                'email_verified_at' => NULL,
                'mobile' => '',
                'image' => NULL,
                'auth_id' => 1,
                'system_ip' => NULL,
                'status' => 1,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}