<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubZone extends Model
{
    
    protected $fillable = [
        'main','sub'
    ];

    protected $dates=[
        'created_at','updated__at'
    ];

    public function mainZone(){
        return $this->belongsTo('App\Zones','main');
    }
    
    public function subZone(){
        return $this->belongsTo('App\Zones','sub');
    }
}
