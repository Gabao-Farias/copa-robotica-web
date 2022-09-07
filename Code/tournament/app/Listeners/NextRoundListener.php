<?php

namespace App\Listeners;

use App\Events\NextRoundEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NextRoundListener
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
     * @param  NextRoundEvent  $event
     * @return void
     */
    public function handle(NextRoundEvent $event)
    {
        //
    }
}
