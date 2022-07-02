<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('brands')->delete();
        
        \DB::table('brands')->insert(array (
            0 => 
            array (
                'id' => 2,
                'name' => 'Akash',
                'category_id' => 7,
                'created_by' => 2,
                'system_ip' => NULL,
                'status' => 1,
                'created_at' => '2022-02-14 16:40:56',
                'updated_at' => '2022-02-14 16:40:56',
            ),
            1 => 
            array (
                'id' => 3,
                'name' => 'Delox',
                'category_id' => 3,
                'created_by' => 2,
                'system_ip' => NULL,
                'status' => 1,
                'created_at' => '2022-02-14 16:41:04',
                'updated_at' => '2022-02-15 17:36:27',
            ),
            2 => 
            array (
                'id' => 4,
                'name' => 'Concord',
                'category_id' => 4,
                'created_by' => 2,
                'system_ip' => NULL,
                'status' => 1,
                'created_at' => '2022-02-14 16:41:13',
                'updated_at' => '2022-02-14 16:41:13',
            ),
            3 => 
            array (
                'id' => 5,
                'name' => 'Sara',
                'category_id' => 2,
                'created_by' => 2,
                'system_ip' => NULL,
                'status' => 1,
                'created_at' => '2022-02-14 16:41:20',
                'updated_at' => '2022-02-14 16:41:20',
            ),
            4 => 
            array (
                'id' => 6,
                'name' => 'Pathao',
                'category_id' => 6,
                'created_by' => 2,
                'system_ip' => NULL,
                'status' => 1,
                'created_at' => '2022-02-14 16:41:26',
                'updated_at' => '2022-02-14 16:41:26',
            ),
            5 => 
            array (
                'id' => 7,
                'name' => 'Foodpanda',
                'category_id' => 3,
                'created_by' => 2,
                'system_ip' => NULL,
                'status' => 1,
                'created_at' => '2022-02-14 16:41:33',
                'updated_at' => '2022-02-14 16:41:33',
            ),
            6 => 
            array (
                'id' => 8,
                'name' => 'Priyojon',
                'category_id' => 5,
                'created_by' => 2,
                'system_ip' => NULL,
                'status' => 1,
                'created_at' => '2022-02-14 16:41:41',
                'updated_at' => '2022-02-14 16:41:41',
            ),
        ));
        
        
    }
}