<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdemServico;
use App\Models\Equipamento;
use PDF;

class PdfController extends Controller
{
    public function exibirFormulario()
    {
        return view('formulario-pdf');
    }

    public function gerarPDF(Request $request)
    {
        // Obter o ID da ordem de serviço a partir do request
        $ordemServicoId = $request->input('ordem_servico_id');
        // Buscar a ordem de serviço no banco de dados
        $ordemServico = OrdemServico::findOrFail($ordemServicoId);
        $equipamento = Equipamento::where('id',$ordemServico->equipamento_id)->get();
        // Preparar os dados para o PDF
        $data = [
            'ordemServico' => $ordemServico,
            'equipamento'=>$equipamento
        ];

        // Carregar a view do PDF usando Dompdf
        $pdf = PDF::loadView('app.meu-pdf', $data);

        // Retornar a visualização do PDF ao invés de fazer o download
        return $pdf->stream('ordem_servico_' . $ordemServico->id . '.pdf');
    }
}
