<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdemServico;
use App\Models\Ativo;
use App\Models\APR;
use App\Models\APRItem;
use App\Models\Equipamento;
use App\Models\Funcionario;
use App\Models\User;
use App\Models\Risco;
use App\Models\AprRisco;
use App\Models\RiscoMedidaControle;
use App\Models\AprRiscoMedidaControle;
use App\Models\MaterialEpi;
use App\Models\MaterialRisco;
use App\Models\PermissaoTrabalho;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class APRController extends Controller
{
    /**
     * Tela de listagem ou painel SESMT
     */
    public function index()
    {
        $ordens = OrdemServico::orderBy('id', 'desc')->get();
        $ativos = Equipamento::orderBy('nome')->get();
        return view('app.SESMT.index', compact('ordens', 'ativos'));
    }

    /**
     * Tela de criar APR vinculada à OS
     */
    public function create($os_id)
    {
        $ordem = OrdemServico::findOrFail($os_id);
        $ativos = Equipamento::orderBy('nome')->get();
        $funcionarios = Funcionario::where('status', 'Ativo')->get();
        return view('app.SESMT.apr_create', compact('ordem', 'ativos', 'funcionarios'));
    }

    /**
     * Salvar APR
     */ public function store(Request $request)
    {
        // dd($request);
        // 1. Validação dos dados
        $request->validate([
            'ordem_servico_id'      => 'required|exists:ordens_servicos,id',
            'responsavel'           => 'required|string|max:255',
            'local_trabalho'        => 'nullable|string|max:255',
            'descricao_atividade'   => 'required|string',
            'riscos_identificados'  => 'nullable|string',
            'medidas_controle'      => 'nullable|string',
            'epi_obrigatorio'       => 'nullable|string',
            'status'                => 'nullable|in:Aberta',
        ]);

        // 2. Criar registro da APR
        $apr = APR::create([
            'ordem_servico_id'       => $request->ordem_servico_id,
            'responsavel'            => $request->responsavel,
            'local_trabalho'         => $request->local_trabalho ?? 'Não informado',
            'descricao_atividade'    => $request->descricao_atividade,
            'riscos_identificados'   => $request->riscos_identificados,
            'medidas_controle'       => $request->medidas_controle,
            'epi_obrigatorio'        => $request->epi_obrigatorio,
            'status'                 => $request->status ?? 'aberta',
        ]);
        // Busca o último registro inserido na tabela aprs
        $apr = APR::latest('id')->first();

        if (!$apr) {
            abort(404, 'Nenhuma APR encontrada.');
        }

        return view('app.SESMT.show', compact('apr'));
    }


    /**
     * Exibir APR salva
     */
    public function show($id)
    {
        $apr = APR::findOrFail($id);
        //filtra os riscos salvo desta apr
        $apr_riscos = AprRisco::where('apr_id', $id)->get();


        // IDs dos riscos
        $idsRiscos = $apr_riscos->pluck('id');

        // TODAS as medidas (sem agrupar)
        $apr_riscos_medidas = AprRiscoMedidaControle::whereIn(
            'apr_risco_id',
            $idsRiscos
        )->get();

        $riscos = Risco::where('ativo', 1)
            ->orderBy('tipo_risco')
            ->orderBy('nome')
            ->get()
            ->groupBy('tipo_risco');
        $riscos_medidas_controle = RiscoMedidaControle::all();
        $materiais_risco = MaterialRisco::all();

        return view('app.SESMT.show', compact('apr', 'riscos', 'riscos_medidas_controle', 'apr_riscos', 'apr_riscos_medidas', 'materiais_risco'));
    }
    public function dashboard()
    {
        $aprs = APR::all();
        return view('app.SESMT.dashboard', ['aprs' => $aprs]);
    }
    public function risco_store(Request $request)
    {
        // Validação
        $request->validate([
            'apr_id'        => 'required|exists:aprs,id',
            'risco_id'      => 'required|exists:riscos,id',
            'status'        => 'required|string|max:255',
            'probabilidade' => 'required|string|max:50',
            'severidade'    => 'required|string|max:50',
            'grau'          => 'required|integer|min:1'
        ]);
        $materiais_risco = MaterialRisco::all();
        // Cria ou atualiza o risco diretamente
        $aprRisco = AprRisco::updateOrCreate(
            [
                'apr_id'   => $request->apr_id,
                'risco_id' => $request->risco_id
            ],
            [
                'status'        => $request->status,
                'probabilidade' => $request->probabilidade,
                'severidade'    => $request->severidade,
                'grau'          => $request->grau,
                'status'        => 1
            ]
        );

        // Carrega os dados atualizados para a view
        $apr = APR::findOrFail($request->apr_id);

        $apr_riscos = AprRisco::where('apr_id', $request->apr_id)->get();

        $riscos = Risco::where('ativo', 1)
            ->orderBy('tipo_risco')
            ->orderBy('nome')
            ->get()
            ->groupBy('tipo_risco');

        $riscos_medidas_controle = RiscoMedidaControle::all();

        // IDs dos riscos
        $idsRiscos = $apr_riscos->pluck('id');

        // TODAS as medidas (sem agrupar)
        $apr_riscos_medidas = AprRiscoMedidaControle::whereIn(
            'apr_risco_id',
            $idsRiscos
        )->get();

        return view('app.SESMT.show', compact(
            'apr',
            'riscos',
            'riscos_medidas_controle',
            'apr_riscos',
            'apr_riscos_medidas',
            'materiais_risco'
        ));
    }

    public function risco_medida_controle_store(Request $request)
    {
        $request->validate([
            'apr_risco_id' => 'required|integer',
            'medida_id'    => 'required|integer',
            'status'       => 'required|boolean' // 1 ou 0
        ]);

        AprRiscoMedidaControle::updateOrCreate(
            [
                'apr_risco_id' => $request->apr_risco_id,
                'medida_id'    => $request->medida_id
            ],
            [
                'status' => $request->status
            ]
        );
        $apr_risco_salvo = AprRiscoMedidaControle::where('apr_risco_id', $request->apr_risco_id)

            ->get()
            ->keyBy('medida_id'); // chave = medida_id para facilitar
        return response()->json(['success' => true]);
    }
    //PDF
    public function pdf($id)
    {
        $apr = APR::findOrFail($id);

        // Riscos salvos desta APR
        $apr_riscos = AprRisco::where('apr_id', $id)->get();

        // IDs dos apr_riscos
        $idsRiscos = $apr_riscos->pluck('id');

        // Medidas marcadas nesta APR
        $apr_riscos_medidas = AprRiscoMedidaControle::whereIn(
            'apr_risco_id',
            $idsRiscos
        )->get();

        // Lista de riscos (igual ao show)
        $riscos = Risco::where('ativo', 1)
            ->orderBy('tipo_risco')
            ->orderBy('nome')
            ->get()
            ->groupBy('tipo_risco');

        // Medidas de controle
        $riscos_medidas_controle = RiscoMedidaControle::all();

        // Materiais x Risco
        $materiais_risco = MaterialRisco::with('material')->get();

        $pdf = Pdf::loadView(
            'app.SESMT.pdf',
            compact(
                'apr',
                'riscos',
                'riscos_medidas_controle',
                'apr_riscos',
                'apr_riscos_medidas',
                'materiais_risco'
            )
        )->setPaper('a4', 'portrait');

        return $pdf->stream("APR-{$apr->id}.pdf");
    }
   public function pt_pdf(Apr $apr)
{
    // Buscar riscos agrupados por tipo
    $riscos = Risco::all()->groupBy('tipo');

    // Riscos da APR com grau >= 1
    $apr_riscos = AprRisco::where('apr_id', $apr->id)
        ->where('grau', '>', 1)
        ->get();

    // Medidas de controle
    $riscos_medidas_controle = RiscoMedidaControle::all();

    // Medidas marcadas para cada risco da APR
    $apr_riscos_medidas = AprRiscoMedidaControle::whereIn('apr_risco_id', $apr_riscos->pluck('id'))->get();

    // Materiais / EPIs
    $materiais_risco = MaterialRisco::all();

    // PT vinculada
    $pt = PermissaoTrabalho::where('apr_id', $apr->id)->first();

    $pdf = Pdf::loadView('app.SESMT.pt_pdf', compact(
        'apr',
        'riscos',
        'apr_riscos',
        'riscos_medidas_controle',
        'apr_riscos_medidas',
        'materiais_risco',
        'pt'
    ));

    return $pdf->stream('PT_' . $apr->id . '.pdf');
}

}
