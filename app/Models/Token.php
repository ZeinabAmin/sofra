<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model 
{

    protected $table = 'tokens';
    public $timestamps = true;
    protected $fillable = array('tokenable_id', 'tokenable_type', 'token', 'platform');

    public function tokenable()
    {
        return $this->morphTo();
    }

}