<?php

namespace App\Events;

use App\Equipe;
use App\PontosRound;
use App\Round;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class AttackEvent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $round;
    public $equipe;
    public $ponto;
    public $equipePontos;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Round $round, Equipe $equipe, Equipe $equipePontos, PontosRound $ponto)
    {
        $this->round = $round;
        $this->equipe = $equipe;
        $this->ponto = $ponto;
        $this->equipePontos = $equipePontos;
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
