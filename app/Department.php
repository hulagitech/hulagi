<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'dept',
        'enable'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
