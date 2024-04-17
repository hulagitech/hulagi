<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class billUpdate extends Model
{
    protected $fillable=[
        'provider_id',
        'url',
        'Remarks',
        'amount',
    ];
    
    public function provider(){
        return $this->belongsTo('App\Provider');
    }
}
