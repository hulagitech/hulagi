<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class Page extends Model

{

     protected $fillable = [

        'id',

        'en_title',

        'slug',

        'en_meta_keys',

        'en_meta_description',

        'en_description',

        'image',
        'en_question',
        

    ];

}

