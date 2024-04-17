<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
    protected $fillable =[
        'request_id','type','description'
    ];
    protected $dates = [
        'created_at','updated_at'
    ];

    public function request(){
        return $this->belongsTo("App\UserRequests",'request_id');
    }
}
