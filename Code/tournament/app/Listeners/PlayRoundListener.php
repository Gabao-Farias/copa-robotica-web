<?php

namespace App\Listeners;

use App\Events\PlayRoundEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PlayRoundListener
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
     * @param  PlayRoundEvent  $event
     * @return void
     */
    public function handle(PlayRoundEvent $event)
    {
        //
    }
}
