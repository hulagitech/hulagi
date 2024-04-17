<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocode extends Model
{
    use SoftDeletes;
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'promo_code','discount','Discount_type','expiration','set_limit','number_of_time','user_type','zone','restricted_zone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    public function Zones(){
        return $this->belongsTo('App\Zones','zone');
    }

    public function RestrictedZones(){
        return $this->belongsTo('App\Zones','restricted_zone');
    }

    public function promozone(){
        return $this->hasMany('App\promozone','promocode_id','id');
    }
    public function promocodeUsage(){
        return $this->hasMany('App\PromocodeUsage','promocode_id','id');
    }
}
