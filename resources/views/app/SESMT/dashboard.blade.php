<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Segurança do Trabalho</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #1e3a5f;
            color: white;
            padding: 20px 0;
            transition: all 0.3s;
        }

        .logo {
            display: flex;
            align-items: center;
            padding: 0 20px 20px;
            border-bottom: 1px solid #2d4d7a;
            margin-bottom: 20px;
        }

        .logo i {
            font-size: 28px;
            color: #4CAF50;
            margin-right: 10px;
        }

        .logo h2 {
            font-size: 20px;
            font-weight: 600;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .menu-item:hover {
            background-color: #2d4d7a;
        }

        .menu-item.active {
            background-color: #3a5f8a;
            border-left: 4px solid #4CAF50;
        }

        .menu-item i {
            margin-right: 12px;
            font-size: 18px;
        }

        /* Main content */
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
            color: #1e3a5f;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        /* Dashboard cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 500;
            color: #6c757d;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
        }

        .card-value {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .card-change {
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .card-change.positive {
            color: #4CAF50;
        }

        .card-change.negative {
            color: #f44336;
        }

        /* Main sections */
        .main-sections {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        @media (max-width: 1100px) {
            .main-sections {
                grid-template-columns: 1fr;
            }
        }

        .section {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e3a5f;
        }

        .section-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 5px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .btn-primary {
            background-color: #1e3a5f;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2d4d7a;
        }

        .btn-success {
            background-color: #4CAF50;
            color: white;
        }

        .btn-success:hover {
            background-color: #3d8b40;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid #1e3a5f;
            color: #1e3a5f;
        }

        .btn-outline:hover {
            background-color: #f0f4f8;
        }

        /* Table */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
            font-weight: 600;
            color: #1e3a5f;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .status.pendente {
            background-color: #fff3cd;
            color: #856404;
        }

        .status.aprovada {
            background-color: #d4edda;
            color: #155724;
        }

        .status.revisao {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status.vencida {
            background-color: #f8d7da;
            color: #721c24;
        }

        .priority {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .priority.alta {
            background-color: #f44336;
        }

        .priority.media {
            background-color: #ff9800;
        }

        .priority.baixa {
            background-color: #4CAF50;
        }

        /* Risk indicators */
        .risk-indicators {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .risk-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .risk-info h4 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .risk-info p {
            font-size: 14px;
            color: #6c757d;
        }

        .risk-level {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 500;
        }

        .risk-level.alto {
            background-color: #f8d7da;
            color: #721c24;
        }

        .risk-level.medio {
            background-color: #fff3cd;
            color: #856404;
        }

        .risk-level.baixo {
            background-color: #d4edda;
            color: #155724;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            color: #6c757d;
            font-size: 14px;
            border-top: 1px solid #e0e0e0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                padding: 10px;
            }

            .menu-item {
                padding: 12px 15px;
            }

            .dashboard-cards {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .user-info {
                margin-top: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <i class="fas fa-shield-alt"></i>
                <h2>SafeWork Dashboard</h2>
            </div>

            <div class="menu-item active">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-file-alt"></i>
                <span>APRs</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Riscos Identificados</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-user-hard-hat"></i>
                <span>EPIs</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-clipboard-check"></i>
                <span>Inspeções</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-chart-bar"></i>
                <span>Relatórios</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-cog"></i>
                <span>Configurações</span>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>Dashboard de Segurança do Trabalho</h1>
                <div class="user-info">
                    <img src="" alt="Usuário">
                    <div>
                        <div style="font-weight: 500;">Adm.</div>
                        <div style="font-size: 14px; color: #6c757d;">Eng. de Segurança</div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Cards -->
            <div class="dashboard-cards">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">APRs Pendentes</div>
                        <div class="card-icon" style="background-color: #ff9800;">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="card-value">12</div>
                    <div class="card-change positive">
                        <i class="fas fa-arrow-up"></i> 2 desde a última semana
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">APRs Aprovadas</div>
                        <div class="card-icon" style="background-color: #4CAF50;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="card-value">48</div>
                    <div class="card-change positive">
                        <i class="fas fa-arrow-up"></i> 5 desde a última semana
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Riscos Críticos</div>
                        <div class="card-icon" style="background-color: #f44336;">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                    </div>
                    <div class="card-value">7</div>
                    <div class="card-change negative">
                        <i class="fas fa-arrow-down"></i> 1 desde a última semana
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Dias sem Acidentes</div>
                        <div class="card-icon" style="background-color: #2196F3;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                    <div class="card-value">127</div>
                    <div class="card-change positive">
                        <i class="fas fa-arrow-up"></i> 7 dias a mais
                    </div>
                </div>
            </div>

            <!-- Main Sections -->
            <div class="main-sections">
                <!-- Left Section - APRs Recentes -->
                <div class="section">
                    <div class="section-header">
                        <div class="section-title">APRs Recentes</div>
                        <div class="section-actions">
                            <button class="btn btn-outline">Ver Todas</button>
                            <button class="btn btn-primary">Nova APR</button>
                        </div>
                    </div>

                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Local do trabalho</th>
                                    <th>Atividade</th>
                                    <th>Responsável</th>
                                    <th>Prazo</th>
                                    <th>Prioridade</th>
                                    <th>Status</th>
                                    <th>Grau de Risco</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aprs as $apr)
                                <tr>
                                    <td>
                                        <a class="txt-link" href="{{route('apr.show',['apr_id'=>$apr->id])}}"><strong>ID APR:</strong> {{ $apr->id }}</a>
                                    </td>
                                    <td>{{ $apr->local_trabalho }}</td>
                                    <td>{{ $apr->descricao_atividade }}</td>
                                    <td>{{ $apr->responsavel}}</td>
                                    <td>{{ \Carbon\Carbon::parse($apr->prazo)->format('d/m/Y') }}</td>

                                    <td>
                                        <span class="priority {{ strtolower($apr->prioridade) }}"></span>
                                        {{ ucfirst($apr->prioridade) }}
                                    </td>

                                    <td>
                                        <span class="status {{ strtolower($apr->status) }}">
                                            {{ ucfirst($apr->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                        // Valores
                                        $probabilidade = $apr->probabilidade ?? 0;
                                        $severidade = $apr->severidade ?? 0;
                                        $nota = $probabilidade * $severidade;

                                        // Classificação
                                        if ($nota <= 2) {
                                            $class='baixo' ;
                                            $texto='Baixo' ;
                                            } elseif ($nota <=4) {
                                            $class='medio' ;
                                            $texto='Médio' ;
                                            } elseif ($nota <=8) {
                                            $class='alto' ;
                                            $texto='Alto' ;
                                            } else {
                                            $class='critico' ;
                                            $texto='Crítico' ;
                                            }
                                            @endphp

                                            <div class="mini-risk {{ $class }}">
                                            <div><strong>P:</strong> {{ $probabilidade }}</div>
                                            <div><strong>S:</strong> {{ $severidade }}</div>
                                            <div><strong>{{ $texto }}</strong> ({{ $nota }})</div>
                    </div>
                    <style>
                        .mini-risk {
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            justify-content: center;
                            padding: 5px;
                            border-radius: 5px;
                            color: #fff;
                            font-size: 12px;
                            font-weight: bold;
                        }

                        .mini-risk.baixo {
                            background-color: green;
                        }

                        .mini-risk.medio {
                            background-color: yellow;
                            color: #000;
                        }

                        .mini-risk.alto {
                            background-color: orange;
                        }

                        .mini-risk.critico {
                            background-color: red;
                        }
                    </style>
                    </td>

                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>

            </div>

            <!-- Right Section - Indicadores de Risco -->
            <div class="section">
                <div class="section-header">
                    <div class="section-title">Indicadores de Risco</div>
                    <button class="btn btn-success">Atualizar</button>
                </div>

                <div class="risk-indicators">
                    <div class="risk-item">
                        <div class="risk-info">
                            <h4>Trabalho em Altura</h4>
                            <p>5 APRs em andamento</p>
                        </div>
                        <div class="risk-level alto">Alto</div>
                    </div>

                    <div class="risk-item">
                        <div class="risk-info">
                            <h4>Espaços Confinados</h4>
                            <p>3 APRs em andamento</p>
                        </div>
                        <div class="risk-level alto">Alto</div>
                    </div>

                    <div class="risk-item">
                        <div class="risk-info">
                            <h4>Eletricidade</h4>
                            <p>8 APRs em andamento</p>
                        </div>
                        <div class="risk-level medio">Médio</div>
                    </div>

                    <div class="risk-item">
                        <div class="risk-info">
                            <h4>Produtos Químicos</h4>
                            <p>4 APRs em andamento</p>
                        </div>
                        <div class="risk-level medio">Médio</div>
                    </div>

                    <div class="risk-item">
                        <div class="risk-info">
                            <h4>Movimentação de Cargas</h4>
                            <p>6 APRs em andamento</p>
                        </div>
                        <div class="risk-level baixo">Baixo</div>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <div class="section-header" style="margin-bottom: 15px;">
                        <div class="section-title">Ações Rápidas</div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <button class="btn btn-primary" style="text-align: left; justify-content: flex-start;">
                            <i class="fas fa-plus-circle" style="margin-right: 8px;"></i> Criar Nova APR
                        </button>
                        <button class="btn btn-outline" style="text-align: left; justify-content: flex-start;">
                            <i class="fas fa-file-export" style="margin-right: 8px;"></i> Gerar Relatório Mensal
                        </button>
                        <button class="btn btn-outline" style="text-align: left; justify-content: flex-start;">
                            <i class="fas fa-bell" style="margin-right: 8px;"></i> Configurar Alertas
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>SafeWork Dashboard &copy; 2023 - Sistema de Gestão de Segurança do Trabalho</p>
            <p style="margin-top: 5px;">Última atualização: 10/08/2023 14:30</p>
        </div>
    </div>
    </div>

    <script>
        // Menu interaction
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                menuItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Button interactions
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const action = this.textContent.trim();
                if (action.includes('Nova APR')) {
                    alert('Funcionalidade: Criar nova APR. Em uma implementação real, isso abriria um formulário para criação de nova APR.');
                } else if (action.includes('Ver Todas')) {
                    alert('Funcionalidade: Listar todas as APRs. Em uma implementação real, isso navegaria para a página de listagem completa.');
                } else if (action.includes('Atualizar')) {
                    alert('Indicadores de risco atualizados!');
                }
            });
        });


        // Simulate real-time updates
        setInterval(() => {
            const currentTime = new Date();
            const timeString = currentTime.toLocaleTimeString('pt-BR', {
                hour: '2-digit',
                minute: '2-digit'
            });
            const dateString = currentTime.toLocaleDateString('pt-BR');
            document.querySelector('.footer p:last-child').textContent = `Última atualização: ${dateString} ${timeString}`;
        }, 60000); // Update every minute
    </script>
</body>

</html>