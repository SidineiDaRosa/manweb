<!-- Bootstrap CDN -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Chart.js CDN -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<h4>Lituras de temperatura do papel</h4>
<div class="row g-3 align-items-end mb-4">


    <form action="{{ route('df_temperatura.filtro') }}" method="GET">

        <div class="row g-3 align-items-end mb-4">

            <div class="col-md-3">
                <label for="dataInicio" class="form-label">
                    Data/hora início
                </label>

                <input type="datetime-local"
                    name="data_inicio"
                    id="dataInicio"
                    class="form-control"
                    value="{{ request('data_inicio') }}"
                    required>
            </div>

            <div class="col-md-3">
                <label for="dataFim" class="form-label">
                    Data/hora fim
                </label>

                <input type="datetime-local"
                    name="data_fim"
                    id="dataFim"
                    class="form-control"
                    value="{{ request('data_fim') }}"
                    required>
            </div>

            <div class="col-md-auto">
                <button type="submit" class="btn btn-primary">
                    Filtrar
                </button>
            </div>

        </div>
    </form>
</div>
<div style="margin-bottom: 15px; display: flex; gap: 20px; font-family: sans-serif;">
    <label><input type="checkbox" checked onchange="alternarLinhaCheckbox(0, this)"> Ponto 1</label>
    <label><input type="checkbox" checked onchange="alternarLinhaCheckbox(1, this)"> Ponto 2</label>
    <label><input type="checkbox" checked onchange="alternarLinhaCheckbox(2, this)"> Ponto 3</label>
</div>


<div style="width:100%; height:450px;">
    <canvas id="graficoTemperatura"></canvas>
</div>

<div style="width:100%; height:450px;">
    <canvas id="graficoTemperatura"></canvas>
</div>
<script>
    // Variável global para guardar o gráfico e ser acessada pela função do checkbox
    let meuGrafico;
    
    document.addEventListener('DOMContentLoaded', function() {

        // Dados vindos do Laravel
        const dados = @json($df_temperatures);

        // Converte para array
        const registros = Object.values(dados);

        // Ordena por data/hora
        registros.sort((a, b) =>
            new Date(a.data_hora.replace(' ', 'T')) -
            new Date(b.data_hora.replace(' ', 'T'))
        );


        // =====================================================
        // SEPARA OS 5 PONTOS
        // =====================================================

        const ponto1 = registros.filter(r => r.equipamento === 'ponto_1');
        const ponto2 = registros.filter(r => r.equipamento === 'ponto_2');
        const ponto3 = registros.filter(r => r.equipamento === 'ponto_3');

        // =====================================================
        // HORÁRIOS (Data e Hora)
        // =====================================================

        const labels = ponto1.map(r => {
            const dataIso = r.data_hora.substring(0, 10); // Pega "YYYY-MM-DD"
            const horaMinuto = r.data_hora.substring(11, 16); // Pega "HH:MM"

            const [ano, mes, dia] = dataIso.split('-');
            return `${dia}/${mes} ${horaMinuto}`; // Exemplo: "28/09 14:30"
        });


        // =====================================================
        // GRÁFICO
        // =====================================================

        const ctx = document
            .getElementById('graficoTemperatura')
            .getContext('2d');

        // CORREÇÃO AQUI: Salvando a instância na variável global 'meuGrafico'
        meuGrafico = new Chart(ctx, {

            type: 'line',

            data: {

                labels: labels,

                datasets: [

                    // =========================================
                    // LINHA DO PONTO 1 (Índice 0)
                    // =========================================

                    {
                        label: 'Ponto 1',

                        data: ponto1.map(r => Number(r.temperatura)),

                        borderColor: 'blue',

                        backgroundColor: 'transparent',

                        borderWidth: 1,

                        pointRadius: 1,

                        tension: 0.2,

                        fill: false
                    },


                    // =========================================
                    // LINHA DO PONTO 2 (Índice 1)
                    // =========================================

                    {
                        label: 'Ponto 2',

                        data: ponto2.map(r => Number(r.temperatura)),

                        borderColor: 'red',

                        backgroundColor: 'transparent',

                        borderWidth: 1,

                        pointRadius: 1,

                        tension: 0.2,

                        fill: false
                    },


                    // =========================================
                    // LINHA DO PONTO 3 (Índice 2)
                    // =========================================

                    {
                        label: 'Ponto 3',

                        data: ponto3.map(r => Number(r.temperatura)),

                        borderColor: 'green',

                        backgroundColor: 'transparent',

                        borderWidth: 1,

                        pointRadius: 1,

                        tension: 0.2,

                        fill: false
                    },


                ]
            },


            options: {

                responsive: true,

                maintainAspectRatio: false,

                interaction: {
                    mode: 'index',
                    intersect: false
                },

                plugins: {

                    // Escondendo a legenda nativa para usar apenas as suas caixas HTML
                    legend: {
                        display: false
                    },

                    tooltip: {

                        callbacks: {

                            label: function(context) {

                                return context.dataset.label +
                                    ': ' +
                                    context.parsed.y +
                                    ' °C';

                            }

                        }

                    }

                },


                scales: {

                    x: {

                        title: {
                            display: true,
                            text: 'Horário'
                        }

                    },

                    y: {

                        title: {
                            display: true,
                            text: 'Temperatura (°C)'
                        },

                        beginAtZero: false

                    }

                }

            }

        });

    });

    // =====================================================
    // FUNÇÃO PARA CONTROLAR O GRÁFICO PELO CHECKBOX
    // =====================================================
    function alternarLinhaCheckbox(datasetIndex, elementoCheckbox) {
        if (!meuGrafico) return;

        if (elementoCheckbox.checked) {
            meuGrafico.show(datasetIndex); // Se marcou, mostra a linha
        } else {
            meuGrafico.hide(datasetIndex); // Se desmarcou, esconde a linha
        }
    }
</script>
