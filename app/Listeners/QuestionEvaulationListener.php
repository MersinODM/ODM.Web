<?php
/*
 * ODM.Web  https://github.com/electropsycho/ODM.Web
 * Copyright (C) 2020 Hakan GÜLEN
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/
 */

namespace App\Listeners;

use App\Events\QuestionEvalCalculateRequired;
use App\Logic\Question\EngineConstants;
use App\Logic\Question\QuestionEvalEngine;
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
    public function handle(QuestionEvalCalculateRequired $event): void
    {
        try {
            $qer = $event->getRequest();
            QuestionEvalEngine::getInstance()
                ->setQuestionId($qer->question_id)
                ->setCode($qer->code)
                ->setCalculationType(EngineConstants::AUTOMATIC)
                ->calculate();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            // throw $exception;
        }
    }
}
