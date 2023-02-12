<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{

    protected $table = 'meals';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'image', 'processing_time', 'price', 'restaurant_id');

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }
    public function orders()
	{
		return $this->belongsToMany('App\Models\Order');
	}
}
