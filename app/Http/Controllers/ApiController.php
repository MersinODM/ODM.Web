<?php
/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers;


use App\Traits\ValidationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    use ValidationTrait;
    /**
     * @param Request $request
     * @param $props
     * @return \Illuminate\Support\MessageBag|null
     */
    public function apiValidator(Request $request, $props): ?\Illuminate\Support\MessageBag
    {

        $validator = Validator::make($request->all(), $props, $this->MESSAGES, $this->ATTRIBUTES);
        if ($validator->fails()) {
            return $validator->errors();
        }
        return null;
    }

    public function apiException($exception)
    {
        return [
            ResponseHelper::CODE => ResponseCodes::CODE_ERROR,
            ResponseHelper::MESSAGE => ResponseHelper::EXCEPTION_MESSAGE,
            ResponseHelper::EXCEPTION => $exception->getMessage()
        ];
    }
}
