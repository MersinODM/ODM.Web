<?php
//
//
//namespace App\Http\Controllers\Api\Question;
//
//
//use App\Http\Controllers\ApiController;
//use App\Http\Controllers\ResponseHelper;
//use App\Models\Question;
//use App\Models\QuestionsEvaluation;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\DB;
//
//class QuestionEvalController extends ApiController
//{
//    public function create($id, Request $request) {
//        $validationResult = $this->apiValidator($request, [
//            'point' => 'required|numeric|min:1|max:5',
//            'comment' => 'required'
//        ]);
//        if ($validationResult) {
//            return response()->json($validationResult, 422);
//        }
//
//        // Son girilen iki değerlemndirme dikkate alınacak
//        // Revizyon mantığı için bu gerekli
//        $question = Question::findOrFail($id);
//        $check_result = (object)$this->checkQuestionIsPassed($question);
//        $evalCount = 0;
//        if ($check_result->is_passed) {
//            $is_duplicate_eval = $this->checkDoubleRecordForEval($question);
//            if ($is_duplicate_eval)
//                return response()->json([
//                    "eval_count" => 1, // TODO Bu neden vardı ki?
//                    "eval_avg" => $check_result->evalAvg,
//                    ResponseHelper::MESSAGE => "Daha önce bir değerlendirme tarafınızdan yapılmıştır."
//                ]);
//            try {
//                DB::beginTransaction();
//                $qe = new QuestionsEvaluation([
//                    "elector_id" => Auth::id(),
//                    "question_id" => $id,
//                    "comment" => $request->input("comment"),
//                    "point" => $request->input("point")
//                ]);
//                $qe->save();
//                DB::commit();
//
//                $check_result = (object)$this->checkQuestionIsPassed($question);
//                if ($check_result->is_passed) {
//                    $question->is_passed = true;
//                    $question->save();
//                }
//
//                $evalCount = $question->evaluations()
//                    ->take(2)
//                    ->count();
//                return response()->json([
//                    "eval_count" => $evalCount,
//                    "eval_avg" => $check_result->evalAvg,
//                    ResponseHelper::MESSAGE => "Değerlendirme puanınız: " . $qe->point . "\nDeğerlendirme kaydı başarılı"], 201);
//            } catch (\Exception $exception) {
//                DB::rollBack();
//                return response()->json($this->apiException($exception), 500);
//            }
//        }
//        return response()->json([
//            "eval_count" => $evalCount,
//            "eval_avg" => $check_result->evalAvg,
//            ResponseHelper::MESSAGE => "Bu soru için yeterli ve gerekli değerlendirmeler daha önce yapılmıştır."]);
//
//    }
//
//    public function findByQuestionId($id) {
//        $evals = DB::table("questions_evaluations")
//            ->where("question_id", "=", $id)
//            ->select("id", "question_id", "comment", DB::raw("DATE_FORMAT(created_at, '%d.%m.%Y') as date"))
//            ->get();
//        return response()->json($evals);
//    }
//
//    /**
//     * @param $question
//     * @return array
//     */
//    private function checkQuestionIsPassed($question)
//    {
//        $evalSum = $question->evaluations()
//            ->orderBy("created_at", "desc")
//            ->take(2)
//            ->sum("point");
//        //Revizyon olması durumunda önceki verilen puanlar 0 lanacağı için
//        //bölüm sonucu çok küçüleceğinden toplam 2 ye bölünmüştür.
//        //TODO: Aslında ayarlar tablosundan da değerledirici kişi sayısı değiştirilebilmeli
////        $evalCount > 0 ? $evalAvg = round($evalSum / 2) : $evalAvg = 0;
//        $evalAvg = round($evalSum / 2);
//        return ["eval_avg" => $evalAvg < 3.5, "is_passed" => $evalAvg < 3.5];
//    }
//
//    /**
//     * @param $question
//     * @return mixed
//     */
//    private function checkDoubleRecordForEval($question)
//    {
//        $usersEvals = $question->evaluations()
//            ->where("elector_id", Auth::id())
//            ->take(2)
//            ->count();
//        return $usersEvals == 1;
//    }
//}
