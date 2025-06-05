<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PecasEquipamentos;
use App\Models\Equipamento;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    public function index()
    {
        $alarmes = PecasEquipamentos::with('equipamento_id')  // Certifique que a relação está com o nome correto (não 'equipamento_id')
            ->where('status', 'Ativado')
            ->where('criticidade', '!=', 'baixa')
            ->where('horas_proxima_manutencao', '<=', 0)
            ->get();

        // Agrupa pelo nome do equipamento (relacionamento)
        $agrupados = $alarmes->filter(function ($peca) {
            return !empty($peca->descricao);
        })->groupBy('equipamento_id.nome');

        return view('app.notificacoes.index', ['agrupados' => $agrupados]);
    }
}
