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

namespace App\Http\Controllers\Api\Question;


use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\Question;
use App\Models\QuestionRevisions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuestionRevisionController extends ApiController {

    public function create($id, Request $request) {
        $validationResult = $this->apiValidator($request, [
            'comment' => "required",
            'question_file' => 'required|mimes:pdf|max:1024'
        ]);
        if ($validationResult) {
            return response()->json($validationResult,422);
        }

        $question_rev = $request->all();
        $comment = $question_rev["comment"];
//        $title = $question_rev["title"];
        $question_file = $question_rev["question_file"];
        $question = Question::findOrFail($id);
        $path = $question->content_url;

        $rev_count = $question->revisions()
            ->count();

        try {
            DB::beginTransaction();
            $rev = new QuestionRevisions([
                "question_id" => $id,
                "title" => "Gözden geçirme " . ($rev_count + 1),
                "comment" => $comment
            ]);
            $rev->save();
            Question::where('id', $id)
                ->where('status', Question::NEED_REVISION)
                ->update(['status' => Question::REVISION_COMPLETED]);
            // TODO adminlere veya komisyona mail atmak gerekebilir
            Storage::copy($path, "temp/".$path);
            Storage::delete($path);
            Storage::put($path, file_get_contents($question_file->getPathName()));
            DB::commit();
            return response()->json($question->revisions(), 201);
        }
        catch (\Exception $exception) {
            DB::rollBack();
            Storage::move("temp/".$path, $path);
            return response()->json([ResponseKeys::MESSAGE=> "Revizyon kaydı başarısız!",
                ResponseKeys::EXCEPTION => $this->apiException($exception)], 500);
//            return response()->json([ResponseKeys::EXCEPTION => "Revizyon kaydı başarısız!"],500);
        }
    }

    public function findByQuestionId($id) {
        $revisions = QuestionRevisions::where("question_id", "=", $id)
            ->select("id", "title", "comment", "created_at as date")
            ->get();
        return response()->json($revisions);
    }

}
