<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiderLog extends Model
{
    protected $fillable = [
        'request_id',
        'pickup_id',
        'pickup_remarks',
        'complete_id',
        'complete_remarks',
        'payment_received',
        'completed_date'
    ];

    protected $dates = [
        'created_at','updated_at','deleted_at'
    ];

    public function request(){
        return $this->belongsTo('App\UserRequests','request_id');
    }

    public function pickup(){
        return $this->belongsTo('App\Provider','pickup_id');
    }

    public function complete(){
        return $this->belongsTo('App\Provider','complete_id');
    }
}
