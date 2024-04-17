<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
  protected $table = 'images';
  
   protected $fillable = [
        'image_path',
    ];
  
  protected $hidden = [
        'created_at', 'updated_at'
    ];

   public function getImagePathAttribute($value){
   	return 'storage/app/public/user/item/'.$value;
   }
	
}
