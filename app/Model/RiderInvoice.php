<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RiderInvoice extends Model
{
    public function riderLog()
    {
        return $this->hasMany('App\RiderLog','invoice_id','id');
    }
    public function rider()
    {
        return $this->belongsTo('App\Provider','provider_id','id');
    }
}
