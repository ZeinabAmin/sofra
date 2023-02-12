<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('total', 'delivery_address', 'delivery_price', 'total_after_delivery', 'commission', 'payment_method_id', 'state', 'notes', 'client_id', 'restaurant_id');

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\PaymentMethod');
    }
    public function meals()
    {
        return $this->belongsToMany('App\Models\Meal')->withPivot('price', 'quantity', 'special_order');
    }
}
