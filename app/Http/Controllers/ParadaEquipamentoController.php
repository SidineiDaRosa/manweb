<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MachineDowntime;
use App\Models\Produto;
use App\Models\Equipamento;
use App\Models\OrdemProducao;
use App\Models\OrdemServico;
use App\Models\RecursosProducao;
use App\Models\MachineFailure;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ParadaEquipamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        // Query base
        $query = MachineDowntime::query();

        // 🔎 Filtro por equipamento
        if ($request->filled('equipamento_id')) {
            $query->where('equipment_id', $request->equipamento_id);
        }

        // 🔎 Filtro por descrição
        if ($request->filled('descricao')) {
            $query->where('reason', 'like', '%' . $request->descricao . '%');
        }

        // 🔎 Filtro por status
        if ($request->filled('status')) {
            if ($request->status === 'ativo') {
                $query->whereNull('ended_at');
            } elseif ($request->status === 'finalizado') {
                $query->whereNotNull('ended_at');
            }
        }

        // 🔎 Filtro por período
        if ($request->filled('data_inicio')) {
            $query->where('started_at', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->where('started_at', '<=', $request->data_fim);
        }

        // Ordenação
        $paradas = $query->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Equipamentos ativos
        $equipamentos = Equipamento::where('estado_do_ativo', 'ativado')->get();

        // Ordens abertas ou em andamento
        $ordens_servicos = OrdemServico::whereIn('situacao', ['aberto', 'em andamento'])->get();

        $flaiures = MachineFailure::all();

        return view('app.paradas_de_maquinas.index', [
            'paradas' => $paradas,
            'equipamentos' => $equipamentos,
            'ordens_servicos' => $ordens_servicos,
            'flaiures' => $flaiures
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // Validação
        $validator = Validator::make($request->all(), [
            'equipment_id'      => 'required|exists:equipamentos,id',
            'ordem_servico_id'  => 'required|exists:ordens_servicos,id',
            'started_at'        => 'required|date',
            'falha_id'          => 'required|exists:falhas,id',
            'reason'            => 'nullable|string|max:1000',
        ]);



        // Criar a parada
        MachineDowntime::create([
            'equipment_id'     => $request->equipment_id,
            'ordem_servico_id' => $request->ordem_servico_id,
            'started_at'       => $request->started_at,
            'failure_id'       => $request->falha_id,
            'reason'           => $request->reason,
            'user_id'          => auth()->id(), // 👈 quem iniciou
        ]);
        //  atualiza a os  para parada de máquina

        if ($request->falha_id == 2) {
            $agora = Carbon::now('America/Sao_Paulo');
            $data = $agora->toDateString();     // Y-m-d
            $hora = $agora->format('H:i');    // 14:35
            $ordem_servico = OrdemServico::find(2399);
            $ordem_servico->update([
                // 'data_emissao' => 
                //'hora_emissao' =>
                'data_inicio' => $data,
                // 'hora_inicio' =>
                'data_fim' => $data,
                //'hora_fim' => 
                'equipamento_id' => $request->equipment_id, // ajuste conforme seus campos
                //'emissor' => 
                //'responsavel' => 
                'descricao' => 'Foi gerado uma parada as ' .    $hora . ', e definido como sendo Elétrica ou mecânica, favor verificar.',
                //'status_servicos' => 
                // 'especialidade_do_servico' =>
                // 'natureza_do_servico' =>
                // 'gravidade' => 
                // 'urgencia' => 
                // 'tendencia' => 
                'situacao' => 'aberto',
                // 'link_foto' => 
                // 'signature_receptor' => 
                // 'anexo' => 
                //'projeto_id' => 
                //'check' => false,
                'alarm' => 0,
            ]);

            $ordem_servico = OrdemServico::find(2399);
            $ordem_servico->check =0;
            $ordem_servico->save();
        }

        return redirect()->back()->with('success', 'Parada iniciada com sucesso!');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ public function update(Request $request, $id)
    {
        $parada = MachineDowntime::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'equipment_id'      => 'required|exists:equipamentos,id',
            //'ordem_servico_id'  => 'required|exists:ordens_servicos,id',
            'started_at'        => 'required|date',
            'ended_at'          => 'nullable|date|after_or_equal:started_at',
            'reason'            => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dados = [
            'equipment_id'     => $request->equipment_id,
            'ordem_servico_id' => $request->ordem_servico_id,
            'started_at'       => $request->started_at,
            'ended_at'         => $request->ended_at,
            'failure_id'       => $request->falha_id,
            'reason'           => $request->reason,
            'ended_user_id'    => auth()->id(), // 👈 quem finalizou
        ];

        // 🔥 Se estiver encerrando agora
        if ($request->filled('ended_at') && is_null($parada->ended_at)) {
            $dados['ended_user_id'] = auth()->id();
        }

        switch ($request->falha_id) {
            case 2:
                if ($request->password == 1234) {
                    $parada->update($dados);
                    //fecha a os
                    $ordem_servico = OrdemServico::find(2399);
                    $ordem_servico->check = 1;
                    $ordem_servico->alarm = 1;
                    $ordem_servico->situacao = 'fechado';
                    $ordem_servico->save();
                    return redirect()->back()->with('success', 'Parada Finalizada!');
                } else {
                    return redirect()->back()->with('error', 'Senha da manutenção não cofere!');
                }
                break;

            default: // Executa para qualquer ID que não seja 2
                if ($request->password == 12345) {
                    $parada->update($dados);
                    //fecha a os
                    $ordem_servico = OrdemServico::find(2399);
                    $ordem_servico->check = 1;
                    $ordem_servico->alarm = 1;
                    $ordem_servico->situacao = 'fechado';
                    $ordem_servico->save();
                    return redirect()->back()->with('success', 'Parada Finalizada!');
                } else {
                    return redirect()->back()->with('error', 'Senha Geral Produção não confere!');
                }
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function kpi_downtime() {}
}
