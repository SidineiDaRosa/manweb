<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Equipamento;
use App\Models\PecasEquipamentos;
use App\Models\OrdemServico;
use App\Models\Categoria;

class PecaEquipamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        date_default_timezone_set('America/Sao_Paulo'); //define a data e hora DE SÃO PAULO
        $today = date("Y-m-d"); //data de hoje
        $timeNew = date('H:i:s');
        $chek_list = $request->get('chek_list');
        $peca_equip_id = $request->get('peca_equip_id');
        $categoria = $request->get('categoria');
        $data_proxima = $request->get('data_proxima_manutencao');
        $horas_proxima = $request->get('horas_proxima_manutencao');
        $opcao = $request->get('opcao');
        $categorias = Categoria::all();
        // $equipamento_id = $equipamento->get('equipamento');
        $equipamentos = Equipamento::all();
        if ($chek_list == 1) {
            $pecasEquip = PecasEquipamentos::where('id', $peca_equip_id)->get();
            return view('app.peca_equipamento.chek_list', ['pecas_equipamento' => $pecasEquip, 'equipamentos' => $equipamentos, 'categorias' => $categorias]);
        }
        if (!isset($categoria)) {
            $pecasEquip = PecasEquipamentos::where('tipo_componente', 'Chek-List')->where('horas_proxima_manutencao', '<=', 3000)->orderby('horas_proxima_manutencao')->get();
            return view('app.peca_equipamento.index', ['pecas_equipamento' => $pecasEquip, 'equipamentos' => $equipamentos, 'categorias' => $categorias]);
        } else {
            switch ($opcao) {
                case 1:
                    $pecasEquip = PecasEquipamentos::where('tipo_componente', $categoria)->where('data_proxima_manutencao', '<=', $data_proxima)->orderby('horas_proxima_manutencao')->get();
                    return view('app.peca_equipamento.index', ['pecas_equipamento' => $pecasEquip, 'equipamentos' => $equipamentos, 'categorias' => $categorias]);
                    break;
                case 2:
                    $pecasEquip = PecasEquipamentos::where('tipo_componente', $categoria)->where('horas_proxima_manutencao', '<=', $horas_proxima)->orderby('horas_proxima_manutencao')->get();
                    return view('app.peca_equipamento.index', ['pecas_equipamento' => $pecasEquip, 'equipamentos' => $equipamentos, 'categorias' => $categorias]);
                    break;
            }
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $equipamento_id)
    {
        $tipoFiltro = $equipamento_id->get('tipofiltro');
        $nome_produto_like = $equipamento_id->get('produto');
        $categoria_id = $equipamento_id->get('categoria_id');
        //
        $categorias = Categoria::all();
        $equipamentoId = $equipamento_id->get('equipamento');
        if ($tipoFiltro >= 1) {
            //Verifica as condiçoes para filtrar os produtos
            //$produtos = Produto::where('id', $nome_produto_like )->get();
            $produtos = Produto::where('nome', 'like', $nome_produto_like . '%')->get();
        } else {
            $produtos = Produto::where('id', 0)->get();
        }
        $equipamento = Equipamento::where('id',  $equipamentoId)->get();
        return view('app.peca_equipamento.create', [
            'produtos' => $produtos,
            'equipamento' => $equipamento,
            'categorias' => $categorias,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Verificar se um registro com os mesmos atributos já existe
        $existingRecord = PecasEquipamentos::where('descricao', $request->input('equipamento'))
            ->where('produto_id')
            // Adicione outras condições conforme necessário
            ->first();

        if ($existingRecord) {
            // Registro duplicado encontrado, você pode retornar uma mensagem de erro ou redirecionar o usuário
            return redirect()->back()->with('error', 'Registro já existe.');
        }

        // Se não houver duplicatas, crie o novo registro
        PecasEquipamentos::create($request->all());

        $equipamento_id = $request->get('equipamento');
        $equipamento = Equipamento::where('id', $equipamento_id)->first(); // Obter o equipamento com o ID especificado

        $json = json_encode($equipamento); // Converter o objeto em JSON

        $equipamento_array = json_decode($json, true); // Decodificar o JSON para um array associativo

        //--------------------
        $pecasEquip = PecasEquipamentos::where('equipamento',  $equipamento_id)->where('status', 'ativado')->orderby('horas_proxima_manutencao')->get();
        $ordens_servicos = OrdemServico::where('equipamento_id',  $equipamento_id)->where('situacao', 'aberto')->orderby('data_inicio')->orderby('hora_inicio')->get();
        $ordens_servicos_1 = OrdemServico::where('equipamento_id',  $equipamento_id)->where('situacao', 'em andamento')->orderby('data_inicio')->orderby('hora_inicio')->get();

        return view('app.equipamento.show', [
            'equipamento' => $equipamento,
            'pecas_equipamento' => $pecasEquip,
            'ordens_servicos' => $ordens_servicos,
            'ordens_servicos_1' => $ordens_servicos_1
        ]);
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
     * @param  \App\Peca_equipamento  $peca_equipamento_id
     * @return \Illuminate\Http\Response
     */
    public function edit($peca_equipamento_id)
    {
        $pecasEquip = PecasEquipamentos::where('id', $peca_equipamento_id)->get();

        foreach ($pecasEquip as $pecaEquip_for) :
            $equipamentoId = $pecaEquip_for->equipamento; // Acessando como propriedade de objeto
        //echo "Equipamento ID: " . $equipamentoId . "\n";
        endforeach;
        $categorias = Categoria::all();
        //$equipamentoId = $pecasEquip->equipamento;
        //$equipamentoId = $pecasEquip->get('equipamento');
        $equipamento = Equipamento::where('id',  $equipamentoId)->get();
        $produtos = Produto::where('id', 0)->get();
        return view('app.peca_equipamento.edit_', [
            'produtos' => $produtos,
            'equipamento' => $equipamento,
            'categorias' => $categorias,
            'pecas_equipamentos' => $pecasEquip

        ]);
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
        // echo ($request);
        $Equip_id = $request->get('equipamento'); //id do equipamento
        $descricao = $request->get('descricao');
        $produto_id = $request->get('produto_id');
        $quantidade = $request->get('quantidade');
        $data_substituicao = $request->get('data_substituicao');
        $hora_substituicao = $request->get('hora_substituicao');
        $data_proxima_manutencao = $request->get('data_proxima_manutencao');
        $horas_proxima_manutencao = $request->get('horas_proxima_manutencao');
        $horimetro = $request->get('horimetro');
        //$pecaEquip_id=$request->get('forma_medicao');
        $status = $request->get('status');
        $forma_medicao = $request->get('forma_medicao');
        $tipo_componente = $request->get('tipo_componente');
        $criticidade = $request->get('criticidade');
        // Validação dos dados vindos do formulário
        $validatedData = $request->validate([
            'equipamento' => 'required',
            'descricao' => 'required',
            'produto_id' => 'required',
            'quantidade' => 'required|numeric',
            'data_substituicao' => 'required|date',
            'hora_substituicao' => 'required',
            'data_proxima_manutencao' => 'required|date',
            'horas_proxima_manutencao' => 'required',
            'horimetro' => 'required',
            'status' => 'required',
            'forma_medicao' => 'required',
            'tipo_componente' => 'required',
            'criticidade' => 'required',
        ]);

        try {
            // Encontrar o registro pelo ID
            $pecaEquipamento = PecasEquipamentos::findOrFail($id);

            // Atualizar os campos com os dados validados
            $pecaEquipamento->update($validatedData);

            // Retornar uma resposta de sucesso
            //return response()->json(['message' => 'Registro atualizado com sucesso', 'data' => $pecaEquipamento], 200);
            $pecasEquip = PecasEquipamentos::where('equipamento', $Equip_id )->where('status', 'ativado')->orderby('horas_proxima_manutencao')->get();
            $ordens_servicos = OrdemServico::where('equipamento_id',  $Equip_id )->where('situacao', 'aberto')->orderby('data_inicio')->orderby('hora_inicio')->get();
            $ordens_servicos_1 = OrdemServico::where('equipamento_id',  $Equip_id )->where('situacao', 'em andamento')->orderby('data_inicio')->orderby('hora_inicio')->get();
            $equipamento = Equipamento::where('id', $Equip_id )->first(); // Obter o equipamento com o ID especificado
            return view('app.equipamento.show', [
                'equipamento' => $equipamento,
                'pecas_equipamento' => $pecasEquip,
                'ordens_servicos' => $ordens_servicos,
                'ordens_servicos_1' => $ordens_servicos_1
            ]);
        } catch (\Exception $e) {
            // Em caso de erro, trate-o adequadamente (log, mensagem de erro, etc.)
            return response()->json(['message' => 'Erro ao atualizar registro', 'error' => $e->getMessage()], 500);
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
}
