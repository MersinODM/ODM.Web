<?php
/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers\Api\Exam;


use App\Http\Controllers\ApiController;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Question;
use App\Models\Setting;
use App\Traits\RandomCodeGenerator;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ExamController extends ApiController
{
    use RandomCodeGenerator;

    public function createFastExam(Request $request)
    {
        $validationResult = $this->apiValidator($request, [
            'title' => 'required',
            'planned_date' => 'required',
            'class_level' => 'required|integer',
            'purpose_id' => 'required|integer',
            'lessons' => 'required|array|min:1',
            'lessons.*.question_count' => 'required|integer|min:1',
            'lessons.*.id' => 'required|integer',
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $lessons = $request->input('lessons');
        $code = $this->getRandomCode();

        try {
            DB::beginTransaction();
            // Önce sınavı oluşturalım
            //TODO sınıf seviyesi sorgulara bir kriter olarak girmeli
            $exam = $this->createExam($request, $code);

            // Sonra soruları derslere göre rastgele getirelim
            $this->selectAndSaveQuestionsInExam($lessons, $exam);

            $filePath= $this->createZipFile($code, $exam);
            DB::commit();

            return response()->download($filePath);
        } catch (Exception $e) {
            DB::rollBack();
//            Storage::move($exam->path, 'public/trash/'.$fileName);
            return $this->apiException($e);
        }
    }

    public function create(Request $request) {
        $validationResult = $this->apiValidator($request, [
            'title' => 'required',
            'planned_date' => 'required',
            'class_level' => 'required',
            'purpose_id' => 'required',
            'questions' => 'required|array'
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }
    }

    public function getExamPDF(Request $request, $id)
    {
        $settings = Setting::first();
        $exam = DB::table('exams as e')
            ->join('exam_purposes as ep', 'e.purpose_id', '=', 'ep.id')
            ->join('users as u', 'e.creator_id', '=', 'u.id')
            ->where("e.id", $id)
            ->select('e.id',
                'u.full_name as creator',
                'ep.purpose', 'e.code',
                DB::raw('(case status 
                    when '.Exam::CREATED.' then "Oluşturulmuş"
                    when '.Exam::PLANNED.' then "Planlanmış"
                    when '.Exam::CANCELED.' then "İptal edilmiş"
                    when '.Exam::COMPLETED.' then "Tamamlanmış"
                    else "Belirsiz"
                    end) as status'),
                'title', 'class_level',
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
                'q.is_design_required',
                DB::raw('IF(q.is_design_required, "Gerekli", "Gerekli Değil") as idr_text'),
                'u.full_name as creator',
                DB::raw('CONCAT(lo.code, " ", lo.content) as learning_outcome'),
                DB::raw('SUBSTRING_INDEX(q.content_url, "/", -1) as file_name')
            )
            ->orderBy('q.lesson_id')
            ->get();

//        return view('reports.exams.ExamReport', ['settings' => $settings, 'exam' => $exam]);
        PDF::setOptions(['isRemoteEnabled' => true]);
        $pdf = PDF::loadView('reports.exams.ExamReport', [
            'settings' => $settings,
            'exam' => $exam,
            'questions' => $questions
        ]);
        return $pdf->download($exam->code . '-Exam-Report.pdf');
    }

 

    /**
     * @param Request $request
     * @param string $code
     * @return Exam
     */
    private function createExam(Request $request, string $code): Exam
    {
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
        return $exam;
    }

    /**
     * @param string $code
     * @param Exam $exam
     * @return false|string[]
     */
    private function createZipFile(string $code, Exam $exam)
    {
        //Zip dosyasını oluşturmaya başlayalım
        $zipArchive = new ZipArchive();
        $fileName = 'Exam-' . $code . '.zip';
        $filePath = 'exams/' . $fileName;
        $fullPath = Storage::disk('local')->path('public/' . $filePath);
        $res = $zipArchive->open($fullPath, ZipArchive::CREATE) === true;

        //Zip dosyası oluşturma başarılı ise dosyaları zip içine atalım
        if ($res) {
            $examQuestions = ExamQuestion::where('exam_id', $exam->id)
                ->join('questions as q', 'q.id', '=', 'question_id')
                ->select('q.id', 'q.content_url')
                ->get();

            foreach ($examQuestions as $question) {
                $explodedPath = explode("/", $question->content_url);
                $fileName = end($explodedPath);
                $sp = Storage::disk('local')->path($question->content_url);
                if (file_exists($sp)) {
                    $zipArchive->addFile($sp, $fileName);
                } else {
                    throw new \RuntimeException("Zip dosyasını oluşturma başarısız oldu.");
                }
            }
            // Zip dosyasını kapatalım
            $zipArchive->close();

            //Sınavın yolunu kaydedelim
            $exam->path = $filePath;
            $exam->status = Exam::PLANNED;
            $exam->save();
        }
        return $fullPath;
    }

    /**
     * Soruları otomatik olarak seçerek sınav içine kaydeder
     * @param array|null $lessons
     * @param Exam $exam
     */
    private function selectAndSaveQuestionsInExam(?array $lessons, Exam $exam): void
    {
        //Her bir dersi tek tek dönelim
        foreach ($lessons as $lesson) {
            //Her ders için belirtilen sayında soruyu seçelim
            $questions = DB::table('questions as q')
                ->inRandomOrder()
                ->where('lesson_id', $lesson['id'])
                ->where('status', Question::APPROVED)
                ->select(
                    'q.id',
                    'q.content_url'
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
    }


}
