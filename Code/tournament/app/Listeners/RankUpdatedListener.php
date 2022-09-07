<?php

namespace App\Listeners;

use App\Events\RankUpdatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RankUpdatedListener
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
     * @param  RankUpdatedEvent  $event
     * @return void
     */
    public function handle(RankUpdatedEvent $event)
    {
        //
    }
}
