<?php

namespace App\Listeners;

use App\Events\PauseRoundEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PauseRoundListener
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
     * @param  PauseRoundEvent  $event
     * @return void
     */
    public function handle(PauseRoundEvent $event)
    {
        //
    }
}
