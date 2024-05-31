<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\OrdemProducao;
use App\Models\Equipamento;
use App\Models\ParadaEquipamento;
use App\Models\RecursosProducao;
use Carbon\Carbon;


class OrdemProducaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::all();
        $ordens_producoes = OrdemProducao::all();

        return view('app.ordem_producao.index', ['produtos' => $produtos, 'ordens_producoes' => $ordens_producoes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produtos = Produto::all();
        $equipamentos = Equipamento::all();
        return view('app.ordem_producao.create', ['produtos' => $produtos, 'equipamentos' => $equipamentos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produtos = Produto::all();
        $equipamentos = Equipamento::all();

        $data_inicio = $request->input('data_inicio');
        $data_fim = $request->input('data_fim');
        $hora_inicio = $request->input('hora_inicio');
        $hora_fim = $request->input('hora_fim');
        //verifica se já existe registro com data_inicio, data_fim, hora_inicio, hora_fim.
        $exists_ordem = OrdemProducao::where('data_inicio', $data_inicio)->where('data_fim', $data_fim)->where('hora_inicio', $hora_inicio)->where('hora_fim', $hora_fim)->get()->first();

        if (isset($exists_ordem)) {
            $ordem_producao = OrdemProducao::find($request->session()->get('ordem_producao'));
            return view('app.ordem_producao.create', ['produtos' => $produtos, 'equipamentos' => $equipamentos, 'ordem_producao' => $ordem_producao]);
        }
        $ordem_producao = OrdemProducao::create($request->all());
        $request->session()->put('ordem_producao', $ordem_producao->id); //cria uam session com o id da ordem de produção
        return view('app.ordem_producao.create', ['produtos' => $produtos, 'equipamentos' => $equipamentos, 'ordem_producao' => $ordem_producao]);
    }
  
    /**
     * Display the specified resource.
     * @param \App\Models\OrdemProducao $ordem_producao
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(OrdemProducao $ordem_producao)
    {

        $op_horimetro_inicial = OrdemProducao::where('equipamento_id', $ordem_producao->equipamento_id)
        ->where('id', '<', $ordem_producao->id)->orderBy('id', 'desc')->first();
        $hora_inicio=Carbon::createFromDate($ordem_producao->hora_inicio);//formata hora do carbon
        $hora_fim=Carbon::createFromDate($ordem_producao->hora_fim);//formata hora do carbon
        $hours=$hora_fim->diffInHours($hora_inicio);//recebe a diferença em horas sem minutos
        $minutes= ($hora_fim->diffInMinutes($hora_inicio))% 60;//recebe o total em minutos e pega o resto da divisão por 60
        $total_horas_equipamento=$hours . ':' . $minutes;// concatena horas e minutos com os ':'

        $total_minutos=$hora_fim->diffInMinutes($hora_inicio);
        $producao_por_hora=round($ordem_producao->quantidade_producao / $total_minutos *60);
        
        if(empty($op_horimetro_inicial)){//caso o registro seja o primeiro, pega ele mesmo como horimetro inicial
            $horimetro_inicial=$ordem_producao->horimetro_final;
        }else{
         $horimetro_inicial = $op_horimetro_inicial->horimetro_final; 
         $total_horimetro=  $ordem_producao->horimetro_final - $horimetro_inicial;
        }
        
        $paradas = ParadaEquipamento::where('ordem_producao_id', $ordem_producao->id)->get();
        $recursos_producao = RecursosProducao::where('ordem_producao_id', $ordem_producao->id)->where('horimetro_final','<>','null')->get();

        $recursos_produtos = RecursosProducao::where('ordem_producao_id', $ordem_producao->id)->where('horimetro_final','is null')->get();
        dd($recursos_produtos);

        return view(
            'app.ordem_producao.show',
            [
                'ordem_producao' => $ordem_producao, 
                'horimetro_inicial' => $horimetro_inicial,
                'paradas' => $paradas, 
                'recursos_producao' => $recursos_producao,
                'total_horimetro'=>$total_horimetro,
                'total_horas_equipamento'=> $total_horas_equipamento,
                'producao_por_hora'=>$producao_por_hora,
                'recursos_produtos'=>$recursos_produtos,
            ]
        );
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
        //
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


    public function getHorimetroInicial(Request $request){
        $equipamento_id = $request->get('equipamento_id');
        $horimetro_inicial=OrdemProducao::where('equipamento_id', $equipamento_id)->orderBy('id', 'desc')->first();
        $horimetro_inicial=$horimetro_inicial->horimetro_final;
        echo json_encode($horimetro_inicial);

    }
}
