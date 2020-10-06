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

namespace App\Http\Controllers\Api\Setting;


use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseContents;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SettingController extends ApiController
{

    public function migrateUp() {
        try {
            Artisan::call('migrate');
            $result = Artisan::output();
            // Log::info($result);
            if (strpos($result, "Migrated") !== false) {
                return response()->json([
                    ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                    ResponseKeys::MESSAGE => "Veritabanı son sürüme güncellendi."
                ]);
            }
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_WARNING,
                ResponseKeys::MESSAGE => "Veritabanı güncel durumda."
            ]);
        }
        catch(Exception $exception) {
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_ERROR,
                ResponseKeys::MESSAGE => ResponseContents::EXCEPTION_MESSAGE,
                ResponseKeys::EXCEPTION => $exception->getMessage()
            ]);
        }
    }

    /**
     * Genel bilgileri döner
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGeneralInfo() {
        return response()->json(Setting::first([
            'captcha_public_key',
            'captcha_enabled',
            'city',
            'web_address'
        ]));
    }

    /**
     * Tüm ayarları geri döner
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSettings() {
        return response()->json(Setting::first([
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
            ]));
    }

    public function update (Request $request) {

        $validationResult = $this->apiValidator($request ,[
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
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $settings = Setting::first();
            $settings->update([
                'city' => $request->get('city'),
                'governor' => $request->get('governor'),
                'directorate' => $request->get('directorate'),
                'twitter_address' => $request->get('twitter_address'),
                'web_address' => $request->get('web_address'),
                'facebook_address' => $request->get('facebook_address'),
                'instagram_address' => $request->get('instagram_address'),
                'inst_name' => $request->get('inst_name'),
                'phone' => $request->get('phone'),
                'captcha_public_key' => $request->get('captcha_public_key'),
                'captcha_private_key' => $request->get('captcha_private_key'),
                'email' => $request->get('email'),
                'address' => $request->get('address'),
                'captcha_enabled' => $request->get('captcha_enabled'),
                'will_the_electors_be_emailed' => $request->get('will_the_electors_be_emailed'),
                'min_elector_count' => $request->get('min_elector_count'),
                'max_elector_count' => $request->get('max_elector_count')
            ]);
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => "Ayarlarnız başarıyla güncellendi"
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_ERROR,
                ResponseKeys::MESSAGE => ResponseContents::EXCEPTION_MESSAGE,
                ResponseKeys::EXCEPTION => $exception->getMessage()
            ]);
        }
    }
}