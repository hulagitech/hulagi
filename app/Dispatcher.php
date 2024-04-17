<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Notifications\DispatcherResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dispatcher extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile' , 'company' ,'logo', 'zone_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
       public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new DispatcherResetPassword($token));
    }

    public function zone(){
        return $this->belongsTo("App\Zones",'zone_id');
    }

    public function zones(){
        return $this->hasMany("App\DispatcherToZone",'dispatcher_id');
    }
}
