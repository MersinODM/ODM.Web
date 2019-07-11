<?php
/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers\Api\Auth;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Silber\Bouncer\Database\Ability;


class PermissionController extends Controller
{

  public function getAllPermissions() {
    $abilities = Ability::all("id","name", "title");
    return response()->json($abilities, 200);
  }

  public function getCurrentUserPermissions() {
    return auth()->user()->getAbilities();
//    return $permissions;
  }

  public function getRolePermissions($roleId) {

  }

  public function addPermissionToRole(Request $request, $roleId) {

  }

  public function addPermissionToUser(Request $request, $userId) {

  }

  public function removePermissionFromRole(Request $request) {

  }

  public function removePermissionFromUser(Request $request) {

  }
}
