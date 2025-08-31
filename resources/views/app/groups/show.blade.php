@extends('app.layouts.app')
@section('titulo', 'Show')
@section('content')
<main class="content">


    <style>
        .group-user-form {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-top: 20px;
        }


        .user-entry {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .user-entry:last-child {
            border-bottom: none;
        }

        .user-name {
            flex-grow: 1;
        }

        .role-select {
            margin-left: 10px;
            padding: 5px 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 0.95rem;
        }

        .submit-btn {
            margin-top: 16px;
            padding: 10px 18px;
            background-color: #28a745;
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #218838;
        }

        .success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>



    {{ $group->name }}
    {{ $group->description }}

    @if(session('success'))
    <div class="success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('groups.attachUsers', $group->id) }}" method="POST" class="group-user-form">
        @csrf

        <label>Selecionar usuários e definir função:</label>
        @foreach ($users as $user)
        @php
        $pivot = $group->users->find($user->id)?->pivot;
        $userRole = $pivot ? $pivot->role : 'member';
        $isChecked = $pivot ? true : false;
        @endphp

        <div class="user-entry">
            <label class="user-name">
                @if($userRole === 'admin')
                <input type="checkbox" name="users[]" value="{{ $user->id }}" checked disabled>
                {{ $user->name }} (Administrador)
                <input type="hidden" name="users[]" value="{{ $user->id }}">
                @else
                <input type="checkbox" name="users[]" value="{{ $user->id }}" {{ $isChecked ? 'checked' : '' }}>
                {{ $user->name }}
                @endif
            </label>

            <select name="roles[{{ $user->id }}]" class="role-select" {{ $userRole === 'admin' ? 'disabled' : '' }}>
                <option value="member" {{ $userRole === 'member' ? 'selected' : '' }}>Membro</option>
                <option value="admin" {{ $userRole === 'admin' ? 'selected' : '' }}>Administrador</option>
            </select>
        </div>
        @endforeach


        <button type="submit" class="submit-btn">Anexar Usuários</button>
    </form>
    @if ($errors->any())
    <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</main>
@endsection