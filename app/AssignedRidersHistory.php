<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignedRidersHistory extends Model
{
    protected $fillable = [
        'request_id',
        'rider_id',
        'status'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function request(){
        return $this->belongsTo('App\UserRequests','request_id');
    }
    public function rider(){
        return $this->belongsTo('App\Provider','rider_id');
    }
}
