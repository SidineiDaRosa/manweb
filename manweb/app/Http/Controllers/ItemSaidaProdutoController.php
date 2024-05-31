<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PedidoSaida;
use App\Models\Empresas;
use App\Models\Funcionario;
use App\Models\Equipamento;
use App\Models\OrdemServico;
use App\Models\EstoqueProdutos;
use App\Models\Produto;
use App\Models\PecasEquipamentos;

class ItemSaidaProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tipoFiltro = $request->get("tipofiltro");
        $empresa_id = $request->get('empresa_id');
        $produto_id = $request->get("produto");
        $pedido_id = $request->get("pedido");
        $equipamento_id = $request->get("equipamento");
        if ($tipoFiltro >= 1) {
            $empresas = Empresas::all();
            $produtos = Empresas::all();
            $firma = $empresa_id;
            $estoque_produtos = EstoqueProdutos::where('empresa_id', $empresa_id)->where('produto_id', $produto_id)->get();
            return view('app.item_saida_produto.index', [
                'estoque_produtos' => $estoque_produtos, 'empresas' => $empresas, 'produtos' => $produtos,
                'pedido' => $pedido_id,
                'empresa_id' => $empresa_id,
                'equipamento_id' => $equipamento_id
            ]);
        } else {
            $empresas = Empresas::all();
            $produtos = Empresas::all();
            // $estoque_produtos = EstoqueProdutos::where('empresa_id', 0)->get();
            //----------------------------------------------------------------
            // $pecasEquip = PecasEquipamentos::where('equipamento',  $equipamento_id)->get();
            // $equipamento = Equipamento::where('id',  $equipamento_id)->get();
            // return view('app.item_saida_produto.index', [
            // 'estoque_produtos' => $estoque_produtos, 'empresas' => $empresas, 'produtos' => $produtos,
            // 'pedido' => $pedido_id,
            // 'empresa_id' => $empresa_id,
            // 'equipamento_id' => $equipamento_id
            // ]);
            $pecasEquip = PecasEquipamentos::where('equipamento',  $equipamento_id)->get();
            $equipamento = Equipamento::where('id',  $equipamento_id)->get();
            //$estoque_produtos = EstoqueProdutos::where('empresa_id', $empresa_id)->where('produto_id', $produto_id)->get();
            return view('app.item_saida_produto.index', [
                'pecas_equipamento' => $pecasEquip, 'equipamento' => $equipamento, 'produtos' => $produtos, 'pedido' => $pedido_id,'empresa'=>$empresa_id 
                //'estoque_produtos' => $estoque_produtos
            ]);
        }
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
        //
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
