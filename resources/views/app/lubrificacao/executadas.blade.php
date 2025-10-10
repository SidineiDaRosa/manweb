@extends('app.layouts.app')

<main class="content">
    <div class="container">
        <h2>Lubrificações Executadas</h2>

        <div class="mb-3">
            <button class="btn btn-sm btn-primary" onclick="marcarTodos()">Marcar todos</button>
            <button class="btn btn-sm btn-secondary" onclick="desmarcarTodos()">Desmarcar todos</button>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" id="marcar-todos"></th>
                    <th>ID</th>
                    <th>Lubrificação ID</th>
                    <th>Observações</th>
                    <th>Executante</th>
                    <th>Criado em</th>
                    <th>Atualizado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lubrificacoes_executadas as $exec)
                <tr>
                    <td><input type="checkbox" class="marcados"></td>
                    <td>{{ $exec->id }}</td>
                    <td>{{ $exec->lubrificacao_id }}</td>
                    <td>{{ $exec->observacoes ?? '-' }}</td>
                    <td>{{ $exec->executante ?? '-' }}</td>
                    <td>{{ $exec->created_at?->format('d/m/Y H:i:s') ?? '-' }}</td>
                    <td>{{ $exec->updated_at?->format('d/m/Y H:i:s') ?? '-' }}</td>
                   
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-2">
            Número de linhas: {{ $lubrificacoes_executadas->count() }}
        </div>

        <div class="mt-2">
            <label for="filtro">Filtrar linhas:</label>
            <input type="text" id="filtro" onkeyup="filtrarTabela()" placeholder="Digite para filtrar...">
        </div>
    </div>
</main>

<script>
    // Marcar / desmarcar todos
    document.getElementById('marcar-todos').addEventListener('change', function() {
        document.querySelectorAll('.marcados').forEach(cb => cb.checked = this.checked);
    });

    function marcarTodos() {
        document.querySelectorAll('.marcados').forEach(cb => cb.checked = true);
    }
    function desmarcarTodos() {
        document.querySelectorAll('.marcados').forEach(cb => cb.checked = false);
    }

    // Filtrar tabela
    function filtrarTabela() {
        let filtro = document.getElementById('filtro').value.toLowerCase();
        document.querySelectorAll('table tbody tr').forEach(tr => {
            tr.style.display = tr.innerText.toLowerCase().includes(filtro) ? '' : 'none';
        });
    }
</script>
