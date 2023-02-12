<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{

    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'password', 'phone', 'delivery_fee', 'minimum_order', 'whatsapp', 'informations', 'region_id', 'image', 'is_active','status');

    public function meals()
    {
        return $this->hasMany('App\Models\Meal');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function rates()
    {
        return $this->hasMany('App\Models\Rate');
    }

    public function payment()
    {
        return $this->hasOne('App\Models\Payment');
    }

    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'tokenable');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notificationable');
    }
    protected $hidden = [
        'password',
        'api_token',
    ];
}
