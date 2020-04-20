<?php
/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseCodes;
use App\Http\Controllers\ResponseHelper;
use App\Models\Setting;
use App\Rules\Recaptcha;
use Exception;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations\OpenApi;

/**
 * Kullanıcı işlemleri için oluşturulan kontrolcü sınıfı
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends ApiController
{

    use ThrottlesLogins;

    /**
     * Oturum açmak gereken fonksiyon
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, Recaptcha $recaptcha)
    {
        $captcha_enabled = Setting::first()->captcha_enabled;
        $validationResult = null;
        if($captcha_enabled) {
            $validationResult = $this->apiValidator($request, [
                'email' => 'required|string|email|max:255',
                'password' => [
                    'required',
                    'between:8,16',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&\.]).{8,16}$/'
                ],
                'recaptcha' => ['required', $recaptcha]
            ]);
        }else {
            $validationResult = $this->apiValidator($request, [
                'email' => 'required|string|email|max:255',
                'password' => [
                    'required',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&\.]).{8,16}$/'
                ],
                //'recaptcha' => ['required', $recaptcha]
            ]);
        }
        if ($validationResult) {
            return response()->json($validationResult, 422);
        }
        // Kullanıcı ve şifre bilgilerini istekten çekelim
        $credentials = $request->only('email', 'password');

        try {

            // Kullanıcı biliglerinin veri tabanından doğrulaması yapılıyor
            if (!$token = auth()->attempt($credentials)) {
                //TODO json düzenlemesi yapılcak
                return response()->json([
                    ResponseHelper::CODE => ResponseCodes::CODE_UN_AUTHORIZED,
                    ResponseHelper::MESSAGE => 'Hatalı kullanıcı adı/şifre kullanmış olabilirsiniz veya hesabınız sistem yöneticileri tarafından etkisizleştirilmiş olabilir!']);
            }
        } catch (Exception $e) {
            // Bişeyler ters giderse ;-)
            return response()->json([ResponseHelper::MESSAGE => 'Jeton oluşturulamadı!', 'error' => $e->getMessage()], 500);
        }

        // Herşey normal ise jetonu geri döndürelim
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
