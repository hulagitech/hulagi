<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    protected $fillable = [
        'id',
        'ticket_id',
        'comment',
        'authorised_type',
        'is_read_user',
        'is_read_cs',
        'is_read_admin',
        'is_read_account',
        'is_read_dispatch',
        'is_read_finance',
        'is_read_intracity',
        'is_read_ls',
        'is_read_pickup',
        'is_read_return',
        'is_read_bm',
        'enable',
        'dept_id'
    ];

    // protected $hidden = ['created_at', 'updated_at'];

    // Depatment relationship with Ticket
    public function dept()
    {
        return $this->belongsTo('App\Department','dept_id');
    }
}
