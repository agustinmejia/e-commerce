<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('products_categories')->delete();
        
        \DB::table('products_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Genérica',
                'slug' => 'generica',
                'description' => NULL,
                'images' => NULL,
                'created_at' => '2022-01-19 21:39:12',
                'updated_at' => '2022-01-19 21:39:12',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}