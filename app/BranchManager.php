<?php

namespace App;

use App\Notifications\BranchManagerResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BranchManager extends Authenticatable
{
    use Notifiable;

    //protected $guard = 'bm';

    // Table
	Protected $table = 'branch_managers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'zone_id', 'enable'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function dispatcher(){
        return $this->hasMany("App\ManagerToDispatcher",'branch_manager_id','id');
    }
}
