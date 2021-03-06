<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'full_name',
        'dni',
        'phone',
        'address',
        'type',
        'status'
    ];

    public function sales(){
        return $this->hasMany(Sale::class);
    }
}
