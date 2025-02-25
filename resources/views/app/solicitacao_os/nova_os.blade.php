@extends('app.layouts.app')
@section('content')

<main class="content">
    <div class="titulo-main">
        Solicitações de O.S
    </div>
    <form action="{{ route('ordem-servico.create') }}" method="get" style="font-family: Arial, sans-serif;">
        <select class="form-control" name="equipamento" id="equipamento_id" required>
            <option value="">Selecione um equipamento</option>
            @foreach($equipamentos as $equipamento)
            <option value="{{ $equipamento->id }}" {{ old('equipamento_id') == $equipamento->id ? 'selected' : '' }}>
                {{ $equipamento->nome }}
            </option>
            @endforeach
        </select>
        <textarea name="descricao" id="" rows="5" cols="50">ID SS: {{$solicitacaoOs_id}}, {{$novaOs}}</textarea><br>
        <input name="ss_id" type="text" value="{{$solicitacaoOs_id}}">
        <input type="hidden" name="empresa" value="2"><br>
        <button type="submit" class="btn btn-outline-primary mb-1">
            Avançar
        </button>
    </form>
</main>
</html>