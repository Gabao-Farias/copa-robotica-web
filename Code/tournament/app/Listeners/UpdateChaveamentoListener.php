<?php

namespace App\Listeners;

use App\Events\UpdateChaveamentoEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateChaveamentoListener
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
     * @param  UpdateChaveamentoEvent  $event
     * @return void
     */
    public function handle(UpdateChaveamentoEvent $event)
    {
        //
    }
}
