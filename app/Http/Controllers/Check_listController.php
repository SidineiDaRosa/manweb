<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Check_listController extends Controller
{
    //
    public function send(Request $request)
    {
        try {
            // Processar a requisição aqui, por exemplo:
            // $data = $request->all();
            // Realize suas operações com $data

            // Exemplo de resposta de sucesso
            return response()->json(['message' => 'Requisição AJAX bem-sucedida!']);
        } catch (\Exception $e) {
            // Capturar exceções e retornar uma resposta de erro
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
