<?php

namespace App\Events;

use App\Round;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NextRoundEvent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $round;
    public $proximoRound;
    public $vencedor;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Round $round, $proximoRound, $vencedor)
    {
        $this->round = $round;
        $this->proximoRound = $proximoRound;
        $this->vencedor = $vencedor;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('round.'.$this->round->id);
    }
}
