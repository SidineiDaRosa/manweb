<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Equipamento;
use App\Models\PecasEquipamentos;
use App\Models\OrdemServico;
use App\Models\Categoria;
use Illuminate\Support\Str; // Certifique-se de incluir a classe Str

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
            $pecasEquip = PecasEquipamentos::where('tipo_componente', 'Chek-List')->where('horas_proxima_manutencao', '<=',48)->orderby('horas_proxima_manutencao')->get();
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

    public function create(Request $request)
    {
        // Gera um token único e armazena-o na sessão
        $formToken = Str::random(40);
        session()->put('form_token', $formToken);

        // Obtém os parâmetros do request, se existirem
        $tipoFiltro = $request->input('tipofiltro', 0); // Default to 0 if not present
        $nome_produto_like = $request->input('produto', '');
        $categoria_id = $request->input('categoria_id', 0);
        $equipamentoId = $request->input('equipamento', 0);

        // Obtém todos os dados necessários
        $categorias = Categoria::all();

        if ($tipoFiltro >= 1) {
            // Filtra os produtos baseados no nome
            $produtos = Produto::where('nome', 'like', $nome_produto_like . '%')->get();
        } else {
            // Retorna uma coleção vazia ou qualquer valor apropriado
            $produtos = Produto::where('id', 0)->get();
        }

        $equipamento = Equipamento::where('id', $equipamentoId)->get();

        // Retorna a view com todos os dados necessários
        return view('app.peca_equipamento.create', [
            'formToken' => $formToken,
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
        // Validar o token do formulário
        $request->validate([
            'form_token' => 'required|in:' . session('form_token'),
            // Outras validações conforme necessário
        ]);

        // Remover o token de formulário da sessão
        session()->forget('form_token');
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

        // Obtém todos os registros de equipamentos e produtos
        $equipamentos = Equipamento::all();
        $produtos = Produto::all();

        // Obtém as ordens de serviço abertas e em andamento para o equipamento específico
        $ordens_servicos = OrdemServico::where('equipamento_id', $equipamento_id)
            ->where('situacao', 'aberto')
            ->orderBy('data_inicio', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->get();

        $ordens_servicos_1 = OrdemServico::where('equipamento_id', $equipamento_id)
            ->where('situacao', 'em andamento')
            ->orderBy('data_inicio', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->get();

        // Obtém as peças do equipamento, manutenção, check-list e lubrificação
        
        $pecasEquip = PecasEquipamentos::where('equipamento', $equipamento_id)
            ->orderBy('horas_proxima_manutencao', 'asc')
            ->where('horas_proxima_manutencao', '<=', 72)
            ->orderBy('horas_proxima_manutencao', 'asc')
            ->where('tipo_componente', 'componente')
            ->get();

        $manutencao = PecasEquipamentos::where('equipamento', $equipamento_id)
            ->where('status', 'ativado')
            ->where('horas_proxima_manutencao', '<=', 72)
            ->orderBy('horas_proxima_manutencao', 'asc')
            ->where('tipo_componente', 'manutencao')
            ->get();

        $chek_list = PecasEquipamentos::where('equipamento', $equipamento_id)
            ->where('status', 'ativado')
            ->where('horas_proxima_manutencao', '<=', 72)
            ->orderBy('horas_proxima_manutencao', 'asc')
            ->where('tipo_componente', 'Chek-List')
            ->get();

        $lubrificacao = PecasEquipamentos::where('equipamento', $equipamento_id)
            ->where('status', 'ativado')
            ->where('horas_proxima_manutencao', '<=', 72)
            ->orderBy('horas_proxima_manutencao', 'dsc')
            ->where('tipo_componente', 'lubrificacao')
            ->get();
        
        // Retorna a view com os dados coletados 
        return view('app.equipamento.show', [
            'equipamento' => $equipamento,
            'ordens_servicos' => $ordens_servicos,
            'ordens_servicos_1' => $ordens_servicos_1,
            'equipamentos' => $equipamentos,
            'produtos' => $produtos,
            'pecas_equipamento' => $pecasEquip,
            'manutencao' => $manutencao,
            'chek_list' => $chek_list,
            'lubrificacao' => $lubrificacao,
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
        $pecaEquip = PecasEquipamentos::find($peca_equipamento_id);
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
            'pecas_equipamentos' => $pecasEquip,
            'produto_nome' => $pecaEquip
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
    
        $Equip_id = $request->get('equipamento'); //id do equipamento
        $descricao = $request->get('descricao');
        $produto_id = $request->get('produto_id'); //não requerido
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
            'produto_id' => 'nullable', // Campo não é obrigatório
            'quantidade' => 'nullable|numeric', // Campo não é obrigatório, mas deve ser numérico se preenchido
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

            // Obter as ordens de serviço abertas e em andamento
            $ordens_servicos = OrdemServico::where('equipamento_id', $Equip_id)
                ->where('situacao', 'aberto')
                ->orderBy('data_inicio', 'asc')
                ->orderBy('hora_inicio', 'asc')
                ->get();

            $ordens_servicos_1 = OrdemServico::where('equipamento_id', $Equip_id)
                ->where('situacao', 'em andamento')
                ->orderBy('data_inicio', 'asc')
                ->orderBy('hora_inicio', 'asc')
                ->get();

            // Obter o equipamento especificado
            $equipamento = Equipamento::where('id', $Equip_id)->first();

            // Obter peças e equipamentos com condições específicas
            $pecasEquip = PecasEquipamentos::where('equipamento', $Equip_id)
                ->where('status', 'ativado')
                ->where('horas_proxima_manutencao', '<=', 48)
                ->where('tipo_componente', 'componente')
                ->orderBy('horas_proxima_manutencao', 'asc')
                ->get();

            $chek_list = PecasEquipamentos::where('equipamento', $Equip_id)
                ->where('status', 'ativado')
                ->where('horas_proxima_manutencao', '<=', 48)
                ->where('tipo_componente', 'Chek-List')
                ->orderBy('horas_proxima_manutencao', 'asc')
                ->get();

            $lubrificacao = PecasEquipamentos::where('equipamento', $Equip_id)
                ->where('status', 'ativado')
                ->where('horas_proxima_manutencao', '<=', 48)
                ->where('tipo_componente', 'lubrificacao')
                ->orderBy('horas_proxima_manutencao', 'asc')
                ->get();

            $manutencao = PecasEquipamentos::where('equipamento', $Equip_id)
                ->where('status', 'ativado')
                ->where('horas_proxima_manutencao', '<=',48)
                ->where('tipo_componente', 'manutencao')
                ->orderBy('horas_proxima_manutencao', 'asc')
                ->get();

            // Retornar a view com os dados carregados
            return view('app.equipamento.show', [
                'equipamento' => $equipamento,
                'ordens_servicos' => $ordens_servicos,
                'ordens_servicos_1' => $ordens_servicos_1,
                'pecas_equipamento' => $pecasEquip,
                'manutencao' => $manutencao,
                'chek_list' => $chek_list,
                'lubrificacao' => $lubrificacao,
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
        // Encontre a peça de equipamento pelo ID
        $pecaEquipamento = PecasEquipamentos::find($id);

        // Verifique se a peça de equipamento foi encontrada
        if (!$pecaEquipamento) {
            return response()->json(['success' => false, 'message' => 'Peça não encontrada.']);
        }

        // Verifique se o usuário tem permissão para deletar a peça de equipamento
        if (auth()->user()->level === 0) {
            // Deleta a peça de equipamento
            $pecaEquipamento->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Você não tem permissão para deletar esta peça.']);
        }
    }
    public function searching_products(Request $request)
    {
        $peca_equip_id = $request->get('peca_equipamento_id'); //Pega o id do registro componente
        $nome_produto_like = $request->get('query_like_producto_name');
        $pecaEquip = PecasEquipamentos::find($peca_equip_id);
        $pecasEquip = PecasEquipamentos::where('id', $peca_equip_id)->get();
        $equipamento = Equipamento::where('id',  $pecaEquip->equipamento)->get();
        $produtos = Produto::where('nome', 'like', $nome_produto_like . '%')->get();
        $categorias = Categoria::all();
        return view('app.peca_equipamento.edit_', [
            'produtos' => $produtos,
            'equipamento' => $equipamento,
            'categorias' => $categorias,
            'pecas_equipamentos' => $pecasEquip,
            'produto_nome' => $pecaEquip

        ]);
    }
}
