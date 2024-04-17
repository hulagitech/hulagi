<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    protected $fillable = [
        'name','email','phone',
    ];
}
