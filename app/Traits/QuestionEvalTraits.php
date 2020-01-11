<?php
/**
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *   Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */

namespace App\Traits;


use App\Models\Question;
use App\Models\QuestionEvalRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Bu trait soru değerlendirme fonksiyonlarını içerir
 * Trait QuestionEvalTraits
 * @package App\Traits
 */
trait QuestionEvalTraits
{
    /**
     * Bu fonksiyon yeterli değerlendirme sayısına uluaşılıp ulaşılmadığını kontrol edecek
     * @param $questionId
     * @return bool
     */
    private function checkQuestionEval($questionId, $code)
    {
        //Kayıtlı değerlendirme sayısı puanlanmış değerlendirme sayısına eşit mi?
        $savedEvalCount = QuestionEvalRequest::where('question_id', $questionId)
            ->where('code', $code)
            ->count();
        return QuestionEvalRequest::where('question_id', $questionId)
                ->where('code', $code)
                ->whereNotNull('point')
                ->count() === $savedEvalCount;
    }

    /**
     * Bu fonksiyon sorunun değerlendirme puanını hesaplayacak
     * @param $questionId
     * @param $code
     * @return mixed
     */
    private function calculateQuestionEval($questionId, $code)
    {
        return QuestionEvalRequest::where('question_id', $questionId)
            ->where('code', $code)
            ->whereNotNull('point')
            ->avg('point');
    }

    /**
     * Bu fonksiyon sorunun değerlendirme durumunu işleyip kaydedecek
     * @param double $point Puan
     * @param integer $questionId Soru Id
     * @throws Exception
     */
    private function setQuestionState($point, $questionId): void
    {
        // TODO Değerlendirici sayısı 2 den fazla ve ortalama 3.5 i geçtiği anda değerlendirme kapatılabilir.
        $question = Question::find($questionId);
        if ($point > 0 && $point < 2.5) {
            $question->status = Question::NOT_MUST_ASKED;
        } else if ($point >= 2.5 && $point < 3.5) {
            $question->status = Question::NEED_REVISION;
        } else if ($point >= 3.5) {
            $question->status = Question::APPROVED;
        } else {
            $question->status = Question::WAITING_FOR_ACTION;
        }
        try {
            DB::beginTransaction();
            $question->save();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param $questionId
     * @param $code
     * @throws Exception
     */
    public function setQuestionStatusIfRequired($questionId, $code): void
    {
        if ($this->checkQuestionEval($questionId, $code)) {
            $this->setQuestionState($this->calculateQuestionEval($questionId, $code), $questionId);
        }
    }
}