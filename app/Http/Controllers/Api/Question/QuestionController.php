<?php
/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers\Api\Question;


use App\Http\Controllers\ApiController;
use App\Http\Controllers\ResponseHelper;
use App\Models\AnswerChoice;
use App\Models\Branch;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class QuestionController extends ApiController
{
    public function create(Request $request) {

      $validationResult = $this->apiValidator($request, [
        'item_root' => 'required',
        'lesson_id' => 'required',
        'learning_outcome_id' => 'required',
        'choices' => 'required|min:4'
      ]);
      if ($validationResult) {
        return response()->json($validationResult,422);
      }

      $question = $request->all();
      $lesson_id = $question["lesson_id"];
      $lo_id = $question["learning_outcome_id"];
      $header = $question["header"];
      $footer = $question["footer"];
      $item_root = $question["item_root"];
      $question_file =  $question["question_file"];
      if (isset($question["question_file"]))
        $question_file = $question["question_file"];
      $choices = $question["choices"];

      try {
        DB::beginTransaction();
        $question = new Question();
        $question->lesson_id = $lesson_id;
        $question->learning_outcome_id = $lo_id;
        $question->header = $header;
        $question->footer = $footer;
        $question->item_root = $item_root;
        $question->creator_id = Auth::user()->id;
        $isSaved = $question->save();

        if ($isSaved) {
          $code = Branch::find($lesson_id)->code;
          if ($question_file !== null) {
            $expl = explode(".", $question_file->getClientOriginalName());
            $ext = end($expl);
            $path = 'public/'.$code.'/'.'Q/'.$question->id.'-'.$question->creator_id.'.'.$ext;
            Storage::put($path, file_get_contents($question_file->getPathName()));
            $question->content_url = $path;
            $question->save();
          }
          for ($choiceIndex = 0; $choiceIndex <  count($choices); $choiceIndex++) {
            $content = $choices[$choiceIndex]["content"];
            $correct = $choices[$choiceIndex]["correct"];

            $ac = new AnswerChoice();
            $ac->question_id = $question->id;
            $ac->content = $content;
            $ac->is_correct = $correct;
            $isChoiceSaved = $ac->save();
            if ($isChoiceSaved) {
              $choicesFile = null;
              if (isset($choices[$choiceIndex]["file"]))
                $choicesFile = $choices[$choiceIndex]["file"];
              if ($choicesFile) {
                $explodes = explode(".", $choicesFile->getClientOriginalName());
                $ext = end($explodes);
                $path = 'public/'.$code.'/'.'C/'.$question->id.'-'.$ac->id.'-'.$question->creator_id.'.'.$ext;
                Storage::put($path, file_get_contents($choicesFile->getPathName()));
                $ac->content_url = $path;
                $ac->save();
              }
            }
          }
        }
        DB::commit();
      }
      catch (Exception $exception) {
        DB::rollBack();
        return response()->json($this->apiException($exception), 500);
      }
      return response()->json([ResponseHelper::MESSAGE => "Soru ekleme işlemi başarılı."], 201);
    }

    public function findById($id) {
//      $question = Question::findOrFail($id);
      $question = DB::table("questions as q")
        ->join("users as u", "u.id", "=", "q.creator_id")
        ->join("branches as b", "b.id", "=", "q.lesson_id")
        ->join("learning_outcomes as lo", "lo.id", "=", "q.learning_outcome_id")
        ->where("q.id", $id)
        ->select(
          "q.id",
          "q.item_root",
          DB::raw("DATE_FORMAT(q.created_at, '%d.%m.%Y') as created_at"),
          "lo.content as learning_outcome",
          "lo.class_level",
          "u.full_name as creator",
          "b.name as branch"
        )
        ->first();
      if (isset($question)) {
        return response()->json($question, 200);
      }
      return response()->json([ResponseHelper::MESSAGE => "Böyle bir soru yok!"], 404);
    }

    public function findByContentAndClassLevelAndBranch(Request $request)
    {

      $validationResult = $this->apiValidator($request, [
        'branch_id' => 'required',
        'class_level' => 'required'
      ]);
      if ($validationResult) {
        return response()->json($validationResult, 422);
      }

      $branch_id = $request->query('branch_id');
      $class_level = $request->query('class_level');
      $searched_content = $request->query('searched_content');

      $res = DB::table("questions as q")
        ->join("learning_outcomes as lo", "lo.id", "=", "q.learning_outcome_id")
        ->where ([
          ["lo.class_level", "=",$class_level],
          ["q.lesson_id", "=", $branch_id],
          ["q.item_root", "like", "%".$searched_content."%"]
        ])
//        ->orWhere("q.body", "%".$searched_content."%")
        ->select("q.id", "q.item_root")
        ->get();
      return response()->json($res, 200);

    }

    public function getFile($id) {
      $question = Question::findOrFail($id);
      if (isset($question->content_url)) {
        $realpath = Storage::disk()->getDriver()->getAdapter()->applyPathPrefix($question->content_url);
        $data = (string) Image::make($realpath)->encode('data-url');

        return response($data, 200);
      }
      return response()->json([ResponseHelper::MESSAGE => "Belirttiğiniz soruya ait bir dosya yok!"], 404);
    }

}
