<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Empresas;
use League\CommonMark\Extension\CommonMark\Node\Inline\Emphasis;

class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $razao_social_like=$request->get('empresa1');
        
        //$idEmpresa =Empresas::where('razao_social','like',$razao_social_like.'%')->get('id');
       // return view('app.empresa.index', ['empresas' => $empresas]);
       if (isset($_POST['empresa1'])){
        if (!empty($razao_social_like)) {
           $empresas =Empresas::where('razao_social','like',$razao_social_like.'%')->get();
            return view('app.empresa.index', ['empresas' => $empresas]);
    }else{
        //$empresas =Empresas::where('razao_social','like','ita'.'%')->get('id')->toJson();
        $empresas =Empresas::where('razao_social','like','ita'.'%')->get();
        foreach($empresas as $emp){
            echo($emp->razao_social);
        }
        
        $empresas =Empresas::where('razao_social','like','ita'.'%')->first();
            $empresas->teste= 'teste';
            unset($empresas->razao_social);
            dd($empresas);
            echo($emp->razao_social);


        /* echo($empresas->razao_social); */
        /* dd($empresas->razao_social); */
    }
    }else{
        $empresas =Empresas::where('id',0)->get();
          return view('app.empresa.index', ['empresas' => $empresas]);
    }
}
       /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empresa=Empresas::all();
      return view('app.empresa.create', ['empresa'=>$empresa]); //
 
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
        Empresas::create($request->all());
        return redirect()->route('empresas.index');
    }

    /**
     * Display the specified resource.
     * @param  \App\Models\Empresas  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresas $empresa)
    {
      
        //
      //dd($empresa);
        return view('app.empresa.show', ['empresa' => $empresa]);

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresas $empresa)
    {
        //
        $empresa = Empresas::all(); 
        return view('app.empresa.create', ['empresa'=>$empresa]); //
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