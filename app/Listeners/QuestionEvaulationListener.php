<?php
/**
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *   Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */

namespace App\Listeners;

use App\Events\QuestionEvalCalculateRequired;
use App\Models\Question;
use App\Models\QuestionEvalRequest;
use App\Traits\QuestionEvalTraits;
use Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionEvaulationListener
{
    use QuestionEvalTraits;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param QuestionEvalCalculateRequired $event
     * @return void
     * @throws Exception
     */
    public function handle(QuestionEvalCalculateRequired $event)
    {
        try {
            $qer = $event->getRequest();
            $this->setQuestionStatusIfRequired($qer->question_id, $qer->code);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            // throw $exception;
        }
    }
}
