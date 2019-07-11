<?php
/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers\Api\Auth;


use App\Events\NewUserReqReceived;
use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\Request;

class PasswordController extends ApiController
{

  public function sendPasswordMail() {

  }

  public function sendResetPasswordEmail(Request $request) {
    $validationResult = $this->apiValidator($request, ['email' => 'required|email|max:50']);
    if ($validationResult) {
      return response()->json($validationResult,422);
    }

    $user = User::where("email", $request->input("email"));
    $token = app("auth.password.broker")->createToken($user);
    event(new NewUserReqReceived($user, $token));
  }

  public function resetPassword() {

  }
}
