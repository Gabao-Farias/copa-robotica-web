<?php

namespace App\Events;

use App\Ringue;
use App\Round;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RingueRoundEvent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $ringue;
    public $round;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Ringue $ringue, Round $round)
    {
        $this->ringue = $ringue;
        $this->round = $round;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('ringue.'.$this->ringue->id);
    }
}
