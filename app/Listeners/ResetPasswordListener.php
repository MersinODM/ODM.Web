<?php

namespace App\Listeners;

use App\Events\ResetPasswordEvent;
use App\Models\Setting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class ResetPasswordListener
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
   * @param ResetPasswordEvent $event
   * @return void
   */
  public function handle(ResetPasswordEvent $event)
  {
    $user = $event->getUser();
    $setting = Setting::first();
    $token = app('auth.password.broker')->createToken($user);
    Mail::send("mails.ResetPassword", [
      'setting' => $setting,
      "user" => $user,
      'token' => $token
    ],
      function ($m) use ($setting, $user) {
      $m->from($setting->email, $setting->inst_name);
      $m->to($user->email, $user->full_name)->subject('Şifrenizi oluşturabilirsiniz');
    });
  }
}
