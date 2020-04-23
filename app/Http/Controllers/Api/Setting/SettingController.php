<?php
/**
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */

namespace App\Http\Controllers\Api\Setting;


use App\Http\Controllers\ApiController;
use App\Http\Controllers\ResponseCodes;
use App\Http\Controllers\ResponseHelper;
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
                    ResponseHelper::CODE => ResponseCodes::CODE_SUCCESS,
                    ResponseHelper::MESSAGE => "Veritabanı son sürüme güncellendi"
                ]);
            }
            return response()->json([
                ResponseHelper::CODE => ResponseCodes::CODE_WARNING,
                ResponseHelper::MESSAGE => "Veritabanı güncel"
            ]);
        }
        catch(Exception $exception) {
            return response()->json([
                ResponseHelper::CODE => ResponseCodes::CODE_ERROR,
                ResponseHelper::MESSAGE => ResponseHelper::EXCEPTION_MESSAGE,
                ResponseHelper::EXCEPTION => $exception->getMessage()
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
            'captcha_enabled'
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
                'captcha_enabled' => $request->get('captcha_enabled')
            ]);
            DB::commit();
            return response()->json([
                ResponseHelper::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseHelper::MESSAGE => "Ayarlarnız başarıyla güncellendi"
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                ResponseHelper::CODE => ResponseCodes::CODE_ERROR,
                ResponseHelper::MESSAGE => ResponseHelper::EXCEPTION_MESSAGE,
                ResponseHelper::EXCEPTION => $exception->getMessage()
            ]);
        }
    }
}