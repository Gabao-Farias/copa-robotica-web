<?php

namespace App\Listeners;

use App\Events\RingueRoundEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RingueRoundListener
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
     * @param  RingueRoundEvent  $event
     * @return void
     */
    public function handle(RingueRoundEvent $event)
    {
        //
    }
}
