<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
  protected $table = 'items';
  
   protected $fillable = [
        'name',
        'qty',
        'request_id',
		'image',
		'discription',
		'special_note',
        'user_id',
        'size',
        'rec_name',
        'rec_mobile',
        'rec_email',
        'rec_address','instructions',
    ];
  
  protected $hidden = [
        'created_at', 'updated_at'
    ];
	
	 public function provider()
    {
        return $this->belongsTo('App\Provider');
    }
	
	/*public function user()
    {
        return $this->belongsTo('App\UserRequests');
    }*/
    public function itemImage(){
       //return $this->belongsTo('App\ItemHasImage','item_id');
        return $this->belongsToMany('App\Image', 'item_has_images', 'item_id', 'image_id');
    }
    public function getDocumentTypeAttribute($value){
        return ServiceType::findOrFail($value)->first()->value('name');
    }
}
