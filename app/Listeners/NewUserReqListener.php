<?php

namespace App\Listeners;

use App\Events\NewUserReqReceived;
use App\Models\Setting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NewUserReqListener
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
   * @param NewUserReqReceived $event
   * @return void
   */
  public function handle(NewUserReqReceived $event)
  {
      $user = $event->getUserReq();
      $setting = Setting::first();
      Mail::send("mails.NewUserRequestReceived", ['setting' => $setting, "user" => $user],
          function ($m) use ($setting, $user) {
              $m->from($setting->email, $setting->inst_name);
              $m->to($user->email, $user->full_name)->subject('Talebinizi aldık ;-)');
          });
  }
}
