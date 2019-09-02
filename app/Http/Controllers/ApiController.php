<?php
/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
  public function apiValidator(Request $request, $props) {
      $attributes = [
          'learning_outcome_id' => 'Kazanım',
          'difficulty' => 'Zorluk',
          'question_file' => 'Soru dosyası',
      ];

    $validator = Validator::make($request->all(), $props, [], $attributes);
    if ($validator->fails()) {
      return $validator->errors();
    }
    return null;
  }

  public function apiException($exception) {
    return [
      ResponseHelper::MESSAGE => ResponseHelper::EXCEPTION_MESSAGE,
      "exception" => $exception->getMessage()
    ];
  }
}
