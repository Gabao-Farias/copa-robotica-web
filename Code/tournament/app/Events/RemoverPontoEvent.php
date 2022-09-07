<?php

namespace App\Events;

use App\PontosRound;
use App\Round;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RemoverPontoEvent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $round;
    public $ponto;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Round $round, PontosRound $ponto)
    {
        $this->round = $round;
        $this->ponto = $ponto;
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
