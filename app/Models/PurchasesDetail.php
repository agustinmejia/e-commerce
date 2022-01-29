<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasesDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'price'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }
}
