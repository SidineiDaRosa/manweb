<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Executar Lubrificação #{{ $lubrificacao->id }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container mt-5">
        <h3>Executar Lubrificação #{{ $lubrificacao->id }}</h3>
        <hr>

        <form action="{{ route('lubrificacao.executar.externo.salvar', $lubrificacao->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="equipamento" class="form-label">Equipamento</label>
                <input type="text" class="form-control" id="equipamento" value="{{ $lubrificacao->equipamento->nome ?? '-' }}" disabled>
            </div>

            <div class="mb-3">
                <label for="produto" class="form-label">Produto</label>
                <input type="text" class="form-control" id="produto" value="{{ $lubrificacao->produto->nome ?? '-' }}" disabled>
            </div>

            <div class="mb-3">
                <label for="intervalo" class="form-label">Intervalo (horas)</label>
                <input type="text" class="form-control" id="intervalo" value="{{ $lubrificacao->intervalo }}" disabled>
            </div>

            <div class="mb-3">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea class="form-control" name="observacoes" id="observacoes" rows="3">{{ $lubrificacao->observacoes }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-check"></i> Executar Lubrificação
            </button>
            <a href="#" onclick="window.close()" class="btn btn-secondary">Cancelar</a>
        </form>

    </div>
</body>

</html>