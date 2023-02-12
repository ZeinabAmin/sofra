<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model 
{

    protected $table = 'payments';
    public $timestamps = true;
    protected $fillable = array('paid', 'payment_date', 'restaurant_id', 'notes');

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

}