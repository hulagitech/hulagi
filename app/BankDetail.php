<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'bank_name',
        'branch',
        'ac_no',
        'ac_name',
        'status',
        'createdby_ac'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    // User(Client) relationship with Bank Detail
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
