<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model 
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('who_are_we', 'about_app', 'commission', 'commission_text', 'fb_link', 'insta_link');

}