<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Itens do Pedido de Compra</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --light-gray: #f8f9fa;
            --medium-gray: #e9ecef;
            --dark-gray: #6c757d;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7f9;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .page-title {
            color: var(--secondary-color);
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        .page-subtitle {
            color: var(--dark-gray);
            font-size: 1.1rem;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Container geral de cada item */
        .item-card {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            align-items: flex-start;
            background-color: white;
            box-shadow: var(--box-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .item-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Cada bloco de informação */
        .item-box {
            display: flex;
            flex-direction: column;
            min-width: 120px;
            max-width: 200px;
            word-wrap: break-word;
        }

        /* Título do campo */
        .item-title {
            font-weight: bold;
            margin-bottom: 8px;
            color: var(--secondary-color);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Valor do campo */
        .item-text {
            font-size: 1rem;
            color: #444;
            font-weight: 500;
        }

        /* Imagem do produto */
        .preview-image {
            width: 100px;
            height: 100px;
            object-fit: contain;
            border: 1px solid #eee;
            border-radius: 4px;
            margin-top: 5px;
            background-color: var(--light-gray);
            padding: 5px;
        }

        .image-placeholder {
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px dashed #ccc;
            border-radius: 4px;
            background-color: var(--light-gray);
            color: var(--dark-gray);
            font-size: 0.8rem;
            text-align: center;
            padding: 10px;
        }

        /* Ações (botões) */
        .item-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            gap: 5px;
        }

        .btn-sm {
            padding: 6px 10px;
            font-size: 0.85rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid currentColor;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-outline-danger {
            color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .btn-outline-danger:hover {
            background-color: var(--danger-color);
            color: white;
        }

        .disabled {
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Status indicator */
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #ffeaa7;
            color: #d35400;
        }

        .status-approved {
            background-color: #d1f7c4;
            color: #27ae60;
        }

        .status-rejected {
            background-color: #ffcfc6;
            color: #c0392b;
        }

        /* Responsivo */
        @media (max-width: 992px) {
            .item-card {
                gap: 15px;
            }
            
            .item-box {
                min-width: calc(50% - 15px);
                max-width: calc(50% - 15px);
            }
        }

        @media (max-width: 768px) {
            .item-card {
                flex-direction: column;
                gap: 15px;
            }
            
            .item-box {
                min-width: 100%;
                max-width: 100%;
            }
            
            .item-actions {
                flex-direction: row;
                justify-content: flex-start;
                width: 100%;
            }
            
            .page-title {
                font-size: 1.8rem;
            }
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--dark-gray);
            margin-bottom: 15px;
        }

        .empty-state h3 {
            color: var(--secondary-color);
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--dark-gray);
            max-width: 500px;
            margin: 0 auto 20px;
        }

        /* Modal de confirmação */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 25px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            max-width: 500px;
            width: 100%;
        }

        .modal-header {
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 1.5rem;
            color: var(--secondary-color);
        }

        .modal-body {
            margin-bottom: 25px;
            color: #555;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Filtros e busca */
        .filters-container {
            background-color: white;
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 25px;
        }

        .filters-title {
            font-size: 1.2rem;
            color: var(--secondary-color);
            margin-bottom: 15px;
        }

        .filter-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .filter-item {
            flex: 1;
            min-width: 200px;
        }

        .filter-item label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--secondary-color);
        }

        .filter-item select, .filter-item input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .stats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            flex: 1;
            min-width: 200px;
            background-color: white;
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .stat-title {
            font-size: 0.9rem;
            color: var(--dark-gray);
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--secondary-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Itens do Pedido de Compra</h1>
            <p class="page-subtitle">Visualize e gerencie todos os itens incluídos no pedido de compra atual</p>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-title">Total de Itens</div>
                <div class="stat-value">8</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Valor Total</div>
                <div class="stat-value">R$ 2.458,75</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Status do Pedido</div>
                <div class="stat-value"><span class="status-badge status-pending">Pendente</span></div>
            </div>
        </div>

        <div class="filters-container">
            <h3 class="filters-title">Filtros e Busca</h3>
            <div class="filter-group">
                <div class="filter-item">
                    <label for="search">Buscar produto</label>
                    <input type="text" id="search" placeholder="Digite o nome do produto...">
                </div>
                <div class="filter-item">
                    <label for="status">Status</label>
                    <select id="status">
                        <option value="">Todos</option>
                        <option value="pending">Pendente</option>
                        <option value="approved">Aprovado</option>
                        <option value="rejected">Rejeitado</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label for="sort">Ordenar por</label>
                    <select id="sort">
                        <option value="name">Nome A-Z</option>
                        <option value="name-desc">Nome Z-A</option>
                        <option value="quantity">Quantidade (menor-maior)</option>
                        <option value="quantity-desc">Quantidade (maior-menor)</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="items-list">
            <!-- Item 1 -->
            <div class="item-card">
                <div class="item-box">
                    <div class="item-title">Produto ID:</div>
                    <div class="item-text">#PROD-1025</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Código Fab:</div>
                    <div class="item-text">CF-789012</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Nome:</div>
                    <div class="item-text">Placa Mãe ASUS TUF Gaming</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Unidade:</div>
                    <div class="item-text">Unidade</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Quantidade:</div>
                    <div class="item-text">3</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Status</div>
                    <div class="item-text"><span class="status-badge status-approved">Aprovado</span></div>
                </div>

                <div class="item-box">
                    <div class="item-title">Imagem:</div>
                    <img src="https://via.placeholder.com/100" alt="Imagem do Produto" class="preview-image">
                </div>

                <div class="item-box item-actions">
                    <a class="btn btn-outline btn-outline-primary btn-sm" href="#">
                        <i class="bi bi-eye"></i> Ver Detalhes
                    </a>

                    <a class="btn btn-outline btn-outline-danger btn-sm" href="#" onclick="showConfirmModal()">
                        <i class="bi bi-trash"></i> Excluir
                    </a>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="item-card">
                <div class="item-box">
                    <div class="item-title">Produto ID:</div>
                    <div class="item-text">#PROD-1048</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Código Fab:</div>
                    <div class="item-text">CF-456789</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Nome:</div>
                    <div class="item-text">Processador Intel Core i7</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Unidade:</div>
                    <div class="item-text">Unidade</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Quantidade:</div>
                    <div class="item-text">5</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Status</div>
                    <div class="item-text"><span class="status-badge status-pending">Pendente</span></div>
                </div>

                <div class="item-box">
                    <div class="item-title">Imagem:</div>
                    <div class="image-placeholder">Imagem não disponível</div>
                </div>

                <div class="item-box item-actions">
                    <a class="btn btn-outline btn-outline-primary btn-sm" href="#">
                        <i class="bi bi-eye"></i> Ver Detalhes
                    </a>

                    <a class="btn btn-outline btn-outline-danger btn-sm disabled" href="#">
                        <i class="bi bi-trash"></i> Excluir
                    </a>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="item-card">
                <div class="item-box">
                    <div class="item-title">Produto ID:</div>
                    <div class="item-text">#PROD-1097</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Código Fab:</div>
                    <div class="item-text">CF-123456</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Nome:</div>
                    <div class="item-text">Memória RAM DDR4 16GB</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Unidade:</div>
                    <div class="item-text">Unidade</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Quantidade:</div>
                    <div class="item-text">10</div>
                </div>

                <div class="item-box">
                    <div class="item-title">Status</div>
                    <div class="item-text"><span class="status-badge status-rejected">Rejeitado</span></div>
                </div>

                <div class="item-box">
                    <div class="item-title">Imagem:</div>
                    <img src="https://via.placeholder.com/100" alt="Imagem do Produto" class="preview-image">
                </div>

                <div class="item-box item-actions">
                    <a class="btn btn-outline btn-outline-primary btn-sm" href="#">
                        <i class="bi bi-eye"></i> Ver Detalhes
                    </a>

                    <a class="btn btn-outline btn-outline-danger btn-sm" href="#" onclick="showConfirmModal()">
                        <i class="bi bi-trash"></i> Excluir
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal de confirmação -->
        <div class="modal" id="confirmModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Confirmar Exclusão</h3>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir este item do pedido de compra? Esta ação não pode ser desfeita.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline" onclick="closeModal()">Cancelar</button>
                    <button class="btn btn-danger" onclick="deleteItem()">Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showConfirmModal() {
            document.getElementById('confirmModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('confirmModal').style.display = 'none';
        }

        function deleteItem() {
            alert('Item excluído com sucesso! (esta é uma simulação)');
            closeModal();
        }

        // Fechar modal clicando fora dele
        window.onclick = function(event) {
            const modal = document.getElementById('confirmModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        // Filtros e busca (funcionalidade básica)
        document.getElementById('search').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const items = document.querySelectorAll('.item-card');
            
            items.forEach(item => {
                const productName = item.querySelector('.item-text').textContent.toLowerCase();
                if (productName.includes(searchText)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>