<?php

namespace App\Listeners;

use App\Events\AttackEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AttackListener
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
     * @param  AttackEvent  $event
     * @return void
     */
    public function handle(AttackEvent $event)
    {
        //
    }
}
