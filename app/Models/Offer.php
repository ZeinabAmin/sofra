<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model 
{

    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'restaurant_id', 'image', 'discount_percentage', 'time_from', 'time_to');

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

}