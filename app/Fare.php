<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fare extends Model
{
    //
    protected $fillable = [
        'zone1_id',
		'zone2_id',
		'km',
		'fare',
        'fare_half_kg',
        'cargo',
        'delay_period',
        'extremely_delay_period',
        'Percentage_increase'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function zone1(){
        return $this->hasOne('App\Zones','id','zone1_id');
    }
    public function zone2(){
        return $this->hasOne('App\Zones','id','zone2_id');
    }
}
