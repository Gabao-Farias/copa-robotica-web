<?php

namespace App\Events;

use App\Batalha;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EndBatalhaEvent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $batalha;
    public $vencedorBatalha;
    public $vencedorSorteado;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Batalha $batalha, $vencedorBatalha, $vencedorSorteado)
    {
        $this->batalha = $batalha;
        $this->vencedorBatalha = $vencedorBatalha;
        $this->vencedorSorteado = $vencedorSorteado;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('batalha.'.$this->batalha->id);
    }
}
