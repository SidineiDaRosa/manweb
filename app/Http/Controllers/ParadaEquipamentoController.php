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

class ParadaEquipamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $paradas = MachineDowntime::all();
        $equipamentos = Equipamento::where('estado_do_ativo', 'ativado')->get();
        $ordens_servicos = OrdemServico::where('situacao', '=', ['aberto', 'em andamento'])->get();
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
        // Validação dos dados enviados
        $validator = Validator::make($request->all(), [
            'equipment_id'      => 'required|exists:equipamentos,id',
            'ordem_servico_id'  => 'required|exists:ordens_servicos,id',
            'started_at'        => 'required|date',
            //'falha_id'          => 'required|exists:falhas,id',
            'reason'            => 'nullable|string|max:1000',
        ]);


        // Criar a parada no banco
        MachineDowntime::create([
            'equipment_id'     => $request->equipment_id,
            'ordem_servico_id' => $request->ordem_servico_id,
            'started_at'       => $request->started_at,
            //'falha_id'         => $request->falha_id,
            'reason'           => $request->reason,
        ]);

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
     */
    public function update(Request $request, $id)
    {
      
        // Busca a parada pelo ID
        $parada = MachineDowntime::findOrFail($id);

        // Validação dos dados enviados
        $validator = Validator::make($request->all(), [
            'equipment_id'      => 'required|exists:equipamentos,id',
            'ordem_servico_id'  => 'required|exists:ordens_servicos,id',
            'started_at'        => 'required|date',
            'ended_at'          => 'nullable|date|after_or_equal:started_at',
            //'failure_id'          => 'required|exists:falhas,id',
            'reason'            => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Atualiza os dados
        $parada->update([
            'equipment_id'     => $request->equipment_id,
            'ordem_servico_id' => $request->ordem_servico_id,
            'started_at'       => $request->started_at,
            'ended_at'         => $request->ended_at,
            'failure_id'         => $request->falha_id,
            'reason'           => $request->reason,
        ]);

        return redirect()->back()->with('success', 'Parada atualizada com sucesso!');
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
}
