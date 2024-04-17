<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInvoice extends Model
{
    public function userRequest()
    {
        return $this->hasMany('App\UserRequests','invoice','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
