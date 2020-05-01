<?php

namespace App\Listeners;

use App\Events\NewEvalReqEvent;
use App\Models\Branch;
use App\Models\Setting;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NewEvalReqListener implements ShouldQueue
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
     * @param NewEvalReqEvent $event
     * @return void
     */
    public function handle(NewEvalReqEvent $event)
    {
        $branch = Branch::find($event->getBranchId());
        $user = User::find($event->getUserId());
        $setting = Setting::first();
        Mail::send("mails.NewEvalRequestReceived", [
            'setting' => $setting,
            'user' => $user,
            'branch' => $branch
        ],
            static function ($m) use ($setting, $user) {
                $m->from($setting->email, $setting->inst_name);
                $m->to($user->email, $user->full_name)->subject('Size bir sorumuz var');
            });
    }
}
