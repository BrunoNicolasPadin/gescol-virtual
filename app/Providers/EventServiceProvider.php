<?php

namespace App\Providers;

use App\Models\Evaluaciones\Evaluacion;
use App\Models\Instituciones\Institucion;
use App\Observers\Evaluaciones\EvaluacionObserver;
use App\Observers\Instituciones\InstitucionObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Evaluacion::observe(EvaluacionObserver::class);
        Institucion::observe(InstitucionObserver::class);
    }
}
