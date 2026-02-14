@extends('app.layouts.app')

@section('content')
    <main class="content">
        <div class="container">
            <h6><i class="bi bi-droplet-half me-2"></i>Detalhes da Lubrificação</h6>

            <div class="card mt-3">
                <div class="card-body">

                    {{-- Dados da lubrificação --}}
                    <div class="mb-3"><strong><i class="bi bi-hash"></i> ID:</strong> <span>{{ $lubrificacao->id }}</span>
                    </div>

                    <div class="mb-3">
                        <strong><i class="bi bi-gear"></i> Equipamento:</strong>
                        <span>{{ $lubrificacao->equipamento->nome ?? '-' }}</span>
                    </div>

                    <div class="mb-3">
                        <strong><i class="bi bi-box-seam"></i> Produto:</strong>
                        <span>{{ $lubrificacao->produto->nome ?? '-' }}</span>
                    </div>

                    <div class="mb-3">
                        <strong><i class="bi bi-speedometer2"></i> Produção:</strong>
                        <span>{{ $lubrificacao->producao ?? '-' }}</span>
                    </div>

                    <div class="mb-3">
                        <strong><i class="bi bi-chat-left-text"></i> Observações:</strong>
                        <span>{{ $lubrificacao->observacoes ?? '-' }}</span>
                    </div>

                    <div class="mb-3">
                        <strong><i class="bi bi-upc-scan"></i> Tag:</strong>
                        <span>{{ $lubrificacao->tag ?? '-' }}</span>
                    </div>

                    <div class="mb-3">
                        <strong><i class="bi bi-calendar-plus"></i> Criado em:</strong>
                        <span>{{ $lubrificacao->criado_em ? $lubrificacao->criado_em->format('d/m/Y H:i') : '-' }}</span>
                    </div>

                    <div class="mb-3">
                        <strong><i class="bi bi-clock-history"></i> Atualizado em:</strong>
                        <span>{{ $lubrificacao->atualizado_em ? $lubrificacao->atualizado_em->format('d/m/Y H:i') : '-' }}</span>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('lubrificacao.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>

                        <a href="{{ route('lubrificacao.edit', $lubrificacao->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Editar
                        </a>

                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Deseja realmente excluir esta lubrificação?')">
                            <i class="bi bi-trash"></i> Excluir
                        </button>

                        <a href="{{ route('lubrificacoes-executadas.index', $lubrificacao->id) }}" class="btn btn-primary">
                            <i class="bi bi-list-check"></i> Executadas
                        </a>

                    </div>
                </div>
            </div>

            {{-- Lista de Tipos de Medição --}}
            <div class="card mt-4" hidden>
                <div class="card-header d-flex justify-content-between align-items-center" hidden>
                    <span>Tipos de Intervalos</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addMedicaoModal">Adicionar</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lubrificacao_intervalos as $medicao)
                                <tr>
                                    <td>{{ $medicao->id }}</td>
                                    <td>{{ $medicao->tipo }}</td>
                                    <td>{{ $medicao->valor }}</td>
                                    <td>
                                        {{-- Aqui você pode colocar editar/excluir --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Modal para adicionar nova medição --}}
            <div class="modal fade" id="addMedicaoModal" tabindex="-1" aria-labelledby="addMedicaoModalLabel"
                aria-hidden="true" hidden>
                <div class="modal-dialog">
                    <form action="{{ route('medicao.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="lubrificacao_id" value="{{ $lubrificacao->id }}">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addMedicaoModalLabel">Adicionar Medição</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="tipo" class="form-label">Tipo de Medição</label>
                                    <select name="tipo" id="tipo" class="form-select" required>
                                        <option value="">Selecione</option>
                                        @foreach ($unidades as $unidade)
                                            <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="valor" class="form-label">Valor</label>
                                    <input type="number" step="0.01" name="valor" id="valor" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <style>
            /* ===================== BASE ===================== */
            .content {
                background: #f4f6f9;
                min-height: 100vh;
                padding: 25px;
                font-family: "Segoe UI", Roboto, Arial, sans-serif;
            }

            .container {
                max-width: 1050px;
            }

            /* ===================== TÍTULO PADRÃO SISTEMA ===================== */
            h6 {
                font-size: 18px;
                font-weight: 600;
                color: #2f3b52;
                margin-bottom: 14px;
                display: flex;
                align-items: center;
                position: relative;
                padding-left: 14px;
            }

            strong i {
                margin-right: 6px;
                opacity: .75;
            }

            .btn i {
                margin-right: 6px;
            }

            h6::before {
                content: "";
                position: absolute;
                left: 0;
                width: 4px;
                height: 22px;
                border-radius: 3px;
                background: linear-gradient(180deg, #2d7ef7, #6ea8fe);
            }

            /* ===================== CARD ===================== */
            .card {
                border: none;
                border-radius: 12px;
                background: #fff;
                box-shadow: 0 6px 22px rgba(0, 0, 0, .07);
            }

            .card-body {
                padding: 26px 28px;
            }

            /* ===================== CAMPOS ===================== */
            .card-body .mb-3 {
                display: grid;
                grid-template-columns: 200px 1fr;
                align-items: center;
                padding: 12px 0;
                border-bottom: 1px solid #edf0f4;
                font-size: 14px;
            }

            .card-body .mb-3:last-child {
                border-bottom: none;
            }

            .card-body strong {
                color: #6b778c;
                font-weight: 600;
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: .4px;
            }

            .card-body span {
                color: #2f3b52;
                font-weight: 600;
            }

            /* destaques */
            .card-body .mb-3:nth-child(2) span {
                color: #2d7ef7;
            }

            /* equipamento */
            .card-body .mb-3:nth-child(3) span {
                color: #16a34a;
            }

            /* produto */

            .card-body .mb-3:nth-child(5) span {
                background: #f1f5f9;
                padding: 8px 12px;
                border-radius: 8px;
                font-weight: 500;
            }

            /* ===================== BOTÕES ===================== */
            .mt-4 {
                margin-top: 24px !important;
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
                padding-top: 14px;
                border-top: 1px dashed #e5e7eb;
            }

            .btn {
                border-radius: 7px !important;
                padding: 8px 14px !important;
                font-size: 13px !important;
                font-weight: 600;
                border: none !important;
                transition: .18s;
            }

            .btn-secondary {
                background: #6c757d !important;
                color: #fff;
            }

            .btn-warning {
                background: #f59e0b !important;
                color: #fff;
            }

            .btn-danger {
                background: #dc2626 !important;
                color: #fff;
            }

            .btn-primary {
                background: #2d7ef7 !important;
                color: #fff;
            }

            .btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 14px rgba(0, 0, 0, .15);
            }

            /* ===================== TABELA ===================== */
            .table {
                margin-top: 10px;
                border-radius: 10px;
                overflow: hidden;
            }

            .table thead {
                background: #f1f4f8;
            }

            .table th {
                font-size: 12px;
                text-transform: uppercase;
                color: #5b6578;
                border: none !important;
            }

            .table td {
                border-top: 1px solid #edf0f4 !important;
            }

            .table tbody tr:hover {
                background: #f7faff;
            }

            /* ===================== MODAL ===================== */
            .modal-content {
                border-radius: 14px;
                border: none;
                box-shadow: 0 20px 40px rgba(0, 0, 0, .2);
            }

            .modal-header {
                background: #f1f4f8;
                border-bottom: 1px solid #e5e7eb;
            }

            /* ===================== MOBILE ===================== */
            @media(max-width:768px) {

                .content {
                    padding: 15px;
                }

                .card-body {
                    padding: 18px;
                }

                .card-body .mb-3 {
                    grid-template-columns: 1fr;
                    gap: 3px;
                    padding: 11px 0;
                }

                .card-body strong {
                    font-size: 11px;
                }

                .card-body span {
                    font-size: 15px;
                    word-break: break-word;
                }

                .mt-4 {
                    flex-direction: column;
                }

                .mt-4 .btn {
                    width: 100%;
                }
            }
        </style>
    </main>
@endsection
