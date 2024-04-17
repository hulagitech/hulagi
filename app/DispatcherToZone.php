<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DispatcherToZone extends Model
{
    protected $fillable = [
        'dispatcher_id', 'zone_id'
    ];

    public function dispatcher(){
        return $this->belongsTo('App\Dispatcher','dispatcher_id');
    }

    public function zone(){
        return $this->belongsTo('App\Zones','zone_id');
    }
}
