<?php
/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers\Api\Auth;


use App\Events\ResetPasswordEvent;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Rules\Recaptcha;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends ApiController
{
    //Şu an kullanılmıyor ayrı bir web sayfası ile çözüldü reset işlemi
    public function resetPassword(Request $request)
    {

        $validationResult = $this->apiValidator($request, [
            'token' => 'required',
            'email' => 'required|email|max:255',
            "password" => "required|confirmed|min:6",
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');

        $broker = app('auth.password.broker');

        $user = $broker->getUser($credentials);
        if ($user == null) {
            return response()->json([ResponseKeys::MESSAGE => "Kullanıcı e-posta adresi bulunamadı!"], 404);
        }

        $isExist = $broker->tokenExists($user, $credentials["token"]);

        if ($isExist) {
            $result = $broker->reset($credentials, function ($user, $pass) {
                $user->password = Hash::make($pass);
                $user->activation_date = Carbon::now();
                $user->save();
            });
            if ($result == PasswordBroker::PASSWORD_RESET) {
                return response()->json([ResponseKeys::MESSAGE => "Şifreniz başarıyla değiştirildi!"], 200);
            }
            return response()->json([ResponseKeys::MESSAGE => "Şifreniz değiştirilemedi!"]);
        }
        return response()->json([ResponseKeys::MESSAGE => "Şifre değiştirme bağlantısının süresi geçmiş olabilir.\nŞifremi unuttum diyerek tekrar bağlantı alabilirsiniz!"], 404);
    }

    public function forgetPassword(Request $request, Recaptcha $recaptcha)
    {
        $validationResult = $this->apiValidator($request, [
            'email' => 'required|email|max:255',
            //'recaptcha' => ['required', $recaptcha]
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $email = $request->input("email");
        $user = User::where("email", $email)->first();
        if (isset($user)) {
            if (isset($user->activator_id)) {
                event(new ResetPasswordEvent($user));
                return response()->json([ResponseKeys::MESSAGE => "Şifre oluşturabilecek bir e-posta, belirttiğiniz adrese gönderildi.\nİyi çalışmalar..."]);
            }
            return response()->json([ResponseKeys::MESSAGE => "Kaydınız henüz onaylanmadığı için şifremi unuttum kısmını kullanamazsınız!"]);
        }
        return response()->json([ResponseKeys::MESSAGE => "E-Posta adresiniz sistemde bulunamadı! Lütfen doğru e posta adresini gönderdiğinizden emin olunuz doğru gönderdiğinizi düşünüyorsanız sistem yönetininize başvurunuz. İyi çalışmalar.."]);
    }
}
