<?php
/**
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup
 *  geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *   Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers\Api\Question;


use App\Http\Controllers\ApiController;
use App\Http\Controllers\ResponseHelper;
use App\Models\Branch;
use App\Models\LearningOutcome;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class QuestionController extends ApiController
{
    public function create(Request $request) {

      $validationResult = $this->apiValidator($request, [
        'learning_outcome_id' => 'required',
        'difficulty' => 'required',
        'question_file' => 'required|mimes:pdf|max:1024'
      ]);
      if ($validationResult) {
        return response()->json($validationResult,422);
      }

      $question = $request->all();
      $lesson_id = $question["lesson_id"];
      if (!isset($lesson_id))
          $lesson_id = Auth::user()->branch_id;
      $lo_id = $question["learning_outcome_id"];
      $difficulty = $question["difficulty"];
      $keywords = $question["keywords"];
      $correct_answer = $question["correct_answer"];
//      $header = $question["header"];
//      $footer = $question["footer"];
//      $item_root = $question["item_root"];
      $question_file =  $question["question_file"];
//      if (isset($question["question_file"]))
//        $question_file = $question["question_file"];
//      $choices = $question["choices"];

      try {
        DB::beginTransaction();
        $question = new Question();
        $question->lesson_id = $lesson_id;
        $question->learning_outcome_id = $lo_id;
        $question->difficulty = $difficulty;
        $question->correct_answer = $correct_answer;
        $question->keywords = $keywords;
//        $question->header = $header;
//        $question->footer = $footer;
//        $question->item_root = $item_root;
        $question->creator_id = Auth::user()->id;
        $isSaved = $question->save();
        $lo = LearningOutcome::findOrFail($lo_id)->code;
        $loCode = str_replace(".", "-", $lo);
        if ($isSaved) {
          $code = Branch::find($lesson_id)->code;
          if ($question_file !== null) {
            $expl = explode(".", $question_file->getClientOriginalName());
            $ext = end($expl);

            $path = 'public/'.$loCode.$question->creator_id.'-'.$question->id.'.'.$ext;
            Storage::put($path, file_get_contents($question_file->getPathName()));
            $question->content_url = $path;
            $question->save();
          }
//          for ($choiceIndex = 0; $choiceIndex <  count($choices); $choiceIndex++) {
//            $content = $choices[$choiceIndex]["content"];
//            $correct = $choices[$choiceIndex]["correct"];
//
//            $ac = new AnswerChoice();
//            $ac->question_id = $question->id;
//            $ac->content = $content;
//            $ac->is_correct = $correct;
//            $isChoiceSaved = $ac->save();
//            if ($isChoiceSaved) {
//              $choicesFile = null;
//              if (isset($choices[$choiceIndex]["file"]))
//                $choicesFile = $choices[$choiceIndex]["file"];
//              if ($choicesFile) {
//                $explodes = explode(".", $choicesFile->getClientOriginalName());
//                $ext = end($explodes);
//                $path = 'public/'.$code.'/'.'C/'.$question->id.'-'.$ac->id.'-'.$question->creator_id.'.'.$ext;
//                Storage::put($path, file_get_contents($choicesFile->getPathName()));
//                $ac->content_url = $path;
//                $ac->save();
//              }
//            }
//          }
        }
        DB::commit();
      }
      catch (Exception $exception) {
        DB::rollBack();
        Storage::delete($path);
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
          "q.keywords",
          "q.difficulty",
          "q.correct_answer",
          "q.is_passed",
          DB::raw("DATE_FORMAT(q.created_at, '%d.%m.%Y') as created_at"),
          DB::raw("CONCAT(lo.code, ' ', lo.content) as learning_outcome"),
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
            'class_level' => 'required'
        ]);
        if ($validationResult) {
            return response()->json($validationResult, 422);
        }
        $user = Auth::user();
        $branch_id = $request->query('branch_id');
        if (!isset($branch_id))
            $branch_id = $user->branch_id;
        $class_level = $request->query('class_level');
        $searched_content = $request->query('searched_content');
        if ($user->isAn('admin') || $user->isAn('elector')) {
            $res =  DB::select("SELECT q.id, q.keywords, lo.code, lo.content FROM questions as q
                                INNER JOIN learning_outcomes lo on q.learning_outcome_id = lo.id
                                WHERE lo.class_level = :class_level AND
                                      q.lesson_id = :lesson_id AND
                                      (q.keywords like CONCAT('%', :sc1, '%') ||
                                       lo.content like CONCAT('%', :sc2, '%') ||
                                       lo.code like CONCAT(:sc3, '%'))",
                [
                    "class_level"=> $class_level,
                    "lesson_id" =>$branch_id,
                    "sc1" => $searched_content,
                    "sc2" => $searched_content,
                    "sc3" => $searched_content,
                ]);
            return response()->json($res, 200);
        }
        if ($user->isAn('teacher')) {
            $id = $user->id;
            // PArametre sayısı aynı olmazsa ve eşsiz parametre adı olmazsa hata basıypor
            $res =  DB::select("SELECT q.id, q.keywords, lo.code, lo.content FROM questions as q
                                INNER JOIN learning_outcomes lo on q.learning_outcome_id = lo.id
                                WHERE q.creator_id = :user_id AND
                                      lo.class_level = :class_level AND
                                      q.lesson_id = :lesson_id AND
                                      (q.keywords like CONCAT('%', :sc1, '%') ||
                                       lo.content like CONCAT('%', :sc2, '%') ||
                                       lo.code like CONCAT(:sc3, '%'))",
                [
                    "user_id" => $id,
                    "class_level"=> $class_level,
                    "lesson_id" =>$branch_id,
                    "sc1" => $searched_content,
                    "sc2" => $searched_content,
                    "sc3" => $searched_content,
                ]);
            return response()->json($res, 200);
        }
        return response()->json([ResponseHelper::MESSAGE => "Hiçbir şey bulamadık!"], 404);

    }

    public function getLastQuestions($size) {

        $user = Auth::user();
        if ($user->isAn('admin') || $user->isAn('elector')) {
            $res = DB::table("questions as q")
                ->join("learning_outcomes as l", "l.id", "=", "q.learning_outcome_id")
                ->orderBy("q.created_at", "desc")
                ->take($size)
                ->select("q.id", "q.keywords", "l.code", "l.content")
                ->get();
            return response()->json($res, 200);
        }
        if ($user->isAn('teacher')) {
            $id = $user->id;
            $branch_id = $user->branch_id;
            // PArametre sayısı aynı olmazsa ve eşsiz parametre adı olmazsa hata basıypor
            $res = DB::table("questions as q")
                ->join("learning_outcomes as l", "l.id", "=", "q.learning_outcome_id")
                ->where("q.lesson_id", $branch_id)
                ->where("q.creator_id", $id)
                ->orderBy("q.created_at", "desc")
                ->take($size)
                ->select("q.id", "q.keywords", "l.code", "l.content")
                ->get();
            return response()->json($res, 200);
        }
        return response()->json([ResponseHelper::MESSAGE => "Hiçbir şey bulamadık!"], 200);

    }

    public function getFile($id) {
      $question = Question::findOrFail($id);
      $filePath =  $question->content_url;
      if (isset($filePath)) {
//        $realpath = Storage::disk()->getDriver()->getAdapter()->applyPathPrefix($question->content_url);
//        $data = (string) Image::make($realpath)->encode('data-url');
//        $file = Storage::get($question->content_url);
              if( ! Storage::exists($filePath) ) {
                  return response()->json([ResponseHelper::MESSAGE => "Belirttiğiniz soruya ait bir dosya yok!"], 404);
              }
              $pdfContent = Storage::get($filePath);
              $encodedPDF = "data:application/pdf;base64,".base64_encode($pdfContent);
              return response($encodedPDF, 200);
              // for pdf, it will be 'application/pdf'
//              $type       = Storage::mimeType($filePath);
//              $fileName   = Storage::baseName($filePath);
//              $explodes = explode("/", $filePath);
//              $fileName = end($explodes);
//
//              return Response::make($pdfContent, 200, [
//                  'Content-Type'        => 'application/pdf',
//                  'Content-Disposition' => 'inline; filename="'.$fileName.'"'
//              ]);
//              return Storage::download($filePath);
//          return response()->download($filePath);
      }
      return response()->json([ResponseHelper::MESSAGE => "Veritabanına dosya yolu kaydı girilmemiş!"], 404);
    }

}
