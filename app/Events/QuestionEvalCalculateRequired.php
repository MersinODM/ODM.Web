<?php

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
