<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DispatchBulkList extends Model
{
    protected $fillable = [
        'remarks',
        'file_path',
        'received',
        'zone1_id',//id of dispatcher of source
        'zone2_id',//id of dispatcher of destination
        'draft',
        'received_all',
        'incomplete_received',
        'Returned'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function zone1(){
        return $this->belongsTo("App\Dispatcher",'zone1_id');
    }
    public function zone2(){
        return $this->belongsTo("App\Dispatcher",'zone2_id');
    }
    public function lists(){
        return $this->hasMany('App\ZoneDispatchList','dispatch_id');
    }
}
