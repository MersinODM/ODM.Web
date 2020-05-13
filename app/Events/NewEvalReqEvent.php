<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class NewEvalReqEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $branchId;
    private $userId;

    /**
     * Create a new event instance.
     *
     * @param $branchId
     * @param $userId
     */
    public function __construct($branchId, $userId) {
        $this->branchId = $branchId;
        $this->userId = $userId;
    }

    public function getBranchId() {
        return $this->branchId;
    }

    public function getUserId() {
        return $this->userId;
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
