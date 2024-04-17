<?php

namespace App\Model;

use App\Notifications\ReturnResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SortCenterUser extends Authenticatable
{
    use Notifiable;

    protected $guard = 'sortcenter';

    // Table
	Protected $table = 'sort_center_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'enable'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}
