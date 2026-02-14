@extends('app.layouts.app')

@section('titulo', 'Nova Lubrificação')

@section('content')
    <!-- Bootstrap Icons GLOBAL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


    <main class="content page-form">


        <div class="container">
            <h6>Nova Lubrificação</h6>

            <a href="{{ route('lubrificacao.index') }}" class="btn btn-secondary mb-3">Voltar</a>

            {{-- Exibe erros de validação --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('lubrificacao.store') }}" method="POST">
                @csrf

                {{-- Equipamento --}}
                <div class="mb-3">
                    <label for="equipamento_id" class="form-label">
                        <i class="bi bi-gear-fill text-primary"></i> Equipamento
                    </label>

                    <select name="equipamento_id" id="equipamento_id" class="form-control" required>
                        <option value="">Selecione o equipamento</option>
                        @foreach ($equipamentos as $equipamento)
                            <option value="{{ $equipamento->id }}"
                                {{ old('equipamento_id') == $equipamento->id ? 'selected' : '' }}>
                                {{ $equipamento->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Produto --}}
                <div class="mb-3">
                    <label for="produto_id" class="form-label">
                        <i class="bi bi-droplet-half text-primary"></i> Produto
                    </label>


                    <select name="produto_id" id="produto_id" class="form-control" required>
                        <option value="">Selecione o produto</option>
                        @foreach ($produtos as $produto)
                            <option value="{{ $produto->id }}" {{ old('produto_id') == $produto->id ? 'selected' : '' }}>
                                {{ $produto->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- Observações --}}
                <div class="mb-3">
                    <label for="observacoes" class="form-label">
                        <i class="bi bi-chat-left-text text-primary"></i> Observações
                    </label>

                    <textarea name="observacoes" id="observacoes" class="form-control" rows="3"
                        placeholder="Digite observações, se houver" required>{{ old('observacoes') }}</textarea>
                </div>
                {{-- Observações --}}
                <div class="mb-3">

                    <label for="tag" class="form-label">
                        <i class="bi bi-upc-scan text-primary"></i> Tag
                    </label>


                    <input type="text" name="tag" id="tag" class="form-control" required>
                </div>
                <div class="mb-3">

                    <label for="intervalo" class="form-label">
                        <i class="bi bi-clock-history text-primary"></i> Intervalo em horas
                    </label>


                    <input type="text" name="intervalo" id="intervalo" class="form-control"required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Salvar Lubrificação
                </button>

            </form>
        </div>
    </main>

    <style>
        /* ====== FORMULÁRIO PROFISSIONAL ====== */

        .page-form {
            background: #f4f6f9;
            min-height: 100vh;
            padding: 30px;
        }

        /* Card */
        .page-form .container {
            max-width: 720px;
            background: #ffffff;
            padding: 30px 35px;
            border-radius: 14px;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.08);
        }

        /* Título */
        .page-form h6 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2f3542;
            border-left: 5px solid #0d6efd;
            padding-left: 10px;
        }

        /* Labels */
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 6px;
        }

        /* Inputs */
        .form-control {
            border-radius: 8px;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            transition: all .2s ease;
            font-size: 15px;
        }

        /* Hover */
        .form-control:hover {
            border-color: #86b7fe;
        }

        /* Focus */
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, .15);
        }

        /* Select igual input */
        select.form-control {
            cursor: pointer;
        }

        /* Textarea */
        textarea.form-control {
            resize: vertical;
        }

        /* Botões */
        .btn-primary {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            border: none;
            border-radius: 10px;
            padding: 10px 22px;
            font-weight: 600;
            transition: .2s;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(13, 110, 253, .25);
        }

        .btn-secondary {
            border-radius: 10px;
        }

        /* Alert erro */
        .alert-danger {
            border-radius: 10px;
            font-size: 14px;
        }

        /* Espaçamento campos */
        .mb-3 {
            margin-bottom: 18px !important;
        }
    </style>
@endsection
