<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemHasImage extends Model
{
  protected $table = 'item_has_images';
  
   protected $fillable = [
        'item_id',
        'image_id',
    ];
  
  protected $hidden = [
        'created_at', 'updated_at'
    ];
	
	 public function image()
    {
        return $this->belongsTo('App\ItemHasImage');
    }
	
	public function  item()
    {
        return $this->belongsTo('App\Items');
    }
}
