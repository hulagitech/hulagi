<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KhaltiDetail extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'khalti_id',
        'khalti_username',
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
