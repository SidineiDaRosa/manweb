@extends('app.layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
>

<main class="content">
    <div class="container">
        <h2>
            <i class="bi bi-droplet-half"></i>
            Lubrificações Executadas
            <span class="subtitle">Histórico de execuções registradas</span>
        </h2>


        <style>
            /* ===== Título da página ===== */
            h2 {
                font-size: 20px;
                font-weight: 600;
                color: #2f3b52;
                margin-bottom: 18px;
                display: flex;
                align-items: center;
                gap: 10px;
                position: relative;
                padding-left: 14px;
            }

            /* barra lateral */
            h2::before {
                content: "";
                position: absolute;
                left: 0;
                width: 4px;
                height: 22px;
                border-radius: 3px;
                background: linear-gradient(180deg, #2d7ef7, #6ea8fe);
            }

            .subtitle {
                font-size: 13px;
                color: #7b8794;
                font-weight: 400;
            }

            /* ===== Layout ===== */
            .content {
                background: #f4f6f9;
                min-height: 100vh;
                padding: 25px;
                font-family: "Segoe UI", Roboto, Arial, sans-serif;
            }

            .container {
                background: white;
                border-radius: 12px;
                padding: 25px;
                box-shadow: 0 6px 22px rgba(0, 0, 0, .07);
            }

            /* ===== Header ===== */
            h2 {
                font-weight: 600;
                color: #2f3b52;
                margin-bottom: 18px;
            }

            /* ===== Botões ===== */
            .btn {
                border-radius: 7px !important;
                font-size: 13px !important;
                font-weight: 500;
                padding: 6px 14px !important;
                transition: .2s;
            }

            .btn-primary {
                background: #2d7ef7 !important;
                border: none !important;
            }

            .btn-primary:hover {
                background: #1f6ae0 !important;
            }

            .btn-secondary {
                background: #6c757d !important;
                border: none !important;
            }

            .btn-secondary:hover {
                background: #545b62 !important;
            }



            /* ===== Tabela Desktop ===== */
            .table {
                margin-top: 18px;
                border-radius: 10px;
                overflow: hidden;
                border-collapse: separate;
                border-spacing: 0;
            }

            .table thead {
                background: #f1f4f8;
            }

            .table th {
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: .5px;
                color: #5b6578;
                border: none !important;
            }

            .table td {
                border-top: 1px solid #edf0f4 !important;
                color: #2f3b52;
            }

            .table tbody tr {
                transition: .15s;
            }

            .table tbody tr:hover {
                background: #f7faff;
            }

            /* ===== Checkbox ===== */
            input[type="checkbox"] {
                width: 16px;
                height: 16px;
                accent-color: #2d7ef7;
                cursor: pointer;
            }

            /* ========================================================= */
            /* ================== RESPONSIVIDADE REAL ================== */
            /* ========================================================= */

            @media (max-width: 768px) {

                .container {
                    padding: 15px;
                }

                #filtro {
                    width: 100%;
                }

                /* some header */
                .table thead {
                    display: none;
                }

                /* vira cards */
                .table,
                .table tbody,
                .table tr,
                .table td {
                    display: block;
                    width: 100%;
                }

                .table tr {
                    background: white;
                    border-radius: 12px;
                    padding: 14px 14px 10px 14px;
                    margin-bottom: 14px;
                    box-shadow: 0 4px 14px rgba(0, 0, 0, .08);
                    border: 1px solid #eef1f5;
                }

                .table td {
                    border: none !important;
                    padding: 6px 0;
                    font-size: 14px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                /* nome da coluna antes do valor */
                .table td::before {
                    content: attr(data-label);
                    font-weight: 600;
                    color: #6b778c;
                    margin-right: 10px;
                }

                /* checkbox alinhado */
                .table td:first-child {
                    justify-content: flex-start;
                    gap: 10px;
                }
            }

            /* ===== Toolbar ===== */
            .table-toolbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 12px;
                margin-bottom: 10px;
                gap: 15px;
            }

            /* caixa de busca */
            .search-box {
                position: relative;
                width: 320px;
            }

            .search-box input {
                width: 100%;
                padding: 9px 12px 9px 34px;
                border-radius: 8px;
                border: 1px solid #dcdfe6;
                font-size: 14px;
                transition: .2s;
                background: #fafbfd;
            }

            .search-box input:focus {
                outline: none;
                border-color: #2d7ef7;
                background: white;
                box-shadow: 0 0 0 3px rgba(45, 126, 247, .15);
            }

            /* ícone */
            .search-icon {
                position: absolute;
                left: 10px;
                top: 50%;
                transform: translateY(-50%);
                font-size: 14px;
                opacity: .6;
            }

            /* contador */
            .table-info {
                font-size: 13px;
                color: #6b778c;
                background: #f1f4f8;
                padding: 6px 10px;
                border-radius: 7px;
            }

            /* mobile */
            @media (max-width:768px) {
                .table-toolbar {
                    flex-direction: column;
                    align-items: stretch;
                }

                .search-box {
                    width: 100%;
                }

                .table-info {
                    text-align: center;
                }
            }
        </style>

        <div class="mb-3">
            <button class="btn btn-sm btn-primary" onclick="marcarTodos()">
                <i class="bi bi-check2-square"></i> Marcar todos
            </button>

            <button class="btn btn-sm btn-secondary" onclick="desmarcarTodos()">
                <i class="bi bi-square"></i> Desmarcar todos
            </button>
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
                @foreach ($lubrificacoes_executadas as $exec)
                    <tr>
                        <td data-label="Selecionar"><input type="checkbox" class="marcados"></td>
                        <td data-label="ID">{{ $exec->id }}</td>
                        <td data-label="Lubrificação ID">{{ $exec->lubrificacao_id }}</td>
                        <td data-label="Observações">{{ $exec->observacoes ?? '-' }}</td>
                        <td data-label="Executante">{{ $exec->executante ?? '-' }}</td>
                        <td data-label="Criado em">{{ $exec->created_at?->format('d/m/Y H:i:s') ?? '-' }}</td>
                        <td data-label="Atualizado em">{{ $exec->updated_at?->format('d/m/Y H:i:s') ?? '-' }}</td>
                        <td data-label="Ações">-</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="table-toolbar">
            <div class="search-box">
                <span class="search-icon">
                    <i class="bi bi-search"></i>
                </span>

                <input type="text" id="filtro" onkeyup="filtrarTabela()"
                    placeholder="Buscar em qualquer coluna...">
            </div>


            <div class="table-info">
                {{ $lubrificacoes_executadas->count() }} registros
            </div>
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
