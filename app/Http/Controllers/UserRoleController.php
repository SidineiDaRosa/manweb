<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    // Listar todos os roles
    public function index()
    {
        $roles = UserRole::with('user')->get(); // Carrega o usuário relacionado
        return view('auth.user_role.index', compact('roles'));
    }

    // Mostrar formulário para criar novo role
    public function create()
    {
        $users = User::all(); // Para selecionar o usuário relacionado
        return view('user_roles.create', compact('users'));
    }

    // Salvar novo role
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:50',
            'descricao' => 'nullable',
            'user_id' => 'required|exists:users,id',
        ]);

        UserRole::create($request->all());

        return redirect()->route('user_roles.index')
                         ->with('success', 'UserRole criado com sucesso!');
    }

    // Mostrar um role específico
    public function show(UserRole $userRole)
    {
        return view('user_roles.show', compact('userRole'));
    }

    // Mostrar formulário de edição
    public function edit(UserRole $userRole)
    {
        $users = User::all();
        return view('app.auth.user_role.edit', compact('userRole', 'users'));
    }

    // Atualizar role
    public function update(Request $request, UserRole $userRole)
    {
        $request->validate([
            'nome' => 'required|max:50',
            'descricao' => 'nullable',
            'user_id' => 'required|exists:users,id',
        ]);

        $userRole->update($request->all());

        return redirect()->route('user_roles.index')
                         ->with('success', 'UserRole atualizado com sucesso!');
    }

    // Deletar role
    public function destroy(UserRole $userRole)
    {
        $userRole->delete();

        return redirect()->route('user_roles.index')
                         ->with('success', 'UserRole deletado com sucesso!');
    }
}
