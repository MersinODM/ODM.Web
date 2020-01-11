<?php


namespace App\Http\Controllers\Api\Question;


use App\Http\Controllers\ApiController;
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
            Storage::delete($path);
            Storage::put($path, file_get_contents($question_file->getPathName()));
            DB::commit();
            return response()->json($question->revisions(), 201);
        }
        catch (\Exception $exception) {
            DB::rollBack();
            //Storage::delete($path);
            throw $exception;
//            return response()->json([ResponseHelper::EXCEPTION => "Revizyon kaydı başarısız!"],500);
        }
    }

    public function findByQuestionId($id) {
        $revisions = QuestionRevisions::where("question_id", "=", $id)
            ->select("id", "title", "comment", DB::raw("DATE_FORMAT(created_at, '%d.%m.%Y') as date"))
            ->get();
        return response()->json($revisions);
    }

}
