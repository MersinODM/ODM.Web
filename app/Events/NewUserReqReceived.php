<?php

namespace App\Events;

use App\Events\Event;
use App\Models\NewUserReq;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewUserReqReceived extends Event
{
  use SerializesModels;
  /**
   * @var NewUserReq
   */
  private $userReq;

    /**
     * Create a new event instance.
     *
     * @param User $userReq
     * @param $token
     */
  public function __construct(User $userReq)
  {
    $this->userReq = $userReq;
  }

  /**
   * Get the channels the event should be broadcast on.
   *
   * @return array
   */
  public function broadcastOn()
  {
    return [];
  }

  public function getUserReq()
  {
    return $this->userReq;
  }

}
