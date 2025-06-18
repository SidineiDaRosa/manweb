<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\PecasEquipamentos;
use Carbon\Carbon;

class UpdateLoop extends Command
{
    // Nome do comando para terminal
    protected $signature = 'update:loop';

    // Descrição do comando
    protected $description = 'Executa um processo em loop com intervalo e controle externo';

    public function handle()
    {
        set_time_limit(0);
        $this->info('Loop iniciado…');

        while (true) {
            // Se desativado, dorme e continua
            if (!Cache::get('update_loop_active', false)) {
                sleep(10);
                continue;
            }

            // Atualização
            Log::info('Atualização automática às ' . now());
            $this->info('Atualizado às ' . now());

            PecasEquipamentos::chunk(1000, function ($pecas) {
                foreach ($pecas as $p) {
                    $dataSub    = $p->data_substituicao;
                    $intervalo  = $p->intervalo_manutencao;

                    if ($dataSub && $intervalo && is_numeric($intervalo)) {
                        try {
                            $diferenca = Carbon::now()->diffInHours(Carbon::parse($dataSub));
                            $p->horas_proxima_manutencao = $intervalo - $diferenca;
                            $p->save();
                        } catch (\Throwable $e) {
                            Log::error('Erro no cálculo de manutenção: ' . $e->getMessage());
                        }
                    }
                }
            });

            sleep(60); // pausa entre execuções
        }
    }
}
