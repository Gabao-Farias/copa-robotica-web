<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\PlayRoundEvent' => [
            'App\Listeners\PlayRoundListener',
        ],
        'App\Events\PauseRoundEvent' => [
            'App\Listeners\PauseRoundListener',
        ],
        'App\Events\EndRoundEvent' => [
            'App\Listeners\EndRoundListener',
        ],
        'App\Events\AttackEvent' => [
            'App\Listeners\AttackListener',
        ],
        'App\Events\NextRoundEvent' => [
            'App\Listeners\NextRoundListener',
        ],
        'App\Events\EndBatalhaEvent' => [
            'App\Listeners\EndBatalhaListener',
        ],
        'App\Events\RemoverPontoEvent' => [
            'App\Listeners\RemoverPontoListener',
        ],
        'App\Events\RingueRoundEvent' => [
            'App\Listeners\RingueRoundListener',
        ],
        'App\Events\RankUpdatedEvent' => [
            'App\Listeners\RankUpdatedListener',
        ],
        'App\Events\EndFaseInicialEvent' => [
            'App\Listeners\EndFaseInicialListener',
        ],
        'App\Events\UpdateChaveamentoEvent' => [
            'App\Listeners\UpdateChaveamentoListener',
        ],
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
