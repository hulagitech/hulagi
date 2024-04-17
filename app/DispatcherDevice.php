<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DispatcherDevice extends Model
{
    protected $fillable = [
        'dispatcher_id',
        'udid',
        'token',
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
