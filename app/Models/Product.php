<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory, SoftDeletes, Sluggable;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'products_category_id',
        'products_brand_id',
        'name',
        'slug',
        'location',
        'description',
        'long_description',
        'price',
        'wholesale_price',
        'stock',
        'images',
        'barcodes',
        'views',
        'status'
    ];

    public function sluggable(){
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(ProductsCategory::class, 'products_category_id')->withTrashed();
    }

    public function brand()
    {
        return $this->belongsTo(ProductsBrand::class, 'products_brand_id')->withTrashed();
    }

    public function sales_details(){
        return $this->hasMany(SalesDetail::class);
    }

    public function purchases_details(){
        return $this->hasMany(PurchasesDetail::class);
    }

    public function rating(){
        return $this->hasMany(ProductsRating::class);
    }
}
