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

namespace App\Events;

use App\Models\QuestionEvalRequest;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class QuestionEvalCalculateRequired
{
//    use Dispatchable, InteractsWithSockets, SerializesModels;
    use Dispatchable, SerializesModels;
    /**
     * @var QuestionEvalRequest
     */
    private $request;

    /**
     * Create a new event instance.
     *
     * @param QuestionEvalRequest $request
     */
    public function __construct(QuestionEvalRequest $request)
    {
        $this->request = $request;
    }

    public function getRequest(): QuestionEvalRequest
    {
        return $this->request;
    }

//    /**
//     * Get the channels the event should broadcast on.
//     *
//     * @return \Illuminate\Broadcasting\Channel|array
//     */
//    public function broadcastOn()
//    {
//        return new PrivateChannel('channel-name');
//    }
}
