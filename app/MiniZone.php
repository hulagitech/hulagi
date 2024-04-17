<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MiniZone extends Model
{
    protected $fillable = [
        'zone_name',
		'coordinate',
		'background',
		'draw_lines',
		
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];


    public function scopeOrigin($query, $array)
    {
        // return $query;
        return $query
        ->whereIn('city', $array)
        ->whereIn('country', $array)
        ->where('status', 'active');
    }
    public function scopeDestination($query, $array)
    {
        return $query->whereIn('city', $array)
        ->whereIn('country', $array)
        ->where('status', '!=' ,'blocked');
    }
}
