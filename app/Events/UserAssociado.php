<?php

namespace App\Events;

use App\Models\Pedido;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserAssociado implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public array $dados;

    public function __construct(array $dados)
    {
        $this->dados = $dados;
    }
    
    public function broadcastOn()
    {
        return new Channel('canal-pedidos');
    }

    public function broadcastAs()
    {
        return 'evento-userAssociado';
    }

    public function broadcastWith()
    {
        return $this->dados;
    }
}
