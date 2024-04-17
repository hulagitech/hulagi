<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManagerToDispatcher extends Model
{
    protected $fillable = [
        'branch_manager_id', 'dispatcher_id'
    ];

    public function branchmanager(){
        return $this->belongsTo('App\BranchManager','branch_manager_id');
    }

    public function dispatcher(){
        return $this->belongsTo('App\Dispatcher','dispatcher_id');
    }

}

