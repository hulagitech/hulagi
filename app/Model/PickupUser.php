<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PickupUser extends Authenticatable
{
    use Notifiable;

    protected $guard = 'pickup';

    
    protected $fillable = [
        'name', 'email', 'password', 'mobile','enable'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
