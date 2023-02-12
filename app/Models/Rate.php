<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model 
{

    protected $table = 'rates';
    public $timestamps = true;
    protected $fillable = array('restaurant_id', 'client_id', 'comments', 'reviews');

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

}