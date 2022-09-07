<?php

namespace App\Listeners;

use App\Events\EndRoundEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EndRoundListener
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
     * @param  FimRoundEvent  $event
     * @return void
     */
    public function handle(EndRoundEvent $event)
    {
        //
    }
}
