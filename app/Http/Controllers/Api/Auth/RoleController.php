<?php
/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Silber\Bouncer\Database\Role;

class RoleController extends Controller
{
  public function getAllRoles() {
    $roles = Role::all("id", "name", "title");
    return response()->json($roles);
  }

  public function getUserRoles($userId) {
//    $roles = User::findOrFail($userId)->roles()->select(["roles.id","name", "title"])->get();
    $roles = User::findOrFail($userId)->getRoles();
    return response()->json($roles);
  }

    public function getCurrentUserRoles() {
//      $userId = Auth::user()->id;
//      $roles = User::findOrFail($userId)->roles()->select(["roles.id","name", "title"])->get();
      $roles = Auth::user()->getRoles();
      return response()->json($roles);
    }



    public function allowRoleToUser(Request $request) {

  }

  public function disallowRoleFromUser(Request $request) {

  }
}
