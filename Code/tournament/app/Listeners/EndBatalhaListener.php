<?php

namespace App\Listeners;

use App\Events\EndBatalhaEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EndBatalhaListener
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
     * @param  EndBattleEvent  $event
     * @return void
     */
    public function handle(EndBatalhaEvent $event)
    {
        //
    }
}
