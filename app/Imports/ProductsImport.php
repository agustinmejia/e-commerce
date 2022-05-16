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
        if($row[1]){
            $category = ProductsCategory::firstOrCreate([
                'name' => $row[1],
            ]);
        }

        $brand = null;
        if($row[2]){
            $brand = ProductsBrand::firstOrCreate([
                'name' => $row[2],
            ]);
        }

        return new Product([
            'products_category_id' => $category ? $category->id : 1,
            'products_brand_id' => $brand ? $brand->id : 1 ,
            'name' => $row[0],
            'price' => $row[3],
            'stock' => $row[4],
            'location' => $row[5] ?? null,
            'barcodes' => $row[6] ? json_encode(str_replace(' ', '', explode('-', $row[6]))) : null,
            'status' => 'disponible'
        ]);
    }
}
