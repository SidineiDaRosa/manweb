<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Group;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groupId = $request->query('group_id');
        $user = auth()->user();

        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar as mensagens.');
        }

        if ($groupId) {
            $group = Group::find($groupId);

            if (!$group) {
                return redirect()->route('app.home')->with('error', 'Grupo não encontrado.');
            }

            // Aqui você verifica se o usuário pertence ao grupo
            $isInGroup = $group->users->contains($user->id); // Supondo relação many-to-many com users()

            if (!$isInGroup) {
                return redirect()->route('app.home')->with('error', 'Você não tem permissão para acessar este grupo.');
            }

            $messages = Message::where('group_id', $groupId)->get();
        } else {
            // Se quiser permitir visualizar todos, ou bloquear completamente
            return redirect()->route('app.home')->with('error', 'Grupo não especificado.');
        }

        return view('app.post.index', compact('messages', 'group'));
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
        $request->validate([
            'message' => 'required|string',
            'group_id' => 'required|exists:groups,id', // validação do grupo
        ]);

        Message::create([
            'user_id' => auth()->id(),
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'subject' => 'Nova mensagem',
            'message' => $request->message,
            'group_id' => $request->group_id, // adiciona o group_id aqui
        ]);

        return redirect()->route('blog.painel', ['group_id' => $request->group_id])
            ->with('success', 'Mensagem enviada!');
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
    public function fetch(Request $request, $groupId)
    {
        $lastId = $request->get('last_id', 0);

        $messages = Message::where('group_id', $groupId)
            ->where('id', '>', $lastId)
            ->with('user')
            ->orderBy('id')
            ->get();

        return response()->json($messages->map(function ($msg) {
            return [
                'id' => $msg->id,
                'user_id' => $msg->user_id,
                'user_name' => $msg->user ? $msg->user->name : $msg->name,
                'timestamp' => $msg->created_at?->format('d/m/Y H:i'),
                'timestamp_full' => $msg->created_at?->format('d/m/Y H:i:s'),
                'subject' => $msg->subject,
                'message' => $msg->message,
            ];
        }));
    }
    public function messages_count_user(Request $request)
    {
        $lastId = $request->query('last_id', 0);

        $count = Message::where('id', '>', $lastId)->count();

        return response()->json(['pendentes' => $count]);
    }
}
