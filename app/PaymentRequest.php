<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    protected $fillable = [
        'user_id',
        'is_paid',
        
    ];
    // protected $hidden = [
    //     'created_at', 'updated_at', 'deleted_at'
    // ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function requestItems()
    {
        return $this->hasMany('App\RequestPaymentItems');
    }
}
