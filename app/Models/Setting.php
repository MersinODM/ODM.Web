<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
      "inst_name",
      "governor",
      "directorate",
      "twitter_address",
      "facebook_address",
      "instagram_address",
      "web_address",
      "inst_name",
      "phone",
      "email",
      "address",
      "logo_url"
    ];
}
