<?php

namespace App\Listeners;

use App\Events\EndFaseInicialEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EndFaseInicialListener
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
     * @param  EndFaseEvent  $event
     * @return void
     */
    public function handle(EndFaseInicialEvent $event)
    {
        //
    }
}
