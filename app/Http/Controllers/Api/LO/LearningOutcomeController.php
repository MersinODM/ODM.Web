<?php
/**
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */

namespace App\Http\Controllers\Api\LO;


use App\Http\Controllers\ApiController;
use App\Http\Controllers\ResponseHelper;
use App\Models\LearningOutcome;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Kazanım kayıt ve listeleme kontrolcüsü
 * Class LearningOutcomeController
 * @package App\Http\Controllers\Api\LO
 */
class LearningOutcomeController extends ApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validationResult = $this->apiValidator($request, [
            'branch_id' => 'required',
            "class_level" => "required",
            "code" => "required",
            "content" => "required"
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $data = $request->only("branch_id", "code", "class_level", "content", "description");

        try {
            DB::beginTransaction();
            $branch = new LearningOutcome($data);
            $branch->save();
            DB::commit();
            return response()->json([ResponseHelper::MESSAGE => "Kazanım kayıt işlemi başarılı."], 201);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json($this->apiException($exception), 500);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validationResult = $this->apiValidator($request, [
            'branch_id' => 'required',
            "content" => "required"
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {

            $lo = LearningOutcome::findOrFail($id);
            $lo->branch_id = $request->input("branch_id");
            $lo->content = $request->input("content");
            $lo->description = $request->input("description");
            $lo->save();

        } catch (Exception $exception) {
            return response()->json($this->apiException($exception), 500);
        }
        return response()->json([ResponseHelper::MESSAGE => "Kazanım güncelleme işlemi başarılı."], 201);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $res = LearningOutcome::destroy($id);
        if ($res)
            return response()->json([ResponseHelper::MESSAGE => "Kazanım silme işlemi başarılı."], 200);
        return response()->json([ResponseHelper::MESSAGE => "Kazanım silme işlemi başarısız."], 450);
    }


    public function findById($id)
    {
        $lo = LearningOutcome::where('id', $id)
            ->select(DB::raw("CONCAT(code, ' ', content) as learning_outcome"))
            ->first();
        return response()->json($lo);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findByContentAndLessonIdAndClassLevel(Request $request)
    {

        $validationResult = $this->apiValidator($request, [
            'lesson_id' => 'required',
            "content" => "required",
            "class_level" => "required",
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $content = $request->input("content");
        $lesson_id = $request->input("lesson_id");
        $class_level = $request->input("class_level");

        $lo = $this->findLO($lesson_id, $class_level, $content);
        return response()->json($lo, 200);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findByContentWithPaging(Request $request)
    {
        $validationResult = $this->apiValidator($request, [
            "searched_content" => "required",
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $content = $request->query("searched_content");

        $result = DB::table("learning_outcomes as lo")
            ->join("branches as b", "lo.branch_id", "=", "b.id")
            ->where("lo.code", "like", "%" . $content . "%")
            ->orWhere("lo.content", "like", "%" . $content . "%")
            ->select("lo.id",
                DB::raw("b.name as branch_name"),
                "lo.class_level",
                "lo.code",
                "lo.content",
                "lo.description")
            ->get();

        return response()->json($result);
    }

    /**
     * @param $size
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLastSavedRecords($size) {
        !isset($size) ? $size = 18 : null;
        $result = DB::table("learning_outcomes as lo")
            ->join("branches as b", "lo.branch_id", "=", "b.id")
            ->where("lo.created_at", "!=", null)
            ->orderBy("lo.created_at", "desc")
            ->take($size)
            ->select("lo.id",
                DB::raw("b.name as branch_name"),
                "lo.class_level",
                "lo.code",
                "lo.content",
                "lo.description")
            ->get();
        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findBy(Request $request)
    {
        $validationResult = $this->apiValidator($request, [
            "content" => "required",
            "class_level" => "required",
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $content = $request->query("content");
        $lesson_id = $request->query("lesson_id");
        $class_level = $request->query("class_level");

        if (!isset($lesson_id)) {
            $lesson_id = Auth::user()->branch_id;
        }

        $lo = $this->findLO($lesson_id, $class_level, $content);
        return response()->json($lo, 200);
    }

    /**
     * @param $lesson_id
     * @param $class_level
     * @param $content
     * @return mixed
     */
    protected function findLO($lesson_id, $class_level, $content)
    {
        $lo = LearningOutcome::where([
            ["branch_id", "=", $lesson_id],
            ["class_level", "=", $class_level]
        ])
            ->where(function ($query) use ($content) {
                $query->where("content", "like", "%" . $content . "%")
                    ->orWhere("code", "like", "%" . $content . "%");
            })->select("id", "code", "content")
            ->get();
        return $lo;
    }
}
