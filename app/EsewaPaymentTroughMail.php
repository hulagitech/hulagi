<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EsewaPaymentTroughMail extends Model
{
    use Notifiable;
    protected $primaryKey = 'id';
    protected $fillable = [
        'email',
        'user_id',
        'Name',
        'Amount',
        'EsewaToken',
    ];
}
