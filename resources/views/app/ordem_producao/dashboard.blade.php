<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Controle de Produção</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: rgba(44, 62, 80, 1);
            --secondary: #3498db;
            --success: #2ecc71;
            --warning: #f39c12;
            --danger: #e74c3c;
            --light: #ecf0f1;
            --dark: #34495e;
            --gray: #95a5a6;
            --sidebar-width: 250px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            overflow-x: hidden;
        }
        
        .dashboard {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            background: linear-gradient(180deg, var(--primary) 0%, #1a2530 100%);
            color: white;
            padding: 20px 0;
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 1000;
            box-shadow: 3px 0 10px rgba(0,0,0,0.1);
        }
        
        .logo {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo h1 {
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo i {
            color: var(--secondary);
        }
        
        .menu {
            list-style: none;
        }
        
        .menu li {
            margin-bottom: 5px;
        }
        
        .menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            position: relative;
        }
        
        .menu a:hover, .menu a.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
            border-left: 4px solid var(--secondary);
        }
        
        .menu i {
            width: 20px;
            text-align: center;
        }
        
        .menu .badge {
            background-color: var(--secondary);
            color: white;
            border-radius: 10px;
            padding: 2px 8px;
            font-size: 0.7rem;
            margin-left: auto;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .header h2 {
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box input {
            padding: 8px 15px 8px 35px;
            border: 1px solid #ddd;
            border-radius: 20px;
            width: 200px;
            font-size: 0.9rem;
        }
        
        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .notification {
            position: relative;
            cursor: pointer;
        }
        
        .notification i {
            font-size: 1.2rem;
            color: var(--dark);
        }
        
        .notification .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary);
            cursor: pointer;
        }
        
        /* Cards */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            border-left: 4px solid var(--secondary);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .card-title {
            font-size: 0.9rem;
            color: var(--gray);
            font-weight: 500;
        }
        
        .card-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .card-content {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .card-footer {
            font-size: 0.8rem;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .card-footer.positive {
            color: var(--success);
        }
        
        .card-footer.negative {
            color: var(--danger);
        }
        
        /* Charts */
        .charts {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .chart-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        
        .chart-title {
            font-size: 1.1rem;
            margin-bottom: 15px;
            color: var(--primary);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .chart-actions {
            display: flex;
            gap: 10px;
        }
        
        .chart-actions button {
            background: none;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 10px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .chart-actions button:hover {
            background-color: #f5f5f5;
        }
        
        .chart-actions button.active {
            background-color: var(--secondary);
            color: white;
            border-color: var(--secondary);
        }
        
        /* Table */
        .table-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background-color: #f8f9fa;
            color: var(--primary);
            font-weight: 600;
            position: sticky;
            top: 0;
        }
        
        tr:hover {
            background-color: #f8f9fa;
        }
        
        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status.processing {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status.completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status.delayed {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status.pending {
            background-color: #e2e3e5;
            color: #383d41;
        }
        
        .progress-bar {
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 5px;
        }
        
        .progress {
            height: 100%;
            border-radius: 3px;
        }
        
        .progress-high {
            background-color: var(--success);
        }
        
        .progress-medium {
            background-color: var(--warning);
        }
        
        .progress-low {
            background-color: var(--danger);
        }
        
        /* Alert */
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .alert-warning {
            background-color: #fff3cd;
            border-left: 4px solid var(--warning);
            color: #856404;
        }
        
        .alert i {
            font-size: 1.5rem;
        }
        
        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 15px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            text-decoration: none;
            color: var(--dark);
            transition: all 0.3s;
        }
        
        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 10px rgba(0,0,0,0.1);
            color: var(--primary);
        }
        
        .action-btn i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--secondary);
        }
        
        .action-btn span {
            font-weight: 600;
            text-align: center;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            color: var(--gray);
            font-size: 0.9rem;
            border-top: 1px solid #eee;
            margin-top: 30px;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .charts {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .menu-toggle {
                display: block;
            }
        }
        
        @media (max-width: 768px) {
            .cards {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .header-actions {
                width: 100%;
                justify-content: space-between;
            }
            
            .search-box input {
                width: 150px;
            }
        }
        
        @media (max-width: 480px) {
            .quick-actions {
                grid-template-columns: 1fr 1fr;
            }
            
            .header-actions {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <h1><i class="fas fa-industry"></i> Fábrica Pro</h1>
                <button class="menu-toggle close-sidebar"><i class="fas fa-times"></i></button>
            </div>
            <ul class="menu">
                <li><a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#"><i class="fas fa-cogs"></i> Linhas de Produção <span class="badge">3</span></a></li>
                <li><a href="#"><i class="fas fa-clipboard-list"></i> Ordens de Produção <span class="badge">18</span></a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i> Relatórios</a></li>
                <li><a href="#"><i class="fas fa-boxes"></i> Estoque <span class="badge">5</span></a></li>
                <li><a href="#"><i class="fas fa-tools"></i> Manutenção <span class="badge">2</span></a></li>
                <li><a href="#"><i class="fas fa-users"></i> Equipe</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Configurações</a></li>
            </ul>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <button class="menu-toggle open-sidebar"><i class="fas fa-bars"></i></button>
                <h2><i class="fas fa-tachometer-alt"></i> Dashboard de Controle de Produção</h2>
                <div class="header-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Pesquisar...">
                    </div>
                    <div class="notification">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </div>
                    <div class="user-info">
                        <div class="user-avatar">JS</div>
                        <span>João Silva</span>
                    </div>
                </div>
            </div>
            
            <!-- Alert -->
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>Atenção:</strong> A Linha 2 está operando abaixo da capacidade esperada. Verifique possíveis problemas.
                </div>
            </div>
            
            <!-- Cards -->
            <div class="cards">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Produção Hoje</div>
                        <div class="card-icon" style="background-color: var(--secondary);">
                            <i class="fas fa-cogs"></i>
                        </div>
                    </div>
                    <div class="card-content">1,248 unidades</div>
                    <div class="card-footer positive">
                        <i class="fas fa-arrow-up"></i> 12% em relação a ontem
                    </div>
                    <div class="progress-bar">
                        <div class="progress progress-high" style="width: 92%"></div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Eficiência</div>
                        <div class="card-icon" style="background-color: var(--success);">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="card-content">94.2%</div>
                    <div class="card-footer positive">
                        <i class="fas fa-arrow-up"></i> 2.5% em relação ao mês passado
                    </div>
                    <div class="progress-bar">
                        <div class="progress progress-high" style="width: 94%"></div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Tempo Médio de Ciclo</div>
                        <div class="card-icon" style="background-color: var(--warning);">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="card-content">3.2 min</div>
                    <div class="card-footer negative">
                        <i class="fas fa-arrow-up"></i> 0.3 min acima da meta
                    </div>
                    <div class="progress-bar">
                        <div class="progress progress-medium" style="width: 85%"></div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Ordens em Andamento</div>
                        <div class="card-icon" style="background-color: var(--danger);">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                    <div class="card-content">18</div>
                    <div class="card-footer">
                        5 ordens concluídas hoje
                    </div>
                    <div class="progress-bar">
                        <div class="progress progress-low" style="width: 65%"></div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="#" class="action-btn">
                    <i class="fas fa-plus-circle"></i>
                    <span>Nova Ordem</span>
                </a>
                <a href="#" class="action-btn">
                    <i class="fas fa-chart-pie"></i>
                    <span>Relatório Diário</span>
                </a>
                <a href="#" class="action-btn">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Alertas</span>
                </a>
                <a href="#" class="action-btn">
                    <i class="fas fa-cog"></i>
                    <span>Configurações</span>
                </a>
            </div>
            
            <!-- Charts -->
            <div class="charts">
                <div class="chart-container">
                    <h3 class="chart-title">
                        Produção por Linha (Últimos 7 dias)
                        <div class="chart-actions">
                            <button class="active">Semana</button>
                            <button>Mês</button>
                            <button>Trimestre</button>
                        </div>
                    </h3>
                    <canvas id="productionChart"></canvas>
                </div>
                
                <div class="chart-container">
                    <h3 class="chart-title">Distribuição de Defeitos</h3>
                    <canvas id="defectsChart"></canvas>
                </div>
            </div>
            
            <!-- Table -->
            <div class="table-container">
                <h3 class="chart-title">
                    Ordens de Produção em Andamento
                    <div class="chart-actions">
                        <button class="active">Todas</button>
                        <button>Prioritárias</button>
                        <button>Atrasadas</button>
                    </div>
                </h3>
                <table>
                    <thead>
                        <tr>
                            <th>Ordem #</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Linha</th>
                            <th>Progresso</th>
                            <th>Início</th>
                            <th>Previsão</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#OP-2023-0876</td>
                            <td>Componente A</td>
                            <td>500</td>
                            <td>Linha 3</td>
                            <td>
                                <div>85%</div>
                                <div class="progress-bar">
                                    <div class="progress progress-high" style="width: 85%"></div>
                                </div>
                            </td>
                            <td>08:00</td>
                            <td>16:30</td>
                            <td><span class="status processing">Em Andamento</span></td>
                        </tr>
                        <tr>
                            <td>#OP-2023-0875</td>
                            <td>Componente B</td>
                            <td>300</td>
                            <td>Linha 1</td>
                            <td>
                                <div>72%</div>
                                <div class="progress-bar">
                                    <div class="progress progress-medium" style="width: 72%"></div>
                                </div>
                            </td>
                            <td>07:30</td>
                            <td>15:45</td>
                            <td><span class="status processing">Em Andamento</span></td>
                        </tr>
                        <tr>
                            <td>#OP-2023-0874</td>
                            <td>Produto X</td>
                            <td>200</td>
                            <td>Linha 2</td>
                            <td>
                                <div>45%</div>
                                <div class="progress-bar">
                                    <div class="progress progress-low" style="width: 45%"></div>
                                </div>
                            </td>
                            <td>09:15</td>
                            <td>17:20</td>
                            <td><span class="status delayed">Atrasada</span></td>
                        </tr>
                        <tr>
                            <td>#OP-2023-0873</td>
                            <td>Componente C</td>
                            <td>400</td>
                            <td>Linha 4</td>
                            <td>
                                <div>60%</div>
                                <div class="progress-bar">
                                    <div class="progress progress-medium" style="width: 60%"></div>
                                </div>
                            </td>
                            <td>10:00</td>
                            <td>18:00</td>
                            <td><span class="status processing">Em Andamento</span></td>
                        </tr>
                        <tr>
                            <td>#OP-2023-0872</td>
                            <td>Produto Y</td>
                            <td>150</td>
                            <td>Linha 5</td>
                            <td>
                                <div>100%</div>
                                <div class="progress-bar">
                                    <div class="progress progress-high" style="width: 100%"></div>
                                </div>
                            </td>
                            <td>06:45</td>
                            <td>14:30</td>
                            <td><span class="status completed">Concluída</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="footer">
                <p>Dashboard de Controle de Produção &copy; 2023 - Fábrica Pro</p>
            </div>
        </main>
    </div>

    <script>
        // Gráfico de Produção
        const productionCtx = document.getElementById('productionChart').getContext('2d');
        const productionChart = new Chart(productionCtx, {
            type: 'bar',
            data: {
                labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
                datasets: [
                    {
                        label: 'Linha 1',
                        data: [320, 350, 380, 400, 420, 300, 280],
                        backgroundColor: '#3498db',
                        borderColor: '#2980b9',
                        borderWidth: 1
                    },
                    {
                        label: 'Linha 2',
                        data: [280, 300, 320, 350, 380, 320, 300],
                        backgroundColor: '#2ecc71',
                        borderColor: '#27ae60',
                        borderWidth: 1
                    },
                    {
                        label: 'Linha 3',
                        data: [250, 270, 300, 320, 350, 280, 260],
                        backgroundColor: '#f39c12',
                        borderColor: '#d35400',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Unidades Produzidas'
                        }
                    }
                }
            }
        });
        
        // Gráfico de Defeitos
        const defectsCtx = document.getElementById('defectsChart').getContext('2d');
        const defectsChart = new Chart(defectsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Dimensional', 'Superfície', 'Funcional', 'Montagem', 'Embalagem'],
                datasets: [{
                    data: [35, 25, 20, 15, 5],
                    backgroundColor: [
                        '#e74c3c',
                        '#f39c12',
                        '#3498db',
                        '#2ecc71',
                        '#9b59b6'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        // Menu toggle para mobile
        document.querySelector('.open-sidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.add('active');
        });
        
        document.querySelector('.close-sidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.remove('active');
        });
        
        // Simular atualização de dados em tempo real
        setInterval(function() {
            // Atualizar alguns valores aleatórios nos cards
            const productionValue = document.querySelector('.card:nth-child(1) .card-content');
            const efficiencyValue = document.querySelector('.card:nth-child(2) .card-content');
            
            // Simular pequenas variações nos valores
            const currentProduction = parseInt(productionValue.textContent);
            const currentEfficiency = parseFloat(efficiencyValue.textContent);
            
            const newProduction = currentProduction + Math.floor(Math.random() * 10) - 3;
            const newEfficiency = currentEfficiency + (Math.random() * 0.5) - 0.2;
            
            productionValue.textContent = newProduction.toLocaleString() + ' unidades';
            efficiencyValue.textContent = newEfficiency.toFixed(1) + '%';
            
            // Atualizar barras de progresso
            const progressBars = document.querySelectorAll('.progress');
            progressBars.forEach(bar => {
                const currentWidth = parseInt(bar.style.width);
                const variation = Math.floor(Math.random() * 5) - 2;
                const newWidth = Math.max(10, Math.min(100, currentWidth + variation));
                bar.style.width = newWidth + '%';
            });
        }, 5000);
    </script>
</body>
</html>