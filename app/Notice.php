<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'Heading', 'Description','domain_name'
    ];
    // protected $hidden = [
    //     'created_at', 'updated_at'
    // ];

}
