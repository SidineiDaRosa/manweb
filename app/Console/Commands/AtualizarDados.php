<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ControlPanelController;
use Illuminate\Http\Request;

class AtualizarControlPanel extends Command
{
    protected $signature = 'atualizar:controlpanel';
    protected $description = 'Atualiza o Control Panel a cada 1 minuto';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $request = new Request();
        $controller = new ControlPanelController();
        $controller->index($request);

        $this->info('Control Panel atualizado com sucesso!');
    }
}
