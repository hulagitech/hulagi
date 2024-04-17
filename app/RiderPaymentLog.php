<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiderPaymentLog extends Model
{
    protected $fillable = [
        'provider_id',
        'transaction_type', //earning or payable
        'amount',
        'remarks'
    ];

    protected $dates = [
        'created_at','updated_at','deleted_at'
    ];

    public function provider(){
        return $this->belongsTo('App\Provider','provider_id');
    }
}
