<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 2,
                'name' => 'Life Style',
                'created_by' => 2,
                'system_ip' => NULL,
                'status' => 1,
                'created_at' => '2022-02-14 16:38:40',
                'updated_at' => '2022-02-14 16:38:40',
            ),
            1 => 
            array (
                'id' => 3,
                'name' => 'Food',
                'created_by' => 2,
                'system_ip' => NULL,
                'status' => 1,
                'created_at' => '2022-02-14 16:38:45',
                'updated_at' => '2022-02-14 16:38:45',
            ),
            2 => 
            array (
                'id' => 4,
                'name' => 'Corporate',
                'created_by' => 2,
                'system_ip' => NULL,
                'status' => 1,
                'created_at' => '2022-02-14 16:38:54',
                'updated_at' => '2022-02-14 16:38:54',
            ),
            3 => 
            array (
                'id' => 5,
                'name' => 'Health',
                'created_by' => 2,
                'system_ip' => NULL,
                'status' => 1,
                'created_at' => '2022-02-14 16:39:00',
                'updated_at' => '2022-02-14 16:39:00',
            ),
            4 => 
            array (
                'id' => 6,
                'name' => 'Ride Share',
                'created_by' => 2,
                'system_ip' => NULL,
                'status' => 1,
                'created_at' => '2022-02-14 16:39:08',
                'updated_at' => '2022-02-14 16:39:08',
            ),
            5 => 
            array (
                'id' => 7,
                'name' => 'Entertainment',
                'created_by' => 2,
                'system_ip' => NULL,
                'status' => 1,
                'created_at' => '2022-02-14 16:39:15',
                'updated_at' => '2022-02-14 16:39:15',
            ),
        ));
        
        
    }
}