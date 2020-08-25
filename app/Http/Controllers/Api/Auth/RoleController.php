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
