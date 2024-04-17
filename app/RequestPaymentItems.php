<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestPaymentItems extends Model
{
    protected $fillable = ['payment_request_id','request_id'];
    public function userRequest()
    {
        return $this->belongsTo('App\UserRequests','request_id','id');
    }
}
