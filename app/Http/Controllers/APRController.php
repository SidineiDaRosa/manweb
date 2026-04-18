<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdemServico;
use App\Models\Ativo;
use App\Models\APR;
use App\Models\Apr as ModelsApr;
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
use App\Models\AreaLocal;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use League\Flysystem\Adapter\Local;
use PhpParser\Node\Stmt\Foreach_;

class APRController extends Controller
{
    /**
     * Tela de listagem ou painel SESMT
     */
    public function index(Request $request)
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
        $localizacao = AreaLocal::all();
        return view('app.SESMT.apr_create', compact('ordem', 'ativos', 'funcionarios', 'localizacao'));
    }

    /**
     * Salvar APR
     */
    public function store(Request $request)
    {
        // 1. Validação (Mantenha como está)
        $request->validate([
            'ordem_servico_id'     => 'required|exists:ordens_servicos,id',
            'responsavel'          => 'required|exists:funcionarios,id',
            'localizacao_id'       => 'required|exists:area_local,id',
            'descricao_atividade'  => 'required|string',
            'status'               => 'nullable|in:Aberta,aberta',
        ]);

        // 2. Criar registro da APR
        // O Laravel retorna o objeto criado com o ID gerado pelo banco na variável $apr
        $apr = Apr::create([
            'ordem_servico_id'     => $request->ordem_servico_id,
            'responsavel_id'       => $request->responsavel,
            'localizacao_id'       => $request->localizacao_id,
            'local_trabalho'       => $request->local_trabalho ?? 'Não informado',
            'descricao_atividade'  => $request->descricao_atividade,
            'riscos_identificados' => $request->riscos_identificados,
            'medidas_controle'     => $request->medidas_controle,
            'epi_obrigatorio'      => $request->epi_obrigatorio,
            'status'               => $request->status ?? 'aberta',
            'prazo'                => $request->prazo
        ]);

        // 3. Redirecionar usando o ID do objeto que acabou de ser criado ($apr->id)
        return redirect()->route('apr.show', ['id' => $apr->id])
            ->with('success', 'APR salva com sucesso!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:aprs,id',
            'ordem_servico_id' => 'required',
            'descricao_atividade' => 'required',
            'status' => 'required|in:aberta,finalizada'
        ]);

        $apr = Apr::findOrFail($request->id);

        $apr->update([
            'ordem_servico_id' => $request->ordem_servico_id,
            'localizacao_id' => $request->localizacao_id,
            'descricao_atividade' => $request->descricao_atividade,
            'responsavel_id' => $request->responsavel_id,
            'assinatura_responsavel' => $request->assinatura_responsavel,
            'status' => $request->status,
            'prazo' => $request->prazo,
        ]);
        // No seu APRController, após salvar ou atualizar:
        return redirect()->route('apr.show', ['id' => $apr->id])
            ->with('success', 'APR salva com sucesso!');
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
        $localizacao = AreaLocal::all();
        $responsaveis = Funcionario::all();
        return view('app.SESMT.show', compact('apr', 'riscos', 'riscos_medidas_controle', 'apr_riscos', 'apr_riscos_medidas', 'materiais_risco', 'localizacao', 'responsaveis'));
    }
    //Carrega dshboard SESMT
    public function dashboard(Request $request)
    {
        $aprs = APR::all();
        $riscos = AprRisco::all();
        $apr_count = APR::count('status', 'aberta');
        $ordens_servicos = OrdemServico::whereHas('apr') // só quem tem APR relacionada
            ->where('situacao', '!=', 'fechado')        // que não estão fechadas
            ->get();

        return view('app.SESMT.dashboard', [
            'aprs' => $aprs,
            'riscos' => $riscos,
            'ordens_servicos' => $ordens_servicos

        ]);
    }
    public function risco_store(Request $request)
    {
        $request->validate([
            'apr_id'        => 'required|exists:aprs,id',
            'risco_id'      => 'required|exists:riscos,id',
            'probabilidade' => 'required|string|max:50',
            'severidade'    => 'required|string|max:50',
            'grau'          => 'required|integer|min:1'
        ]);

        $aprRisco = AprRisco::updateOrCreate(
            [
                'apr_id'   => $request->apr_id,
                'risco_id' => $request->risco_id
            ],
            [
                'status'        => 1,
                'probabilidade' => $request->probabilidade,
                'severidade'    => $request->severidade,
                'grau'          => $request->grau
            ]
        );

        $apr_risco_id = AprRisco::find($aprRisco->id);
        return response()->json([
            'success' => true,
            'message' => 'Risco salvo com sucesso',
            'status' => 1, // ou 0 conforme lógica
            'apr_risco_id' => $apr_risco_id->id,
            'risco_id' => $request->risco_id,
            'probabilidade' => $request->probabilidade,
            'severidade' => $request->severidade,
            'grau' => $request->grau

        ]);
    }
    public function risco_medida_controle_store(Request $request)
    {
        $aprRiscoId = $request->input('apr_risco_id');
        $medidas = $request->input('medidas', []);

        if (!$aprRiscoId) {
            return response()->json(['success' => false, 'message' => 'APR Risco não definido']);
        }

        foreach ($medidas as $medidaId => $valor) {
            AprRiscoMedidaControle::updateOrCreate(
                [
                    'apr_risco_id' => $aprRiscoId,
                    'medida_id' => $medidaId,
                ],
                [
                    'status' => $valor === 'existente' ? 1 : 0
                ]
            );
        }

        return response()->json(['success' => true]);
    }




    // imprime a apr PDF
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

        // Filtrar apenas os materiais dos riscos selecionados
        $materiais_selecionados = collect();
        foreach ($apr_riscos as $apr_risco) {
            $materiais_do_risco = $materiais_risco
                ->where('risco_id', $apr_risco->risco_id);
            $materiais_selecionados = $materiais_selecionados->concat($materiais_do_risco);
        }

        // Remove duplicados
        $materiais_selecionados = $materiais_selecionados->unique('id');

        // PT vinculada
        $pt = PermissaoTrabalho::where('apr_id', $apr->id)->first();
        if ($apr->status == 'Verificada') {

            // Gerar PDF
            $pdf = Pdf::loadView('app.SESMT.pt_pdf', compact(
                'apr',
                'riscos',
                'apr_riscos',
                'riscos_medidas_controle',
                'apr_riscos_medidas',
                'materiais_selecionados', // materiais necessários
                'pt'
            ));

            return $pdf->stream('PT_' . $apr->id . '.pdf');
        } else {
            return redirect()->back()->with('error', 'Não foi possível imprimir a PT, 
            porque Há risco que ainda não foi calssificado. Para liberar a impressão é preciso que todos os riscos estejam devidamente classificados!');
        }
    }
    //apr em branco
    public function apr_modelo($apr_id)
    {
        $apr = APR::find($apr_id);
        // Lista de riscos ativos
        $riscos = Risco::where('ativo', 1)
            ->orderBy('tipo_risco')
            ->orderBy('nome')
            ->get()
            ->groupBy('tipo_risco');

        // Medidas de controle
        $riscos_medidas_controle = RiscoMedidaControle::all();

        // Materiais / EPIs vinculados aos riscos
        $materiais_risco = MaterialRisco::with('material')->get();

        $pdf = Pdf::loadView(
            'app.SESMT.apr_vazia',
            compact(
                'apr',
                'riscos',
                'riscos_medidas_controle',
                'materiais_risco'
            )
        )->setPaper('a4', 'portrait');

        return $pdf->stream('APR-EM-BRANCO.pdf');
    }
    public function confirmarAnalise($id)
    {
        $riscos = Risco::where('ativo', 1)->get();
        $pendentes = [];

        foreach ($riscos as $risco) {
            $apr_risco = AprRisco::where('apr_id', $id)
                ->where('risco_id', $risco->id)
                ->first();

            // Risco não vinculado ou não checado
            if (!$apr_risco || $apr_risco->status != 1) {
                $pendentes[] = $risco->nome . ' (risco não verificado)';
                continue; // pula para o próximo risco
            }

            // 🔎 Agora verifica medidas de controle deste risco
            $medidas = RiscoMedidaControle::where('risco_id', $risco->id)->get();

            foreach ($medidas as $medida) {
                $apr_medida = AprRiscoMedidaControle::where('apr_risco_id', $apr_risco->id)
                    ->where('medida_id', $medida->id)
                    ->first();

                // Medida não aplicada ou registro não existe
                if (!$apr_medida) { // só checa se não existe
                    $pendentes[] = $risco->nome . ' - Medida: ' . $medida->descricao . ' (não verificada)';
                }
            }
        }
        $erro_epi = false;

        $apr_riscos = AprRisco::where('apr_id', $id)
            ->where('grau', '>', 1)
            ->get();

        foreach ($apr_riscos as $risco) {
            if ($risco->epis != 1) {
                $erro_epi = true;
                break;
            }
        }


        // 🚫 Bloqueia confirmação se houver pendências

        if (!empty($pendentes)) {

            return redirect()->back()->with(
                'error',
                'Existem pendências na análise:<br>➤ ' . implode('<br>➤ ', $pendentes)
            );
        }

        // ✅ Se passou por tudo, confirma APR
        if ($erro_epi) {
            return redirect()->back()->with(
                'error',
                'Existe risco com grau maior que 1, e que os EPIs  não foram verificados.'
            );
        } else {
            APR::where('id', $id)->update([
                'status' => 'Verificada'
            ]);
            return redirect()->back()->with('success', 'Todos os riscos e medidas de controle foram verificados com sucesso!');
        }
    }
    public function verificaEpis(Request $request)
    {

        // Validação básica
        $request->validate([
            'apr_risco_id' => 'required|integer',
            'epis' => 'required|array',
            'epis.*' => 'integer'
        ]);

        $aprRiscoId = $request->apr_risco_id;
        $epis = $request->epis;

        // Aqui você faz o que precisa no banco:
        // - Registrar que os EPIs foram verificados
        // - Atualizar algum status no $aprRiscoId, etc.

        // Exemplo simples:
        AprRisco::find($aprRiscoId)->update(['epis' => true]);

        return response()->json(['success' => true]);
    }
}
