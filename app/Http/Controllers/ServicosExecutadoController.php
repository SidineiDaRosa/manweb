<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use App\Models\Equipamento;
use App\Models\OrdemServico;
use App\Models\Funcionario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\Query\OrExpr;
use App\Models\Servicos_executado;
use Illuminate\Http\Request;
use PhpOption\Option;

class ServicosExecutadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function index(Request $request)
    public function index(Request $request)
    {
        //
        $ordem_servico_id = $request->get("ordem_servico");
        $funcionarios = Funcionario::all();
        $ordem_servico = OrdemServico::all();
        // return view('app.marca.index',['marcas'=> $marcas]);
        return view('app.servicos_executado.create', ['ordem_servico' => $ordem_servico, 'funcionarios' => $funcionarios, 'ordem_servico_id' => $ordem_servico_id]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $ordem_servico_id = $request->get("ordem_servico");
        $funcionarios = Funcionario::where('funcao', 'like', '%eletricista%')
            ->orWhere('funcao', 'like', '%mecanico%')
            ->orWhere('funcao', 'like', '%pedreiro%')
            ->orWhere('funcao', 'like', '%auxiliar%')
            ->orWhere('funcao', 'like', '%Supervisor de Manu%')
            ->get();
        $ordem_servico = OrdemServico::all();
        // return view('app.marca.index',['marcas'=> $marcas]);
        return view('app.servicos_executado.create', ['ordem_servico' => $ordem_servico, 'funcionarios' => $funcionarios, 'ordem_servico_id' => $ordem_servico_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $option = $request->get('option');

        // Verifica se já existe um registro com os mesmos dados
        $existing = Servicos_executado::where([
            'ordem_servico_id' => $request->get("ordem_servico_id"),
            'descricao' => $request->get("descricao"),
            // Adicione aqui outras condições de verificação, se necessário
        ])->exists();

        if ($existing) {
            // Se já existir, redirecione de volta com uma mensagem de erro
            return redirect()->back()->with('error', 'Este serviço já foi cadastrado.');
        }
        // Se não existir, crie o novo registro
        Servicos_executado::create($request->all()); // Grava o registro com a descrição do serviço requerido.
        $id = $request->get("ordem_servico_id");
        $ordem_servico = OrdemServico::findOrFail($id);
        $servicos_executado = Servicos_executado::where('ordem_servico_id', $id)->get();
        $total_hs_os = Servicos_executado::where('ordem_servico_id', $id)->sum('subtotal');

        $funcionarios = Funcionario::all();
        $aprs = collect(); // collection vazia
        if ($option == 1) {
            return view('app.ordem_servico.show', [
                'ordem_servico' => $ordem_servico,
                'servicos_executado' => $servicos_executado,
                'funcionarios' => $funcionarios,
                'total_hs_os' => $total_hs_os,
                'aprs' => $aprs // envia a var aprs vazia
            ]);
        };
        if ($option == 2) {
            return redirect()->route('pedido-saida.create', ['ordem_servico' => $ordem_servico->id]);
        };
        if ($option == 3) {
            return redirect()->route('pedido-saida.index', ['ordem_servico' => $ordem_servico->id, 'tipofiltro' => 4]);
        };
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
        echo ('update');
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
}
