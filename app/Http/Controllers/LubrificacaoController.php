<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lubrificacao;
use App\Models\UnidadeMedida;
use App\Models\Equipamento;
use App\Models\Produto;
use App\Models\lubrificacaoIntervalo;

class LubrificacaoController extends Controller
{
    public function index(Request $request)
    {
        $equipamentos = Equipamento::all();

        // Inicia a query com os relacionamentos
        $query = Lubrificacao::with(['equipamento', 'produto', 'unidadeMedida', 'intervalos']);

        // Filtra por equipamento, se houver
        if ($request->filled('equipamento_id')) {
            $query->where('equipamento_id', $request->equipamento_id);
        }

        // Pega os resultados
        $lubrificacoes = $query->get();

        return view('app.lubrificacao.index', compact('lubrificacoes', 'equipamentos'));
    }

    public function create()
    {
        $equipamentos = Equipamento::all();
        $unidades = UnidadeMedida::all();
        $produtos = Produto::whereHas('familia', function ($query) {
            $query->where('nome', 'like', 'ole%')
                ->orWhere('nome', 'like', 'grax%');
        })->get();
        return view('app.lubrificacao.create', compact('unidades', 'equipamentos', 'produtos'));
    }

    public function store(Request $request)
    {
        Lubrificacao::create($request->all());
        return redirect()->route('lubrificacao.index');
    }

    public function show(Lubrificacao $lubrificacao)
    {
        // Carrega os relacionamentos necessários
        $lubrificacao->load(['equipamento', 'produto', 'unidadeMedida']);
        $unidades = UnidadeMedida::all();
        // Pega os intervalos de medição relacionados à lubrificação
        $lubrificacao_intervalos = LubrificacaoIntervalo::where('lubrificacao_id', $lubrificacao->id)->get();

        // Retorna a view com os dados
        return view('app.lubrificacao.show', compact('lubrificacao', 'lubrificacao_intervalos', 'unidades'));
    }

    public function edit(Lubrificacao $lubrificacao)
    {
        $equipamentos = Equipamento::all();
        $unidades = UnidadeMedida::all();
        $produtos = Produto::where('familia_id', 65)->get();
        return view('app.lubrificacao.edit', compact('lubrificacao', 'equipamentos', 'unidades', 'produtos'));
    }

    public function update(Request $request, Lubrificacao $lubrificacao)
    {
        $lubrificacao->update($request->all());
        return redirect()->route('lubrificacao.index');
    }

    public function destroy(Lubrificacao $lubrificacao)
    {
        $lubrificacao->delete();
        return redirect()->route('lubrificacao.index');
    }

    public function store_intervalo(Request $request)
    {

        $request->validate([
            'lubrificacao_id' => 'required|exists:lubrificacao,id',
            'tipo' => 'required|int',
            'valor' => 'required|numeric',
        ]);

        LubrificacaoIntervalo::create([
            'lubrificacao_id' => $request->lubrificacao_id,
            'unidade' => $request->tipo,
            'valor' => $request->valor,
        ]);

        return redirect()->back()->with('success', 'Intervalo de medição adicionado com sucesso!');
    }
    public function countPendentes()
    {
        $agora = now();
        $pendentes = Lubrificacao::all()->filter(function ($lub) use ($agora) {
            if (!$lub->intervalo) return false;
            $ultimaData = $lub->atualizado_em ?? $lub->criado_em;
            $horasPassadas = $agora->diffInHours($ultimaData);
            return $horasPassadas >= $lub->intervalo; // atrasado
        })->count();

        return response()->json(['pendentes' => $pendentes]);
    }
}
