<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;

// Models
use App\Models\Product;
use App\Models\ProductsCategory;
use App\Models\ProductsBrand;

class ProductsImport implements ToModel
{
    function __construct($type) {
        $this->type = $type;
    }

    public function model(array $row)
    {
        $category = null;
        if($row[2]){
            $category = ProductsCategory::firstOrCreate([
                'name' => $row[2],
            ]);
        }

        $brand = null;
        if($row[3]){
            $brand = ProductsBrand::firstOrCreate([
                'name' => $row[3],
            ]);
        }

        return new Product([
            'id' => explode('-', $row[0])[0],
            // 'id' => $row[0],
            'products_category_id' => $category ? $category->id : 1,
            'products_brand_id' => $brand ? $brand->id : 1 ,
            'name' => $row[1],
            'location' => $row[6],
            'price' => $row[4],
            'stock' => $row[5],
            'status' => 'disponible'
        ]);
    }
}
