<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoneDispatchList extends Model
{
    protected $fillable = [
        'request_id',
        'dispatch_id',
        'received'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function request(){
        return $this->belongsTo('App\UserRequests','request_id');
    }

    public function bulk(){
        return $this->belongsTo('App\DispatchBulkList','dispatch_id');
    }
}
