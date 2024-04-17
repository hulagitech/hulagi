<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Esewa extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'User_ID',
        'User_Name',
        'Amount',
        'Payment_ID',
        'Reference_ID',
        'Load_Amount'
    ];
    // protected $hidden = [
    //      'created_at', 'updated_at'
    // ];
}
