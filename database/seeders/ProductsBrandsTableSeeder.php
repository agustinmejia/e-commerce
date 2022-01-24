<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsBrandsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('products_brands')->delete();
        
        \DB::table('products_brands')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Genérica',
                'slug' => 'generica',
                'images' => NULL,
                'created_at' => '2022-01-19 21:38:59',
                'updated_at' => '2022-01-19 21:39:23',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}