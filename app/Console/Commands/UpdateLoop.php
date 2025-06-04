<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\PecasEquipamentos;
class UpdateLoop extends Command
{
    // Nome do comando para terminal
    protected $signature = 'update:loop';

    // Descrição do comando
    protected $description = 'Executa um processo em loop com intervalo e controle externo';

    public function handle()
    {
        $this->info('Loop de atualização iniciado...');

        while (true) {
            // Verifica no cache se ainda deve continuar
            if (!Cache::get('update_loop_active', false)) {
                $this->info('Loop interrompido pelo sistema.');
                break;
            }

            // AQUI VAI SUA LÓGICA DE ATUALIZAÇÃO
            Log::info('Atualização automática executada às ' . now());
            $this->info('Atualizado às ' . now());
            

            // Aguarda 10 segundos antes de repetir

            sleep(10);
        }
    }
}
