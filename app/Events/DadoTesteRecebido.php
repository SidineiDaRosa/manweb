<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // IMPORTANTE: Envia na hora sem fila
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// Mudamos de "ShouldBroadcast" para "ShouldBroadcastNow" para o dado ir instantaneamente
class DadoTesteRecebido implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // Variável pública que armazena o valor do ESP32. O Laravel envia ela automaticamente para o WebSocket.
    public $dado;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($dado)
    {
        $this->dado = $dado; // Salva o dado recebido do Controller aqui dentro
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // Alterado de PrivateChannel para Channel (público) para a View conseguir ler sem login
        return new Channel('canal-telemetria');
    }

    /**
     * Define o nome do evento para o JavaScript escutar
     */
    public function broadcastAs()
    {
        return 'sensor.atualizado';
    }
}
