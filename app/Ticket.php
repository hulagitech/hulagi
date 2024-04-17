<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'description',
        'status',
        'createdby_cs',
        'priority',
        'dept_id',
        'department',
        'authorised_id'
    ];

    // protected $hidden = [
    //     'created_at', 'updated_at'
    // ];

    // User(Client) relationship with Ticket
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    // Depatment relationship with Ticket
    public function dept()
    {
        return $this->belongsTo('App\Department','dept_id');
    }

    public function ticketComment(){
        return $this->hasMany('App\TicketComment','ticket_id');
    }

    public function recentTicketComment(){
        return $this->hasMany('App\TicketComment','ticket_id')->orderby('created_at','desc')->select('comment');
    }

   


}