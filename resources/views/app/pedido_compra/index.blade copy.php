<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Produtos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        body {
            background-color: rgb(245, 246, 248);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #eaeaea;
            padding: 15px 20px;
        }
        .card-body {
            padding: 20px;
        }
        .table-template {
            width: 100%;
            border-collapse: collapse;
        }
        .table-template th, .table-template td {
            padding: 12px 15px;
            text-align: left;
            vertical-align: middle;
        }
        .table-template thead th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #eaeaea;
        }
        .table-template tbody tr {
            border-bottom: 1px solid #eaeaea;
        }
        .table-template tbody tr:hover {
            background-color: #f8f9fa;
        }
        .th-title {
            font-weight: 600;
        }
        .btn-sm-template {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.2rem;
        }
        .status-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            border-radius: 0.375rem;
        }
        .status-ok {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .status-baixo {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-esgotado {
            background-color: #f8d7da;
            color: #721c24;
        }
        .filter-section {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .print-btn {
            margin-left: 10px;
        }
        .summary-card {
            background-color: #fff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .summary-value {
            font-size: 1.5rem;
            font-weight: 600;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                background-color: white;
            }
            .card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>
    <main class="content container-fluid py-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Relatório de Produtos em Estoque</h5>
                <button class="btn btn-primary no-print" onclick="window.print()">
                    <span class="material-symbols-outlined" style="vertical-align: middle; font-size: 18px;">
                        print
                    </span>
                    Imprimir Relatório
                </button>
            </div>
            <div class="card-body">
                <!-- Filtros -->
                <div class="filter-section no-print">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="categoria" class="form-label">Categoria:</label>
                                <select class="form-select" id="categoria">
                                    <option value="">Todas as categorias</option>
                                    <option value="eletronicos">Eletrônicos</option>
                                    <option value="limpeza">Limpeza</option>
                                    <option value="alimentos">Alimentos</option>
                                    <option value="outros">Outros</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="status_estoque" class="form-label">Status do Estoque:</label>
                                <select class="form-select" id="status_estoque">
                                    <option value="">Todos os status</option>
                                    <option value="ok">OK</option>
                                    <option value="baixo">Baixo</option>
                                    <option value="esgotado">Esgotado</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="data_inicio" class="form-label">Data Inicial:</label>
                                <input type="date" class="form-control" id="data_inicio">
                            </div>
                            <div class="col-md-3">
                                <label for="data_fim" class="form-label">Data Final:</label>
                                <input type="date" class="form-control" id="data_fim">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-outline-secondary me-2">
                                    Limpar Filtros
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <span class="material-symbols-outlined" style="vertical-align: middle; font-size: 18px;">
                                        search
                                    </span>
                                    Aplicar Filtros
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Resumo -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="summary-card text-center">
                            <div class="text-muted small">Total de Produtos</div>
                            <div class="summary-value">85</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="summary-card text-center">
                            <div class="text-muted small">Valor Total em Estoque</div>
                            <div class="summary-value">R$ 48.752,00</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="summary-card text-center">
                            <div class="text-muted small">Produtos com Estoque Baixo</div>
                            <div class="summary-value">7</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="summary-card text-center">
                            <div class="text-muted small">Produtos Esgotados</div>
                            <div class="summary-value">3</div>
                        </div>
                    </div>
                </div>

                <!-- Tabela de Produtos -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="th-title">Código</th>
                                <th scope="col" class="th-title">Nome do Produto</th>
                                <th scope="col" class="th-title">Categoria</th>
                                <th scope="col" class="th-title">Preço de Custo</th>
                                <th scope="col" class="th-title">Preço de Venda</th>
                                <th scope="col" class="th-title">Estoque Atual</th>
                                <th scope="col" class="th-title">Status</th>
                                <th scope="col" class="th-title no-print">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>PRD-001</td>
                                <td>Smartphone Galaxy A54</td>
                                <td>Eletrônicos</td>
                                <td>R$ 1.200,00</td>
                                <td>R$ 1.799,00</td>
                                <td>45</td>
                                <td><span class="status-badge status-ok">OK</span></td>
                                <td class="no-print">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">
                                            visibility
                                        </span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">
                                            edit
                                        </span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>PRD-002</td>
                                <td>Notebook Ultrafino i7</td>
                                <td>Eletrônicos</td>
                                <td>R$ 2.500,00</td>
                                <td>R$ 3.699,00</td>
                                <td>8</td>
                                <td><span class="status-badge status-baixo">BAIXO</span></td>
                                <td class="no-print">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">
                                            visibility
                                        </span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">
                                            edit
                                        </span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>PRD-045</td>
                                <td>Detergente Neutro 500ml</td>
                                <td>Limpeza</td>
                                <td>R$ 1,50</td>
                                <td>R$ 3,99</td>
                                <td>120</td>
                                <td><span class="status-badge status-ok">OK</span></td>
                                <td class="no-print">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">
                                            visibility
                                        </span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">
                                            edit
                                        </span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>PRD-078</td>
                                <td>Café Premium 1kg</td>
                                <td>Alimentos</td>
                                <td>R$ 18,00</td>
                                <td>R$ 29,90</td>
                                <td>0</td>
                                <td><span class="status-badge status-esgotado">ESGOTADO</span></td>
                                <td class="no-print">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">
                                            visibility
                                        </span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">
                                            edit
                                        </span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>PRD-101</td>
                                <td>Fone Bluetooth</td>
                                <td>Eletrônicos</td>
                                <td>R$ 85,00</td>
                                <td>R$ 149,90</td>
                                <td>22</td>
                                <td><span class="status-badge status-ok">OK</span></td>
                                <td class="no-print">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">
                                            visibility
                                        </span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">
                                            edit
                                        </span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Anterior</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Próxima</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script para funcionalidade básica dos filtros
        document.addEventListener('DOMContentLoaded', function() {
            // Aqui você pode adicionar a lógica para filtrar a tabela
            // com base nos seletores de categoria e status
            const categoriaSelect = document.getElementById('categoria');
            const statusSelect = document.getElementById('status_estoque');
            
            categoriaSelect.addEventListener('change', aplicarFiltros);
            statusSelect.addEventListener('change', aplicarFiltros);
            
            function aplicarFiltros() {
                // Esta função seria implementada para filtrar os resultados
                console.log('Filtrando por:', {
                    categoria: categoriaSelect.value,
                    status: statusSelect.value
                });
                
                // Em uma implementação real, aqui você faria:
                // 1. Uma requisição AJAX para o servidor com os parâmetros de filtro
                // 2. Ou filtraria os dados localmente se estiverem todos carregados
            }
        });
    </script>
</body>
</html>