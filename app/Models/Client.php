<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'phone', 'email', 'password', 'region_id', 'is_active');

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function rates()
    {
        return $this->hasMany('App\Models\Rate');
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
