<?php
/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\Setting;
use App\Rules\Recaptcha;
use Exception;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;

/**
 * Kullanıcı işlemleri için oluşturulan kontrolcü sınıfı
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends ApiController
{
    use ThrottlesLogins;

    /**
     * The maximum number of attempts to allow.
     *
     * @return int
     */
    protected $maxAttempts = 3;


    /**
     * The number of minutes to throttle for.
     *
     * @return int
     */
    protected $decayMinutes = 2;


    /**
     * Oturum açmak gereken fonksiyon
     * @param Request $request
     * @param Recaptcha $recaptcha
     * @param $decayMinutes
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
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
                    'min:8',
                    'max:16',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&\.]).{8,16}$/'
                ],
                'recaptcha' => 'required'
//                'recaptcha' => ['required', $recaptcha]
            ]);
        }else {
            $validationResult = $this->apiValidator($request, [
                'email' => 'required|string|email|max:255',
                'password' => [
                    'required',
                    'min:8',
                    'max:16',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&\.]).{8,16}$/'
                ],
                //'recaptcha' => ['required', $recaptcha]
            ]);
        }
        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_WARNING,
                ResponseKeys::MESSAGE => 'Çok fazla hatalı giriş yaptınız '.$this->decayMinutes.' dakika bekleyiniz!']);
        }

        // Kullanıcı ve şifre bilgilerini istekten çekelim
        $credentials = $request->only('email', 'password');

        try {

            // Kullanıcı biliglerinin veri tabanından doğrulaması yapılıyor
            if (!$token = auth()->attempt($credentials)) {
                $this->incrementLoginAttempts($request);
                return response()->json([
                    ResponseKeys::CODE => ResponseCodes::CODE_UNAUTHORIZED,
                    ResponseKeys::MESSAGE => 'Hatalı kullanıcı adı/şifre kullanmış olabilirsiniz veya hesabınız sistem yöneticileri tarafından etkisizleştirilmiş olabilir!']);
            }
        } catch (Exception $e) {
            // Bişeyler ters giderse ;-)
            return response()->json([ResponseKeys::MESSAGE => 'Jeton oluşturulamadı!', 'error' => $e->getMessage()], 500);
        }

        // Herşey normal ise jetonu geri döndürelim
        return $this->respondWithToken($token);
    }

    /*
     * Bu fonksiyon throttling için gerekli
     */
    private function username()
    {
        return 'email';
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
