<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Familia;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $categorias = Categoria::all();
        return view('app.categoria.index', ['categorias' => $categorias]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('app.categoria.create',);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Categoria::create($request->all());
        return redirect()->route('categoria.index'); //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
    
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $categoria = Categoria::findOrFail($id);
        $familias = Familia::where('categoria_id', $id)->get(); // busca famílias relacionadas
        return view('app.categoria.show', compact('categoria', 'familias'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Buscar a categoria pelo ID
        $categoria = Categoria::findOrFail($id);

        // Verificar se a categoria existe
        if (!$categoria) {
            abort(404, 'Categoria não encontrada');
        }
     
        // Retorno
        return view('app.categoria.edit', ['categoria'=> $categoria, 'id' => $id]);
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
        // Buscar a categoria
        $categoria = Categoria::find($id);

        if (!$categoria) {
            abort(404, 'Categoria não encontrada');
        }

        // Validação
        $request->validate([
            'nome' => 'required|string|max:255|min:3'
        ], [
            'nome.required' => 'O nome da categoria é obrigatório',
            'nome.min' => 'O nome deve ter pelo menos 3 caracteres'
        ]);

        try {
            // Atualizar a categoria
            $categoria->update([
                'nome' => $request->nome
            ]);

            // Redirecionar com mensagem de sucesso
            return redirect()->route('categoria.index')->with('success', 'Categoria atualizada com sucesso!');
        } catch (\Exception $e) {
            // Em caso de erro
            return redirect()->back()->with('error', 'Erro ao atualizar categoria: ' . $e->getMessage());
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
        //
    }
}
