<?php
/*
 * ODM.Web  https://github.com/electropsycho/ODM.Web
 * Copyright 2019-2020 Hakan GÜLEN
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

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
        'captcha_enabled',
        'will_the_electors_be_emailed',
        'min_elector_count',
        'max_elector_count'
    ];
}
