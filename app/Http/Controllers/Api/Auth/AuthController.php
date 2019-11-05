<?php
/**
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup
 *  geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *   Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

/**
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup
 *  geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *   Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Rules\Recaptcha;
use Exception;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Kullanıcı işlemleri için oluşturulan kontrolcü sınıfı
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends Controller
{

  use ThrottlesLogins;
  /**
   * Oturum açmak gereken fonksiyon
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(Request $request, Recaptcha $recaptcha)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email|max:255',
      'password'=> 'required',
      //'recaptcha' => ['required', $recaptcha]
    ]);
    if ($validator->fails()) {
      return response()->json($validator->errors(),422);
    }
    // Kullanıcı ve şifre bilgilerini istekten çekelim
    $credentials = $request->only('email', 'password');

    try {
      // Kullanıcı biliglerinin veri tabanından doğrulaması yapılıyor
      if (!$token = auth()->attempt($credentials)) {
        return response()->json(['error' => 'Hatalı kullanıcı adı ya da şifre!'], 401);
      }
    } catch (Exception $e) {
      // Bişeyler ters giderse ;-)
      return response()->json(['message' => 'Jeton oluşturulamadı!', 'error' => $e->getMessage()], 500);
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
