<?php
///*
// * ODM.Web  https://github.com/electropsycho/ODM.Web
// * Copyright (C) 2020 Hakan GÜLEN
// *
// * This program is free software: you can redistribute it and/or modify
// * it under the terms of the GNU General Public License as published by
// * the Free Software Foundation, either version 3 of the License, or
// * (at your option) any later version.
// *
// * This program is distributed in the hope that it will be useful,
// * but WITHOUT ANY WARRANTY; without even the implied warranty of
// * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// * GNU General Public License for more details.
// *
// * You should have received a copy of the GNU General Public License
// * along with this program.  If not, see http://www.gnu.org/licenses/
// */
//
//namespace App\Traits;
//
//
//use App\Models\Question;
//use App\Models\QuestionEvalRequest;
//use App\Models\Setting;
//use Exception;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Log;
//
///**
// * Bu trait soru değerlendirme fonksiyonlarını içerir
// * Trait QuestionEvalTraits
// * @package App\Traits
// */
//trait QuestionEvalTraits
//{
//
//    private $code;
//    private $questionId;
//
//    /**
//     * Bu fonksiyon sorunun değerlendirme puanını hesaplayacak
//     * @return mixed
//     */
//    private function calculateQuestionEval()
//    {
//        return QuestionEvalRequest::where('question_id', $this->questionId)
//            ->where('code', $this->code)
//            ->whereNotNull('point')
//            ->avg('point');
//    }
//
//    /**
//     * Bu fonksiyon sorunun değerlendirme durumunu işleyip kaydedecek
//     * @throws Exception
//     */
//    private function setQuestionState(): bool
//    {
//        $point = $this->calculateQuestionEval();
//        $question = Question::find($this->questionId);
//        if ($point > 0 && $point < 2.5) {
//            $question->status = Question::NOT_MUST_ASKED;
//        } else if ($point >= 2.5 && $point < 3.5) {
//            $question->status = Question::NEED_REVISION;
//        } else if ($point >= 3.5) {
//            $question->status = Question::APPROVED;
//        } else {
//            $question->status = Question::WAITING_FOR_ACTION;
//        }
//        try {
//            DB::beginTransaction();
//            $question->save();
//            //Burada değerlendirme bittikten sonra tüm istekler kapatılıyor
//            QuestionEvalRequest::where('question_id', $this->questionId)
//                ->where('code', $this->code)
//                ->update(['is_open' => 0]);
//            DB::commit();
//            return true;
//        } catch (Exception $exception) {
//            DB::rollBack();
//            Log::error($exception->getMessage());
//            return false;
//        }
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getSavedEvalCount()
//    {
//        return QuestionEvalRequest::where('question_id', $this->questionId)
//            ->where('code', $this->code)
//            ->count();
//    }
//
//    /**
//     * Bu fonksiyon yeterli değerlendirme sayısına uluaşılıp ulaşılmadığını kontrol edecek
//     * @return bool
//     */
//    private function checkQuestionEvalForAutomaticCalculation(): bool
//    {
//        //Kayıtlı değerlendirme sayısı puanlanmış değerlendirme sayısına eşit mi?
//        $savedEvalCount = $this->getSavedEvalCount();
//        $setting = Setting::select('min_elector_count', 'max_elector_count')->first();
//        if($savedEvalCount >= $setting->min_elector_count) {
//            return QuestionEvalRequest::where('question_id', $this->questionId)
//                    ->where('code', $this->code)
//                    ->whereNotNull('point')
//                    ->count() === $savedEvalCount;
//        }
//        return false;
//    }
//
//    /**
//     * @throws Exception
//     */
//    private function setQuestionStatusIfRequired(): bool
//    {
//        if ($this->checkQuestionEvalForAutomaticCalculation()) {
//            return $this->setQuestionState();
//        }
//        return false;
//    }
//
//    /**
//     * Otomatik hesaplama fonksiyonu
//     * @param $questionId
//     * @param $code
//     * @return bool
//     */
//    public function calculateAutomatic($questionId, $code): bool
//    {
//         $this->code = $code;
//         $this->questionId = $questionId;
//        try {
//            return $this->setQuestionStatusIfRequired();
//        } catch (Exception $e) {
//            Log::error($e->getMessage());
//            return false;
//        }
//    }
//
//    /**
//     * Manuel hesaplama için gereken şartların sağlanıp sağlanmadığını kontrol eden
//     * fonksiyon
//     * @param $minRequiredElection
//     * @return bool
//     */
//    private function checkQuestionEvalForManualCalculation($minRequiredElection): bool
//    {
//        return QuestionEvalRequest::where('question_id', $this->questionId)
//                ->where('code', $this->code)
//                ->whereNotNull('point')
//                ->count() >= $minRequiredElection;
//    }
//
//
//    /**
//     * Manuel hesaplama fonksiyonu
//     * @param $questionId
//     * @param $code
//     * @return bool
//     */
//    public function calculateManual($questionId, $code): bool
//    {
//        $this->code = $code;
//        $this->questionId = $questionId;
//        $question = Question::where('id', $this->questionId)
//            ->select('min_required_election')
//            ->first();
//        if ($this->checkQuestionEvalForManualCalculation($question->min_required_election)) {
//            try {
//                $this->setQuestionState();
//                return true;
//            } catch (Exception $e) {
//                Log::error($e->getMessage());
//                return false;
//            }
//
//        }
//        return false;
//    }
//}