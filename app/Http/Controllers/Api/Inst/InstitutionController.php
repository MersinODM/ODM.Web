<?php
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

namespace App\Http\Controllers\Api\Inst;


use App\Http\Controllers\ApiController;

use App\Http\Controllers\ResponseHelper;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstitutionController extends ApiController
{
    public function create(Request $request) {
        $validationResult = $this->apiValidator($request, [
            'id' => 'required|unique:institutions,id|digits_between:6,8',
            'unit_id' => 'required|exists:units,id',
            'name' => 'required',
            'phone' => 'required|size:10'
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $institutionReq = $request->only('id', 'unit_id', 'name', 'phone');
        $institution = new Institution($institutionReq);
        try {
            DB::beginTransaction();
            $institution->save();
            DB::commit();
            return response()->json([ResponseHelper::MESSAGE => "Okul/Kurum kayıt işlemi başarılı"]);
        }
        catch (\Exception $exception) {
            DB::rollBack();
            return response()->json($this->apiException($exception), 500);
        }
    }

  public function findByNameInstitutions(Request $request)
  {
    if (!$request->exists("searchTerm")) {
      return response()->json([
        ResponseHelper::MESSAGE => "Gönderilen veri sunucuyla uyumsuz!"
      ], 406);
    }
    $searchTerm = $request->query('searchTerm');
    $insts = Institution::where('name', 'like', '%' . $searchTerm . '%')->get();
    return response()->json($insts);
  }
}
