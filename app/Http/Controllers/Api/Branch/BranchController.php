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

namespace App\Http\Controllers\Api\Branch;


use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\Branch;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends ApiController
{

    public function create(Request $request)
    {

        $validationResult = $this->apiValidator($request, ['name' => 'required|max:50']);
        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            $name = $request->input("name");
            $code = $request->input("code");
            $class_levels = $request->input("class_levels");
            $branch = new Branch();
            $checkBranch = Branch::where("name", $name)->first();
            if (isset($checkBranch)) {
                $branch->fill(["name" => $name, "code" => $code, "class_levels" => $class_levels]);
                $branch->save();
            }
        } catch (Exception $exception) {
            return response()->json($this->apiException($exception), 500);
        }
        return response()->json([
            ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
            ResponseKeys::MESSAGE => 'Branş/Ders kayıt işlemi başarılı.'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validationResult = $this->apiValidator($request, ['name' => 'required|max:50']);
        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            $name = $request->input("name");
            $code = $request->input("code");
            $class_levels = $request->input("class_levels");
            $branch = Branch::findOrFail($id);
            $branch->name = $name;
            $branch->code = $code;
            $branch->class_levels = $class_levels;
            $branch->save();
        } catch (Exception $exception) {
            return response()->json($this->apiException($exception), 500);
        }
        return response()->json([
            ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
            ResponseKeys::MESSAGE => "Branş/Ders güncelleme işlemi başarılı."
        ], 201);
    }

    public function delete(Request $request, $id)
    {

    }

    public function getBranchesWithStats()
    {
        $branches = DB::table("branches as b")
            ->select("b.name", "b.code",
                DB::raw('(select count(u.id) from users as u where u.branch_id=b.id) as userCount'),
                DB::raw('(select count(q.id) from questions as q where q.lesson_id=b.id) as questionCount'))
            ->get();
        return response()->json($branches);
    }

    public function getBranches()
    {
        $res = Branch::all("id", "name", "code", "class_levels");
        return response()->json($res);
    }
}
