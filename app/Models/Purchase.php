<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'date',
        'total',
        'discount',
        'observations'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details(){
        return $this->hasMany(PurchasesDetail::class);
    }
}
