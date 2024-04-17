<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = ['id', 'request_id', 'booking_id', 'authorised_type', 'authorised_id', 'comments', 'is_read_user', 'is_read_admin', 'is_read_rider', 'is_read_cs', 'enable'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function request(){
        return $this->belongsTo("App\UserRequests","request_id");
    }

    public function dept()
    {
        return $this->belongsTo('App\Department','dept_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\BranchManager','authorised_id');
    }

    public function rider()
    {
        return $this->belongsTo('App\Rider','authorised_id');
    }

    public function sortcenter()
    {
        return $this->belongsTo('App\Model\SortCenterUser','authorised_id');
    }

    public function support(){
        return $this->belongsTo("App\SupportUser","authorised_id");

    }

    public function admin(){
        return $this->belongsTo("App\Admin","authorised_id");

    }
    public function return(){
        return $this->belongsTo("App\ReturnUser","authorised_id");

    }
    public function pickup(){
        return $this->belongsTo("App\Model\PickupUser","authorised_id");
    }
    
    public function dispatcher(){
        return $this->belongsTo("App\Dispatcher","authorised_id");
    }

}
