<?php
/*
 * ODM.Web  https://github.com/electropsycho/ODM.Web
 * Copyright (C) 2020 Hakan GÜLEN
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/
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
