<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NextUserDashboard extends Model
{
    use HasFactory;
    protected $fillable = [
        'APP_NAME', 'Email', 'phone','location','App_logo','App_icon','support','finance','marketing','White_App_logo','Company_Full_Name','wesite_facebook','website_linkedin','website_instagram','websitelink','subdomain_link'
    ];
}
