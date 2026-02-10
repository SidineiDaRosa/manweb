<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de O.S. - Visual</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bs-primary: #0d6efd;
            --bs-success: #198754;
            --bs-warning: #ffc107;
            --bs-danger: #dc3545;
            --bs-info: #0dcaf0;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 20px;
            padding-bottom: 50px;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1rem;
            border-radius: 10px;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, .125);
            padding: 0.75rem 1.25rem;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .table th {
            font-weight: 600;
            font-size: 0.9rem;
            color: #495057;
            border-top: none;
        }

        .table td {
            vertical-align: middle;
            font-size: 0.875rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.04);
        }

        .badge {
            font-weight: 500;
            font-size: 0.75em;
            padding: 0.35em 0.65em;
        }

        .progress {
            height: 6px;
            border-radius: 3px;
        }

        .btn-group-sm>.btn {
            padding: 0.25rem 0.5rem;
        }

        .filtro-rapido-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 8px;
        }

        @media (max-width: 768px) {
            .filtro-rapido-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .table-responsive {
                font-size: 0.8rem;
            }
        }

        .text-small {
            font-size: 0.8rem;
        }

        .status-aberto {
            background-color: #0d6efd;
        }

        .status-fechado {
            background-color: #198754;
        }

        .status-andamento {
            background-color: #ffc107;
            color: #000;
        }

        .status-cancelada {
            background-color: #dc3545;
        }

        .status-pausado {
            background-color: #6c757d;
        }

        .vencido {
            color: #dc3545 !important;
            font-weight: 600;
        }

        .hoje {
            background-color: #fff3cd !important;
        }

        .servico-info {
            border-left: 3px solid #28a745;
            padding-left: 8px;
            margin-top: 4px;
            font-size: 0.8rem;
            background-color: rgba(40, 167, 69, 0.05);
            border-radius: 0 4px 4px 0;
        }

        .pagination {
            margin-bottom: 0;
        }

        .form-control-sm {
            font-size: 0.875rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <!-- ==================== FILTROS RÁPIDOS ==================== -->
        <div class="card mb-3">
            <div class="card-body py-2">
                <div class="filtro-rapido-grid">
                    <button type="button" class="btn btn-info btn-sm" onclick="setFiltroHoje()">
                        <i class="fas fa-calendar-day me-1"></i> O.S. Hoje
                    </button>
                    <button type="button" class="btn btn-info btn-sm" onclick="setFiltroAndamento()">
                        <i class="fas fa-play-circle me-1"></i> Em Andamento
                    </button>
                    <button type="button" class="btn btn-info btn-sm" onclick="setFiltroAbertas()">
                        <i class="fas fa-unlock me-1"></i> O.S. Abertas
                    </button>
                    <button type="button" class="btn btn-info btn-sm" onclick="setFiltroSemana()">
                        <i class="fas fa-calendar-week me-1"></i> Esta Semana
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="setFiltroVencidas()">
                        <i class="fas fa-exclamation-triangle me-1"></i> O.S. Vencidas
                    </button>
                    <a href="#" class="btn btn-dark btn-sm">
                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- ==================== FORMULÁRIO DE FILTRO AVANÇADO ==================== -->
        <div class="card mb-4">
            <div class="card-body">
                <form id="form_filt_os">
                    <div class="row g-2">
                        <div class="col-md-1">
                            <label class="form-label">ID</label>
                            <input type="number" class="form-control form-control-sm"
                                name="id" placeholder="ID">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Data inicial</label>
                            <input type="date" class="form-control form-control-sm"
                                name="data_inicio" id="data_inicio" value="2024-01-15">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Hora inicial</label>
                            <input type="time" class="form-control form-control-sm"
                                name="hora_inicio" value="08:00">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Data final</label>
                            <input type="date" class="form-control form-control-sm"
                                name="data_fim" id="data_fim" value="2024-01-22">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Hora final</label>
                            <input type="time" class="form-control form-control-sm"
                                name="hora_fim" value="18:00">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Situação</label>
                            <select class="form-select form-select-sm" name="situacao" id="situacao">
                                <option value="">Todas</option>
                                <option value="aberto" selected>Aberto</option>
                                <option value="fechado">Fechado</option>
                                <option value="em andamento">Em andamento</option>
                                <option value="cancelada">Cancelada</option>
                                <option value="pausado">Pausado</option>
                            </select>
                        </div>

                        <div class="col-md-8 mt-2">
                            <label class="form-label">Busca</label>
                            <input type="text" name="search" class="form-control form-control-sm"
                                placeholder="Descrição, equipamento, empresa..."
                                style="background-color: rgba(255, 255, 153, 0.3);">
                        </div>

                        <div class="col-md-2 mt-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-warning btn-sm w-100" onclick="filtrarOS()">
                                <i class="fas fa-filter me-1"></i> Filtrar
                            </button>
                        </div>

                        <div class="col-md-2 mt-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-secondary btn-sm w-100" onclick="limparFiltros()">
                                <i class="fas fa-times me-1"></i> Limpar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- ==================== TABELA DE O.S. ==================== -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="70">ID</th>
                                <th width="100">Emissão</th>
                                <th width="100">Início</th>
                                <th width="100">Término</th>
                                <th>Empresa</th>
                                <th>Equipamento</th>
                                <th>Status</th>
                                <th width="120">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ordens_servicos as $ordem_servico)
                            <tr class="hoje">
                                <td>
                                    <strong>#{{$ordem_servico->id}}</strong>
                                </td>

                                <td>
                                    <div class="text-small text-muted">{{$ordem_servico->data_emissao}}</div>
                                    <div class="text-small">{{$ordem_servico->hora_emissao}}</div>
                                </td>

                                <td>
                                    <div class="text-small">{{$ordem_servico->data_inicio}}</div>
                                    <div class="text-small">{{$ordem_servico->hora_emissao}}</div>
                                </td>

                                <td>
                                    <div class="text-small">{{$ordem_servico->data_fim}}</div>
                                    <div class="text-small">{{$ordem_servico->hora_fim}}</div>
                                </td>

                                <td>
                                    <div class="text-small">Fapolpa</div>
                                </td>

                                <td>
                                    <div class="text-small">Máquina de Solda MIG-200</div>
                                </td>

                                <td>
                                    <span class="badge status-andamento">Em andamento</span>

                                    <div class="progress mt-1">
                                        <div class="progress-bar bg-success" style="width: 65%"></div>
                                    </div>
                                    <div class="text-small text-muted">65% completo</div>

                                    <div class="servico-info mt-1">
                                        <strong>João:</strong> Realizada manutenção preventiva
                                    </div>
                                </td>

                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-success" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" title="Excluir" onclick="confirmarExclusao(1024)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-success" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" title="Excluir" onclick="confirmarExclusao(1020)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted text-small">
                            Mostrando 1 a 5 de 24 registros
                        </div>
                        <div>
                            <nav aria-label="Navegação de página">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Anterior</a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">4</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">5</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Próximo</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações do Sistema -->
        <div class="mt-3 text-center text-muted text-small">
            <p>Sistema de Gestão de Ordens de Serviço | 5 ordens de serviço carregadas</p>
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="modalExclusao" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir esta ordem de serviço?</p>
                    <p class="text-danger"><strong>Ação irreversível!</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger btn-sm" id="btnConfirmarExclusao">Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Formatar data para YYYY-MM-DD
        function formatarData(data) {
            return data.toISOString().split('T')[0];
        }

        // Obter primeiro dia da semana
        function getPrimeiroDiaSemana(data) {
            const d = new Date(data);
            const day = d.getDay();
            const diff = d.getDate() - day + (day === 0 ? -6 : 1);
            return new Date(d.setDate(diff));
        }

        // Obter último dia da semana
        function getUltimoDiaSemana(data) {
            const primeiroDia = getPrimeiroDiaSemana(data);
            const ultimoDia = new Date(primeiroDia);
            ultimoDia.setDate(primeimoDia.getDate() + 6);
            return ultimoDia;
        }

        // ========== FUNÇÕES DE FILTRO RÁPIDO ==========
        function setFiltroHoje() {
            const hoje = new Date();
            document.getElementById('data_inicio').value = formatarData(hoje);
            document.getElementById('data_fim').value = formatarData(hoje);
            document.getElementById('situacao').value = '';
            mostrarFeedback('Filtro aplicado: O.S. de hoje');
        }

        function setFiltroAndamento() {
            document.getElementById('situacao').value = 'em andamento';
            mostrarFeedback('Filtro aplicado: O.S. em andamento');
        }

        function setFiltroAbertas() {
            document.getElementById('situacao').value = 'aberto';
            mostrarFeedback('Filtro aplicado: O.S. abertas');
        }

        function setFiltroVencidas() {
            const hoje = new Date();
            document.getElementById('data_fim').value = formatarData(hoje);
            document.getElementById('situacao').value = 'aberto';
            mostrarFeedback('Filtro aplicado: O.S. vencidas');
        }

        function setFiltroSemana() {
            const hoje = new Date();
            const primeiroDia = getPrimeiroDiaSemana(hoje);
            const ultimoDia = getUltimoDiaSemana(hoje);

            document.getElementById('data_inicio').value = formatarData(primeiroDia);
            document.getElementById('data_fim').value = formatarData(ultimoDia);
            document.getElementById('situacao').value = '';
            mostrarFeedback('Filtro aplicado: O.S. desta semana');
        }

        function filtrarOS() {
            const dataInicio = document.getElementById('data_inicio').value;
            const dataFim = document.getElementById('data_fim').value;
            const situacao = document.getElementById('situacao').value;

            let mensagem = 'Filtrando O.S.: ';
            if (dataInicio) mensagem += `de ${dataInicio} `;
            if (dataFim) mensagem += `até ${dataFim} `;
            if (situacao) mensagem += `com situação "${situacao}"`;

            mostrarFeedback(mensagem);
        }

        function limparFiltros() {
            document.getElementById('form_filt_os').reset();
            // Definir datas padrão
            const hoje = new Date();
            const trintaDiasAtras = new Date();
            trintaDiasAtras.setDate(hoje.getDate() - 30);

            document.getElementById('data_inicio').value = formatarData(trintaDiasAtras);
            document.getElementById('data_fim').value = formatarData(hoje);

            mostrarFeedback('Filtros limpos');
        }

        // ========== FUNÇÃO DE EXCLUSÃO ==========
        let osParaExcluir = null;

        function confirmarExclusao(id) {
            osParaExcluir = id;
            const modal = new bootstrap.Modal(document.getElementById('modalExclusao'));
            modal.show();
        }

        document.getElementById('btnConfirmarExclusao').addEventListener('click', function() {
            if (osParaExcluir) {
                mostrarFeedback(`O.S. #${osParaExcluir} excluída com sucesso!`, 'success');
                // Aqui normalmente faria uma requisição AJAX para excluir
                osParaExcluir = null;

                const modal = bootstrap.Modal.getInstance(document.getElementById('modalExclusao'));
                modal.hide();
            }
        });

        // ========== FEEDBACK VISUAL ==========
        function mostrarFeedback(mensagem, tipo = 'info') {
            // Criar elemento de feedback
            const feedback = document.createElement('div');
            feedback.className = `alert alert-${tipo} alert-dismissible fade show position-fixed`;
            feedback.style.top = '20px';
            feedback.style.right = '20px';
            feedback.style.zIndex = '9999';
            feedback.style.maxWidth = '300px';
            feedback.innerHTML = `
                ${mensagem}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            document.body.appendChild(feedback);

            // Remover automaticamente após 3 segundos
            setTimeout(() => {
                if (feedback.parentNode) {
                    feedback.remove();
                }
            }, 3000);
        }

        // ========== INICIALIZAÇÃO ==========
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar datas padrão se estiverem vazias
            const hoje = new Date();
            const trintaDiasAtras = new Date();
            trintaDiasAtras.setDate(hoje.getDate() - 30);

            if (!document.getElementById('data_inicio').value) {
                document.getElementById('data_inicio').value = formatarData(trintaDiasAtras);
            }

            if (!document.getElementById('data_fim').value) {
                document.getElementById('data_fim').value = formatarData(hoje);
            }

            // Destacar linhas vencidas
            document.querySelectorAll('tr').forEach(linha => {
                const dataFimElement = linha.querySelector('.vencido');
                if (dataFimElement) {
                    linha.classList.add('table-danger');
                }
            });

            console.log('Sistema de O.S. carregado com sucesso!');
        });
    </script>
</body>

</html>