<?php

namespace App\Http\Controllers;

use App\Models\PedidoSaida;
use App\Models\SaidaProduto;
use App\Models\Equipamento;
use Illuminate\Http\Request;

class CustosController extends Controller
{
    public function dashboard()
    {
        try {
            // Dados fictícios para o custo total mensal e anual
            $custoMensal = 5000;  // Custo total do mês atual
            $custoAnual = 60000;  // Custo total do ano atual

            // Dados fictícios de custos por projeto
            $custosPorProjeto = [
                (object)['projeto' => 'Projeto A', 'total' => 20000],
                (object)['projeto' => 'Projeto B', 'total' => 15000],
                (object)['projeto' => 'Projeto C', 'total' => 25000],
            ];

            // Variação mensal fictícia
            $custoMesPassado = 4500;  // Custo total do mês anterior
            $variacaoMensal = ($custoMensal - $custoMesPassado) / max($custoMesPassado, 1) * 100;

            // Dados fictícios para gráfico de custos mensais
            $custosMensais = [
                (object)['mes' => 1, 'total' => 4000],
                (object)['mes' => 2, 'total' => 4500],
                (object)['mes' => 3, 'total' => 5000],
                (object)['mes' => 4, 'total' => 4800],
                (object)['mes' => 5, 'total' => 5200],
                (object)['mes' => 6, 'total' => 5300],
                (object)['mes' => 7, 'total' => 5500],
                (object)['mes' => 8, 'total' => 5000],
                (object)['mes' => 9, 'total' => 5200],
                (object)['mes' => 10, 'total' => 5100],
                (object)['mes' => 11, 'total' => 5400],
                (object)['mes' => 12, 'total' => 5600],
            ];

            // Dados fictícios para custos por departamento
            $custosPorDepartamento = [
                (object)['departamento' => 'Financeiro', 'total' => 12000],
                (object)['departamento' => 'TI', 'total' => 18000],
                (object)['departamento' => 'RH', 'total' => 15000],
                (object)['departamento' => 'Marketing', 'total' => 15000],
            ];

            $saidas_produtos = SaidaProduto::all();
            // Retorna a view com os dados fictícios
            return view(
                'app.custos.dashboard',
                [
                    'custoMensal' => $custoMensal,
                    'custoAnual' => $custoAnual,
                    'custosPorProjeto' => $custosPorProjeto,
                    'variacaoMensal' => $variacaoMensal,
                    'custosMensais' => $custosMensais,
                    'custosPorDepartamento' => $custosPorDepartamento,
                    'saidas_produtos' => $saidas_produtos  // Passando a nova variável
                ]
            );
        } catch (\Exception $e) {
            // Retorna um erro caso ocorra alguma exceção
            return back()->withErrors(['message' => 'Erro ao gerar o dashboard: ' . $e->getMessage()]);
        }
    }
}
