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
     * @OA\Post(
     * path="/api/auth/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *       @OA\Property(property="persistent", type="boolean", example="true"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
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
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_ERROR,
                ResponseKeys::MESSAGE => 'Jeton oluşturulamadı!', 'error' => $e->getMessage()
            ], 500);
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
