<?php
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

class InstitutionController extends ApiController
{
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
