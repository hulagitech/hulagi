<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $fillable = [
        'user_id',
        'request_id',
        'changed_amount',
        'remarks'
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
