<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function gerarQRCode(Request $request)
    {
        // Capturar a URL enviada via formulário
        //$urlPaginaAtual = $request->input('url');
        $qrCode = $request->get('url');
        $id = $request->get('equipamento_id');
        $dados_id = Equipamento::find($id);
        // Gerar o QR Code
        //$qrCode = QrCode::size(100)->backgroundColor(255, 255, 255)->generate($urlPaginaAtual);
        // Retornar a view para exibir o QR Code
        return view('app.qrcode', [
            'qrCode' => $qrCode,
            'dados_id' => $dados_id, // Enviando o equipamento para a view
        ]);
    }
    public function gerarQRCode_history(Request $request)
    {
        // Capturar a URL enviada via formulário
        //$urlPaginaAtual = $request->input('url');
        $qrCode = $request->get('url');
        $id = $request->get('equipamento_id');
        $dados_id = Equipamento::find($id);
        // Gerar o QR Code
        //$qrCode = QrCode::size(100)->backgroundColor(255, 255, 255)->generate($urlPaginaAtual);
        // Retornar a view para exibir o QR Code
        return view('app.qrcode', [
            'qrCode' => $qrCode,
            'dados_id' => $dados_id, // Enviando o equipamento para a view
        ]);
    }
}
