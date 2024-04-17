<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class khalti extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'User_ID',
        'User_Name',
        'Paid_Amount',
        'Payment_ID',
        'Reference_ID',
        'Load_Amount'.
        'idx',
        'Mobile',

    ];
}
