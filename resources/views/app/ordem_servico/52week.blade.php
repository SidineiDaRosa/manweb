<style>
    .container-month {
        display: flex;
        flex-wrap: wrap;
    }

    .item-52-week {
        width: 180px;
        height: 150px;
        margin: 2px;
        padding: 2px;
        background-color: #f1f1f1;
        border: 1px solid #ddd;
        overflow: hidden;
        transition: all 0.5s ease;
        transition-delay: 0.5s;
        /* Atraso de 0.5s antes de iniciar a expansão */
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        /* Alinha o conteúdo no topo */
        position: relative;
    }

    .item-52-week.highlight {
        background-color: rgba(144, 238, 144, 0.5);
        /* Verde fraco em RGBA */
        /* Cor destaque para a semana correspondente */
    }

    .item-52-week:hover {
        width: 400px;
        height: 400px;
        background-color: #e0e0e0;
        overflow: auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .item-52-week h4 {
        margin: 0;
        position: absolute;
        top: 10px;
        /* Mantém o número no topo */
        left: 50%;
        transform: translateX(-50%);
        /* Centraliza horizontalmente */
    }

    .item-52-week ul {
        margin: 10px 0 0;
        padding: 0;
        list-style-type: none;
        text-align: left;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const weekItems = document.querySelectorAll('.item-52-week');

        weekItems.forEach(item => {
            item.addEventListener('click', function() {
                // Verifica se o item já está expandido
                const isExpanded = item.classList.contains('expanded');

                // Remove a classe expanded de todos os itens e redefine os tamanhos
                weekItems.forEach(i => {
                    i.classList.remove('expanded');
                    i.style.width = '150px'; // Redefine a largura para o tamanho original
                    i.style.height = '150px'; // Redefine a altura para o tamanho original
                });

                // Se o item não estava expandido, expande-o; se estava, não faz nada
                if (!isExpanded) {
                    item.classList.add('expanded');
                    item.style.width = '400px'; // Expande o item clicado
                    item.style.height = '400px'; // Expande o item clicado
                }
            });
        });
    });
</script>
<div class="tab-container">
    <!-- Botões das Abas -->
    <div class="tab-buttons">
        <button class="tab-btn active" data-tab="tab1">52 semanas</button>
        <button class="tab-btn" data-tab="tab2">aba2</button>
        <button class="tab-btn" data-tab="tab3">aba3</button>
    </div>

    <!-- Conteúdo das Abas -->
    <div class="tab-content active" id="tab1">
        <h3 style="font-family:Arial, Helvetica, sans-serif">3</h3>

        <div class="container-month">
            @foreach($ordens_servicos_por_semana as $week => $ordens)
            {{-- Verifique se esta é a semana que deseja destacar --}}
            <div class="item-52-week {{ $week == now()->weekOfYear ? 'highlight' : '' }}">
                <h6 style="font-family: Arial, Helvetica, sans-serif;margin-left:-1px;">{{ $week }}</h6>

                @if($ordens->isEmpty())
                <p>...</p>
                @else
                <ul style="margin-left: -20px;">
                    @foreach($ordens as $ordem)
                    <li>
                        <a class="txt-link" href="{{route('ordem-servico.show', ['ordem_servico' => $ordem->id])}}" title="Click para abrir a O.S.">{{ $ordem->id }}</a>
                        <span style="font-family:Arial, Helvetica, sans-serif;font-size:12px;">{{ \Carbon\Carbon::parse($ordem->data_inicio)->format('d/m/y') }}</span>
                        <span style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:darkblue;">{{ $ordem->equipamento->nome}}</span>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-------------------------------------------------->
<!--Aba 2 Gantt os-->
<div class="tab-content" id="tab2">

</div>
<div class="tab-content" id="tab3">

</div>
<style>
    .tab-buttons {
        margin-bottom: 10px;
    }

    .tab-btn {
        padding: 10px 15px;
        border: none;
        background-color: #eee;
        cursor: pointer;
        margin-right: 5px;
    }

    .tab-btn.active {
        background-color: #007bff;
        color: white;
    }

    .tab-content {
        display: none;
        padding: 15px;
        border: 1px solid #ccc;
        background: #f9f9f9;
    }

    .tab-content.active {
        display: block;
    }
</style>
<script>
    document.querySelectorAll('.tab-btn').forEach(button => {
        button.addEventListener('click', () => {
            // Remove 'active' de todos
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            // Adiciona 'active' no clicado
            button.classList.add('active');
            const tabId = button.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });
</script>