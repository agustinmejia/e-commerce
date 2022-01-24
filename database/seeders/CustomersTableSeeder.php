<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('customers')->delete();
        
        \DB::table('customers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => NULL,
                'full_name' => 'Sin nombre',
                'dni' => '00000',
                'phone' => NULL,
                'address' => NULL,
                'type' => 'normal',
                'status' => 'activo',
                'created_at' => '2022-01-22 17:28:19',
                'updated_at' => '2022-01-22 17:28:19',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}