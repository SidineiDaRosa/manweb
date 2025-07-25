<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $groups = Group::all();
        return view('app.groups.index', compact('groups'));
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Group::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Grupo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::with('users')->findOrFail($id);
        $users = User::all();

        return view('app.groups.show', compact('group', 'users'));
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
    public function attachUsers(Request $request, Group $group)
    {
        $authUserId = auth()->id();

        // Se o grupo ainda não tem ninguém, adiciona o usuário autenticado como admin
        if ($group->users()->count() === 0) {
            $group->users()->attach($authUserId, ['role' => 'admin']);
        }

        // Verifica se quem está tentando alterar é admin do grupo
        $isAdmin = $group->users()
            ->where('user_id', $authUserId)
            ->wherePivot('role', 'admin')
            ->exists();

        if (!$isAdmin) {
            return redirect()->back()->withErrors('Apenas administradores podem modificar os participantes.');
        }

        $selectedUsers = $request->input('users', []);  // IDs selecionados no form
        $roles = $request->input('roles', []);

        // Busca admins atuais do grupo para garantir que não serão removidos
        $currentAdmins = $group->users()
            ->wherePivot('role', 'admin')
            ->pluck('users.id')  // 👈 Corrige ambiguidade
            ->toArray();

        // Garante que todos admins atuais continuam no grupo (mesmo se não vieram no form)
        $allUsersToSync = array_unique(array_merge($selectedUsers, $currentAdmins));

        // Garante que o usuário autenticado nunca seja removido e continue como admin
        if (!in_array($authUserId, $allUsersToSync)) {
            $allUsersToSync[] = $authUserId;
        }
        if (!in_array($authUserId, $currentAdmins)) {
            $currentAdmins[] = $authUserId;
        }

        $syncData = [];

        foreach ($allUsersToSync as $userId) {
            if (in_array($userId, $currentAdmins)) {
                $syncData[$userId] = ['role' => 'admin'];
            } else {
                $syncData[$userId] = ['role' => $roles[$userId] ?? 'member'];
            }
        }

        $group->users()->sync($syncData);

        return redirect()->back()->with('success', 'Usuários atualizados com sucesso!');
    }
}
