<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class settlementLog extends Model
{
    protected $fillable = [
        'provider_id',
        'amount',
        'type',
        'remarks'
    ];

}
