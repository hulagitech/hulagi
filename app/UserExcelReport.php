<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserExcelReport extends Model
{
    protected $table = 'user_xls_report';

    protected $fillable = ['id', 'user_id', 'xls_file', 'enable'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
}
