@extends('app.layouts.app')
<main class="content">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Equipamento</th>
                <th>Tipo de Lubrificação</th>
                <th>Data</th>
                <th>Responsável</th>
                <th>Horas de Uso</th>
                <th>Observações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lubrificacoes_executadas as $exec)
            <tr>
                <td>{{ $exec->id }}</td>
                <td>{{ $exec->equipamento->nome ?? '-' }}</td>
                <td>{{ $exec->lubrificacao->nome ?? '-' }}</td>
                <td>{{ $exec->data_execucao->format('d/m/Y') }}</td>
                <td>{{ $exec->responsavel }}</td>
                <td>{{ $exec->horas_uso }}</td>
                <td>{{ $exec->observacoes }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</main>