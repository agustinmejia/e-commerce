<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'products_category_id',
        'products_brand_id',
        'name',
        'slug',
        'description',
        'price',
        'wholesale_price',
        'stock',
        'images',
        'status'
    ];
}
