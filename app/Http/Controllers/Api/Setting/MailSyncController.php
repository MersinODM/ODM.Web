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
use Illuminate\Support\Facades\Artisan;

class MailSyncController extends ApiController
{
    public function executeMailQueue() {
        try {
            Artisan::call('queue:work', ['--stop-when-empty' => true]);
            //Aşağıdaki kod parçasına ulaşamdan çalışma kesiliyor
            $output = Artisan::output();
            return response()->json([
                ResponseHelper::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseHelper::MESSAGE => "Mail seknronizasyonu tamamlandı."
            ]);
        }
        catch (\Exception $exception) {
            return response()->json($this->apiException($exception));
        }
    }
}