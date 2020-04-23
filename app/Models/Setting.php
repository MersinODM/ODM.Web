<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'city',
        'governor',
        'directorate',
        'twitter_address',
        'web_address',
        'inst_name',
        'phone',
        'captcha_public_key',
        'captcha_private_key',
        'email',
        'address',
        'captcha_enabled'
    ];
}
