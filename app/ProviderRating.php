<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ProviderRating extends Model
{

     protected $fillable = [
        'provider_id','user_request_id','rating','comment'
    ];
    public function provider()
    {
        return $this->hasOne("App\Provider", 'id' ,'provider_id');
    }
    public function request()
    {
        return $this->hasOne("App\UserRequests", 'id' ,'user_request_id');
    }
}
