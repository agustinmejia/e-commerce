<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'customer_id',
        'date',
        'total',
        'discount',
        'observations',
        'proforma',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function details(){
        return $this->hasMany(SalesDetail::class)->withTrashed();
    }

    public function payments(){
        return $this->hasMany(SalesPayment::class)->withTrashed();
    }
    public function payment_schedules(){
        return $this->hasMany(PaymentSchedule::class);
    }
}
