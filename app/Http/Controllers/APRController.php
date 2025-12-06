<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdemServico;
use App\Models\Ativo;
use App\Models\APR;
use App\Models\APRItem;
use App\Models\Equipamento;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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

        return view('app.SESMT.apr_create', compact('ordem', 'ativos'));
    }

    /**
     * Salvar APR
     */
    public function store(Request $request)
    {
        // 1. Criar registro da APR
        $apr = APR::create([
            'os_id'        => $request->os_id,
            'ativo_id'     => $request->ativo_id,
            'data'         => $request->data,
            'status'       => $request->status,
            'responsavel'  => $request->responsavel,
        ]);

        /*
        |--------------------------------------------------------------------------
        | 2. SALVAR ITENS DE CHECKLIST (NR12 / NR10 / RISCOS GERAIS)
        |--------------------------------------------------------------------------
        */

        $grupos = [
            'nr12' => 'NR12',
            'nr10' => 'NR10',
            'geral' => 'GERAL'
        ];

        foreach ($grupos as $campo => $norma) {

            if (!$request->has($campo)) continue;

            foreach ($request->$campo as $nomeItem => $dados) {

                $fotoPath = null;

                if (isset($dados['foto']) && $dados['foto']) {
                    // salva foto dentro de /storage/app/public/apr/{id}/
                    $fotoPath = $dados['foto']->store("apr/{$apr->id}", 'public');
                }

                APRItem::create([
                    'apr_id'    => $apr->id,
                    'norma'     => $norma,
                    'item'      => $nomeItem,
                    'ok'        => isset($dados['ok']) ? 1 : 0,
                    'risco'     => isset($dados['risco']) ? 1 : 0,
                    'obs'       => $dados['obs'] ?? null,
                    'foto'      => $fotoPath,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 3. EPIs e EPCs
        |--------------------------------------------------------------------------
        */
        $apr->epi = json_encode($request->epi ?? []);
        $apr->epc = json_encode($request->epc ?? []);
        $apr->observacoes = $request->observacoes;
        $apr->save();

        /*
        |--------------------------------------------------------------------------
        | 4. Retorno
        |--------------------------------------------------------------------------
        */

        return redirect()->route('apr.show', $apr->id)
                         ->with('success', 'APR salva com sucesso!');
    }

    /**
     * Exibir APR salva
     */
    public function show($id)
    {
        $apr = APR::with('itens')->findOrFail($id);

        return view('app.SESMT.show', compact('apr'));
    }
}
