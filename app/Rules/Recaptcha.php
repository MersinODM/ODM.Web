<?php
/*
 * ODM.Web  https://github.com/electropsycho/ODM.Web
 * Copyright (C) 2020 Hakan GÜLEN
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/
 */

/**
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup
 *  geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *   Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Rules;

use App\Models\Setting;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\LaravelCacheStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;

class Recaptcha implements Rule
{
    const URL = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws GuzzleException
     */
    public function passes($attribute, $value)
    {
        $secret = Setting::first()->captcha_private_key;

        $client = $this->getGuzzleFileCachedClient();
        $r = $client->request('POST', static::URL, [
            'form_params' => [
                'secret' =>  $secret,
                'response' => $value,
                'remoteip' => request()->ip()
            ]
        ]);
        $json_response = json_decode($r->getBody()->getContents(), true);
        return $json_response['success'];
//        return Zttp::asFormParams()->post(static::URL, [
//            'secret' => env('GOOGLE_RECAPTCHA_SECRET'),
//            'response' => $value,
//            'remoteip' => request()->ip()
//        ])->json()['success'];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Robot olmadığınızı ispat edemediniz!';
    }

    /**
     * Returns a GuzzleClient that uses a file based cache manager
     * @return Client
     */
    private function getGuzzleFileCachedClient()
    {
        // Create a HandlerStack
        $stack = HandlerStack::create();

        $stack->push(
            new CacheMiddleware(
                new PrivateCacheStrategy(
                    new LaravelCacheStorage(
                        Cache::store('file')
                    )
                )
            ),
            'cache'
        );

        // Initialize the client with the handler option and return it
        return new Client(['handler' => $stack]);
    }
}
