<?php
/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers\Api\Exam;


use App\Http\Controllers\ApiController;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends ApiController
{
    public function createFastExam(Request $request)
    {
        $validationResult = $this->apiValidator($request, [
            'title' => 'required',
            'planned_date' => 'required',
            'class_level' => 'required',
            'lessons' => 'required|array|min:1',
            'lessons.question_count' => 'required|integer|min:5',
            'lessons.id' => 'required',
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $lessons = $request->input('lessons');

        try {
            DB::beginTransaction();
            foreach ($lessons as $lesson) {
                $questions = DB::table('questions as q')
                    ->inRandomOrder()
                    ->innerJoin('users as u', 'u.id', '=', 'q.creator_id')
                    ->innerJoin('branches as b', 'b.id', '=', 'q.lesson_id')
                    ->innerJoin('learning_outcomes as lo', 'lo.id', '=', 'q.learning_outcome_id')
                    ->where('branch_id', $lesson->id)
                    ->where('status', Question::APPROVED)
                    ->select(
                        'q.id',
                        'b.name as branch_name',
                        DB::raw('CONCAT(lo.code, " ", lo.content) as learning_outcome'),
                        'u.full_name as creator',
                        'q.correct_answer',
                        'q.content_url',
                        'q.keywords'
                    )
                    ->limit($lesson->question_count);
            }
            DB::commit();
            return '';
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiException($e);
        }
    }

    public function getExamPDF(Request $request) {

    }
}
