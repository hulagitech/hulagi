<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPaymentDetail extends Model
{
    protected $table = 'user_payment_details';

    protected $fillable = [
        'id', 'user_id', 'khalti_id', 'khalti_username', 'bank_name', 'branch', 'bank_acno', 'ac_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
