<?php
/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers\Api\Exam;


use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Question;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class ExamController extends ApiController
{
    public function createFastExam(Request $request)
    {
        $validationResult = $this->apiValidator($request, [
            'title' => 'required',
            'planned_date' => 'required',
            'class_level' => 'required',
            'purpose_id' => 'required',
            'lessons' => 'required|array|min:1',
            'lessons.*.question_count' => 'required|integer|min:1',
            'lessons.*.id' => 'required',
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $lessons = $request->input('lessons');
        $code = strtoupper(Str::random(6));

        try {
            // TODO burada transaction ikiye bölünecek eventler ile transaction bütünlüğü sağlamnacak
            DB::beginTransaction();
            // Önce sınavı oluşturalım
            //TODO sınıf seviyesi sorgulara bir kriter olarak girmeli
            $exam = new Exam([
                'creator_id' => Auth::id(),
                'purpose_id' => $request->input('purpose_id'),
                'code' => $code,
                'title' => $request->input('title'),
                'class_level' => $request->input('class_level'),
                'planned_date' => $request->input('planned_date'),
                'description' => $request->input('description'),
                'status' => Exam::CREATED
            ]);
            $exam->save();
            // Sonra soruları getirelim
            foreach ($lessons as $lesson) {

                $questions = DB::table('questions as q')
                    ->inRandomOrder()
//                    ->innerJoin('users as u', 'u.id', '=', 'q.creator_id')
//                    ->innerJoin('branches as b', 'b.id', '=', 'q.lesson_id')
//                    ->innerJoin('learning_outcomes as lo', 'lo.id', '=', 'q.learning_outcome_id')
                    ->where('lesson_id', $lesson['id'])
                    ->where('status', Question::APPROVED)
                    ->select(
                        'q.id',
//                        'b.name as branch_name',
//                        DB::raw('CONCAT(lo.code, " ", lo.content) as learning_outcome'),
//                        'u.full_name as creator',
//                        'q.correct_answer',
                        'q.content_url' //,
//                        'q.keywords'
                    )
                    ->limit($lesson['question_count'])
                    ->get();

                // Sorular geldikten sonra sınavla ilişkilendirelim
                $examQuestions = collect([]);
                foreach ($questions as $question) {
                    $examQuestion = [
                        'exam_id' => $exam->id,
                        'question_id' => $question->id
                    ];
                    $examQuestions->push($examQuestion);
                }
                ExamQuestion::insert($examQuestions->toArray());
            }

            //Zip dosyasını oluşturmaya başlayalım
            $zipArchive = new ZipArchive();
            $fileName = 'Exam-'. $code .'.zip';
            $filePath = 'exams/' . $fileName;
            $fullPath = Storage::disk('local')->path('public/'.$filePath);
//            $fullPath = storage_path('app/public/'.$filePath);
            $res =  $zipArchive->open($fullPath, ZipArchive::CREATE) === true;

            //Zip dosyası oluşturma başarılı ise dosyaları zip içine atalım
            if ($res) {
                $examQuestions = ExamQuestion::where('exam_id',  $exam->id)
                    ->join('questions as q', 'q.id', '=', 'question_id')
                    ->select('q.id', 'q.content_url')
                    ->get();

                foreach ($examQuestions as $question) {
                    $explodedPath = explode("/", $question->content_url);
                    $fileName= end($explodedPath);
                    $sp = Storage::disk('local')->path($question->content_url);
                    if(file_exists($sp)) {
                        $zipArchive->addFile($sp, $fileName);
                    }else {
                        DB::rollBack();
                        return response()->json([
                            ResponseKeys::CODE => ResponseCodes::CODE_WARNING,
                            ResponseKeys::MESSAGE => "Seçilen bir soruya ait dosyaya ulaşılamadı! Ulaşılamayan Dosya Adı:".$fileName
                        ]);
                    }
                }
                // Zip dosyasını kapatalım
                $zipArchive->close();

                //Sınavın yolunu kaydedelim
                $exam->path = $filePath;
                $exam->status = Exam::PLANNED;
                $exam->save();
                DB::commit();

                return response()->download($fullPath);
            }

            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_WARNING,
                ResponseKeys::MESSAGE => 'Sınav oluşturma başarısız oldu!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiException($e);
        }
    }

    public function getExamPDF(Request $request, $id)
    {
        $settings = Setting::first();
        $exam = DB::table('exams as e')
            ->join('exam_purposes as ep', 'e.purpose_id', '=', 'ep.id')
            ->join('users as u', 'e.creator_id', '=', 'u.id')
            ->where("e.id", $id)
            ->select('e.id', 'u.full_name as creator', 'ep.purpose', 'e.code',
                'status', 'title', 'class_level',
                'planned_date')
            ->first();

        $questions = ExamQuestion::where('exam_id', $id)
            ->join('questions as q', 'question_id', '=', 'q.id')
            ->join('learning_outcomes as lo', 'q.learning_outcome_id', '=', 'lo.id')
            ->join('users as u', 'creator_id', '=', 'u.id')
            ->select('q.id',
                DB::raw('(case q.difficulty 
            when 1 then "Çok Kolay"
            when 2 then "Kolay"
            when 3 then "Normal"
            when 4 then "Zor"
            when 5 then "Çok Zor"
            else "Belirsiz"
            end) as difficulty'),
                'q.correct_answer',
                DB::raw('IF(q.is_design_required, "Gerekli", "Gerekli Değil") as is_design_required'),
                'u.full_name as creator',
                DB::raw('CONCAT(lo.code, " ", lo.content) as learning_outcome'),
                DB::raw('SUBSTRING_INDEX(q.content_url, "/", -1) as file_name')
            )
            ->orderBy('q.lesson_id')
            ->get();

//        return view('reports.exams.ExamReport', ['settings' => $settings, 'exam' => $exam]);
        PDF::setOptions(['isRemoteEnabled' => true]);
        $pdf = PDF::loadView('reports.exams.ExamReport', ['settings' => $settings, 'exam' => $exam, 'questions' => $questions]);
        return $pdf->download($exam->code . '-Exam-Report.pdf');
    }
}
