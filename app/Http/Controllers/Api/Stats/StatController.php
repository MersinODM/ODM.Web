<?php


namespace App\Http\Controllers\Api\Stats;


use App\Http\Controllers\ApiController;
use App\Http\Controllers\ResponseHelper;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatController extends ApiController
{
    public function getQuestionCounts() {
        if (Auth::user()->isAn("teacher", "elector")) {
            $counts = DB::select("select (IF(is_passed, count(id), 0)) as valid_count,
                                                (IF(!is_passed, count(id), 0)) as non_valid_count,
                                                count(id) as total_count 
                                  from questions
                                  where lesson_id = :branchId", ["branchId" => Auth::user()->branch_id])[0];
            return response()->json($counts);
        }
        if (Auth::user()->isAn("admin")) {
            $counts = DB::select("select (IF(is_passed, count(id), 0)) as valid_count,
                                               (IF(is_passed = 0, count(id), 0)) as non_valid_count,
                                               count(id) as total_count 
                                        from questions")[0];
            return response()->json($counts);
        }
        return response()->json(["valid_count" => 0, "non_valid_count" => 0, "total_count" => 0]);
    }

//    public function getQuestionCountByLO($lo_id) {
//        $loQuestionCount = DB::select("select (IF(is_passed, count(id), 0)) as valid_count,
//                                                    (IF(is_passed = 0, count(id), 0)) as non_valid_count,
//                                                    count(id) as total_count
//                                            from questions
//                                            where learning_outcome_id = :lo_id", ["lo_id" => $lo_id])[0];
//        return response()->json($loQuestionCount);
//    }

    public function getClasses() {
        if (Auth::user()->isAn("teacher", "elector")) {
            $classes = DB::select("select lo.class_level,
                                            (IF(is_passed, count(q.id), 0)) as valid_count,
                                            (IF(!q.is_passed, count(q.id), 0)) as non_valid_count,
                                            count(q.id) as total_count from questions as q
                                        inner join learning_outcomes lo on q.learning_outcome_id = lo.id
                                        where q.lesson_id = :branchId
                                        group by lo.class_level
                                        order by lo.class_level", ["branchId" => Auth::user()->branch_id]);
            return response()->json($classes);
        }
        elseif (Auth::user()->isAn("admin")) {
            $classes = DB::select("select lo.class_level,
                                            (IF(is_passed, count(q.id), 0)) as valid_count,
                                            (IF(!q.is_passed, count(q.id), 0)) as non_valid_count,
                                            count(q.id) as total_count from questions as q
                                        inner join learning_outcomes lo on q.learning_outcome_id = lo.id
                                        group by lo.class_level
                                        order by lo.class_level");
            return response()->json($classes);
        }
        else
            return response()->json([ResponseHelper::MESSAGE => "Herhangi bir yetkiniz yok"]);
    }

    public function getQuestionCountByLO(Request $request) {
        if ($request->query("is_any_question_lo")) {
            if (Auth::user()->isAn("teacher", "elector")) {
                $loQuestionCount = DB::select('select 
                                                   CONCAT(lo.code, " ", lo.content) as learning_outcome,
                                                    lo.id as learning_outcome_id,
                                                    (IF(is_passed, count(q.id), 0)) as valid_count,
                                                    (IF(is_passed = 0, count(q.id), 0)) as non_valid_count,
                                                    count(q.id) as total_count
                                            from questions as q
                                            inner join learning_outcomes lo on q.learning_outcome_id = lo.id
                                            where lo.class_level = :classLevel and lo.branch_id = :branchId
                                            group by lo.id',
                    ["classLevel" => $request->query("class_level"),
                        "branchId" => Auth::user()->branch_id]);
                return response()->json($loQuestionCount);
            } elseif (Auth::user()->isAn("admin")) {
                //TODO Sınıf seviyesi ile birlikte ders bilgisi de gönderilecek
                $loQuestionCount = DB::select('select 
                                                    CONCAT(lo.code, " ", lo.content) as learning_outcome,
                                                    lo.id as learning_outcome_id,
                                                    (IF(is_passed, count(q.id), 0)) as valid_count,
                                                    (IF(is_passed = 0, count(q.id), 0)) as non_valid_count,
                                                    count(q.id) as total_count
                                            from questions as q
                                            inner join learning_outcomes lo on q.learning_outcome_id = lo.id
                                            where lo.class_level = :classLevel
                                            group by lo.id',
                    ["classLevel" => $request->query("class_level")]);
                return response()->json($loQuestionCount);
            }
        }
        else {
            if (Auth::user()->isAn("teacher", "elector")) {
                $loQuestionCount = DB::select('select 
                                                   CONCAT(lo.code, " ", lo.content) as learning_outcome,
                                                    lo.id as learning_outcome_id,
                                                    (IF(is_passed, count(q.id), 0)) as valid_count,
                                                    (IF(is_passed = 0, count(q.id), 0)) as non_valid_count,
                                                    count(q.id) as total_count
                                            from questions as q
                                            right outer join learning_outcomes lo on q.learning_outcome_id = lo.id
                                            where lo.class_level = :classLevel and lo.branch_id = :branchId
                                            group by lo.id',
                    ["classLevel" => $request->query("class_level"),
                        "branchId" => Auth::user()->branch_id]);
                return response()->json($loQuestionCount);
            } elseif (Auth::user()->isAn("admin")) {
                //TODO Sınıf seviyesi ile birlikte ders bilgisi de gönderilecek
                $loQuestionCount = DB::select('select 
                                                    CONCAT(lo.code, " ", lo.content) as learning_outcome,
                                                    lo.id as learning_outcome_id,
                                                    (IF(is_passed, count(q.id), 0)) as valid_count,
                                                    (IF(is_passed = 0, count(q.id), 0)) as non_valid_count,
                                                    count(q.id) as total_count
                                            from questions as q
                                            right outer join learning_outcomes lo on q.learning_outcome_id = lo.id
                                            where lo.class_level = :classLevel
                                            group by lo.id',
                    ["classLevel" => $request->query("class_level")]);
                return response()->json($loQuestionCount);
            }
        }
    }
}
