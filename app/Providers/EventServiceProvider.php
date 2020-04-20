<?php

namespace App\Providers;

use App\Events\NewEvalReqEvent;
use App\Events\QuestionEvalCalculateRequired;
use App\Listeners\NewEvalReqListener;
use App\Listeners\NewUserReqListener;
use App\Listeners\QuestionEvaulationListener;
use App\Listeners\ResetPasswordListener;
use App\Models\QuestionEvalRequest;
use App\Models\QuestionsEvaluation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\ResetPasswordEvent;
use App\Events\NewUserReqReceived;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        NewUserReqReceived::class => [
            NewUserReqListener::class,
        ],
        ResetPasswordEvent::class => [
            ResetPasswordListener::class,
        ],
        QuestionEvalCalculateRequired::class => [
            QuestionEvaulationListener::class
        ],
        NewEvalReqEvent::class => [
            NewEvalReqListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
