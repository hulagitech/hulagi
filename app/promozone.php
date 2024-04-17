<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class promozone extends Model
{
    protected $table = 'promozones';
    protected $fillable = [
        'Zone_id','Restricted_Zone_id','promocode_id'
    ];

    public function Zones(){
        return $this->belongsTo('App\Zones','Zone_id');
    }

    public function RestrictedZones(){
        return $this->belongsTo('App\Zones','Restricted_Zone_id');
    }

}
