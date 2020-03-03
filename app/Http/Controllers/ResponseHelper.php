<?php
/**
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */

namespace App\Http\Controllers;

/**
 * Responsları Biraz kolaylaştırma amaçlı eklendi
 * Class ResponseHelper
 * @package App\Http\Controllers
 */
class ResponseHelper
{
  //Mesaj adları
  const UN_AUTHORIZED = 401;
  const CODE = "code";
  const MESSAGE = "message";
  const EXCEPTION = "exception";

  const EXCEPTION_MESSAGE = "Sunucu bazlı bir hata meydana geldi!";
}

class ResponseCodes {
    const CODE_SUCCESS = 1000;
    const CODE_UN_AUTHORIZED = 1001;
    const CODE_NOT_FOUND = 1002;
    const CODE_INFO = 1003;
    const CODE_WARNING = 1004;
    const CODE_ERROR = 1005;
}
