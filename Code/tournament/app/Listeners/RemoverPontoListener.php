<?php

namespace App\Listeners;

use App\Events\RemoverPontoEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemoverPontoListener
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
     * @param  RemoverPontoEvent  $event
     * @return void
     */
    public function handle(RemoverPontoEvent $event)
    {
        //
    }
}
