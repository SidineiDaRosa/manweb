<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use App\Models\Marca;
use App\Models\Equipamento;
use App\Models\PecasEquipamentos;
use App\Models\OrdemServico;
use App\Models\Funcionario;
use App\Models\User;
use App\Models\Servicos_executado; //serviços executados
use Illuminate\Support\Arr;
use Picqer\Barcode\BarcodeGeneratorHTML;
//para busca de produtos em um formlário que adiciona os produtos ao equipamentos
use App\Models\Produto;
use App\Models\UnidadeMedida;
use App\Models\Categoria;
use App\Models\EstoqueProdutos; //Include estoque produtos
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // usa qrcode
// Importar os modelos necessários

class EquipamentoHistoryController extends Controller
{
    // Definição do método
    public function assets(Request $request)
    {
        $asset_id = $request->get('asset_id');
        $equipamento = Equipamento::find($asset_id);

        if (!$equipamento) {
            return abort(404, 'Equipamento não encontrado.');
        }

        $ordens_servicos = OrdemServico::where('equipamento_id', $equipamento->id)
            ->where('situacao', 'fechado')
            ->orderBy('data_fim', 'desc')
            ->get();

        $servicos_executados_colecao = collect(); // Cria uma coleção vazia para colocar os serviços
        $usuarios = User::all(); // Obtém todos os usuários
        $equipamento_filho = Equipamento::where('equipamento_pai', $equipamento->id)->get();

        // Gerar QR Codes para cada equipamento filho
        //$qrCodes = [];
        //foreach ($equipamento_filho as $filho) {
           // $url = url("/assets?asset_id={$filho->id}");
           // $qrCode = QrCode::format('png')->size(300)->generate($url);
           // $qrCodes[$filho->id] = base64_encode($qrCode); // Codifica a imagem QR como base64
       // }

        return view('app.equipamento.equipamento_grupo', [
            'equipamento' => $equipamento,
            'equipamento_filho' => $equipamento_filho,
           // 'qrCodes' => $qrCodes
        ]);
    }
    public function asset_show(Request $request)
    {
        $asset_id = $request->get('asset_id');
        $equipamento = Equipamento::find($asset_id);
        $ordens_servicos = OrdemServico::where('equipamento_id', $equipamento->id)->where('situacao', 'fechado')->orderBy('data_fim', 'desc')->get();
        $servicos_executados_colecao = collect(); // Cria uma coleção vazia para colocar os serviços
        $usuarios = User::all(); // Obtém todos os usuários da tabela
        $equipamento_filho = Equipamento::where('equipamento_pai', $equipamento->id)->get();
        foreach ($ordens_servicos as $ordem_servico) {
            $servicos_executados = Servicos_executado::where('ordem_servico_id', $ordem_servico->id)->get();
            $servicos_executados_colecao = $servicos_executados_colecao->merge($servicos_executados); // Adiciona os serviços executados à coleção
        }
        $funcionarios=Funcionario::all();
        // Código para o método
        return view('app.equipamento.os_fechadas_equipamento', [
            'equipamento' => $equipamento,
            'ordens_servicos' => $ordens_servicos,
            'servicos_executados_colecao' => $servicos_executados_colecao,
            'usuarios' => $usuarios,
            'equipamento_filho' => $equipamento_filho,
            'funcionarios'=>$funcionarios
        ]);
    }
}
