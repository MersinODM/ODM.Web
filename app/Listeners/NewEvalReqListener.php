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

use App\Events\NewEvalReqEvent;
use App\Models\Branch;
use App\Models\Setting;
use App\User;
use Illuminate\Support\Facades\Mail;

class NewEvalReqListener
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
