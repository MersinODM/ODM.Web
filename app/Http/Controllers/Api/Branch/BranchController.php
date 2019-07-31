<?php
/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers\Api\Branch;


use App\Http\Controllers\ApiController;
use App\Http\Controllers\ResponseHelper;
use App\Models\Branch;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends ApiController
{

  public function create(Request $request) {

    $validationResult = $this->apiValidator($request, ['name' => 'required|max:50']);
    if ($validationResult) {
      return response()->json($validationResult,422);
    }

    try {
      $name = $request->input("name");
      $code = $request->input("code");
      $branch = new Branch();
      $checkBranch =  Branch::where("name", $name)->first();
      if ($checkBranch == null) {
        $branch->fill(["name" => $name, "code" => $code]);
        $branch->save();
      }
    }
    catch (Exception $exception) {
      return response()->json($this->apiException($exception), 500);
    }
    return response()->json([ResponseHelper::MESSAGE => "Branş/Ders kayıt işlemi başarılı."], 201);
  }

  public function update(Request $request, $id) {
    $validationResult = $this->apiValidator($request, ['name' => 'required|max:50']);
    if ($validationResult) {
      return response()->json($validationResult,422);
    }

    try {
      $name = $request->input("name");
      $code = $request->input("code");
      $branch = Branch::findOrFail($id);
      $branch->name= $name;
      $branch->code= $code;
      $branch->save();
    }
    catch (Exception $exception) {
      return response()->json($this->apiException($exception), 500);
    }
    return response()->json([ResponseHelper::MESSAGE => "Branş/Ders güncelleme işlemi başarılı."], 201);
  }

  public function delete(Request $request, $id) {

  }

  public function getBranchesWithStats() {
    $branches = DB::table("branches as b")
      ->select("b.name", "b.code",
      DB::raw('(select count(u.id) from users as u where u.branch_id=b.id) as userCount'),
      DB::raw('(select count(q.id) from questions as q where q.lesson_id=b.id) as questionCount'))
    ->get();
    return response()->json($branches);
  }

  public function findByNameBranches(Request $request) {
    if (!$request->exists("searchTerm")) {
      return response()->json([
        ResponseHelper::MESSAGE => "Gönderilen veri sunucuyla uyumsuz!"
      ], 406);
    }
    $searchTerm = $request->query('searchTerm');
    $insts = Branch::where('name', 'like', '%' . $searchTerm . '%')->get();
    return response()->json($insts);
  }

  public function getBranches() {
    $res = Branch::all("id", "name", "code");
    return response()->json($res);
  }
}
