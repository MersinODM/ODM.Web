<?php
/**
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup
 *  geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *   Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers\Api\Question;


use App\Http\Controllers\ApiController;
use App\Http\Controllers\ResponseHelper;
use App\Models\Question;
use App\Models\QuestionDeleteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuestionDeleteRequestController extends ApiController
{
    public function createDeleteRequest(Request $request) {
        $validationResult = $this->apiValidator($request, [
            'question_id' => 'required',
            'comment' => 'required'
        ]);
        if ($validationResult) {
            return response()->json($validationResult,422);
        }
        $data = $request->only("question_id", "comment");
        try {
            DB::beginTransaction();
            $qdr = new QuestionDeleteRequest($data);
            $qdr->creator_id = Auth::id();
            $qdr->save();
            DB::commit();
            return response()->json([ResponseHelper::MESSAGE => "Soru silme isteği kaydı alınmıştır."]);
        }
        catch (\Exception $exception){
            DB::rollBack();
            return response()->json($this->apiException($exception), 500);
        }
    }

    public function approveDeleteRequest($id) {
        $qdr = QuestionDeleteRequest::findOrFail($id);
        $question = Question::findOrFail($qdr->question_id);
        try {
            DB::beginTransaction();
            $question->delete();
            Storage::delete($question->content_url);
            DB::commit();
            return response()->json([ResponseHelper::MESSAGE => "Soru silme işlemi başarılı!"]);
        }
        catch (\Exception $exception) {
            DB::rollBack();
            return response()->json($this->apiException($exception), 500);
        }
    }

    public function getDeleteRequests() {

    }
}