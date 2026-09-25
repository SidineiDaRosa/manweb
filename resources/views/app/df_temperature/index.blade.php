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

<div style="width:100%; height:450px;">
    <canvas id="graficoTemperatura"></canvas>
</div>

<script>
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
        const ponto4 = registros.filter(r => r.equipamento === 'ponto_4');
        const ponto5 = registros.filter(r => r.equipamento === 'ponto_5');


        // =====================================================
        // HORÁRIOS
        // =====================================================

        const labels = ponto1.map(r =>
            r.data_hora.substring(11, 19)
        );


        // =====================================================
        // GRÁFICO
        // =====================================================

        const ctx = document
            .getElementById('graficoTemperatura')
            .getContext('2d');


        new Chart(ctx, {

            type: 'line',

            data: {

                labels: labels,

                datasets: [

                    // =========================================
                    // LINHA DO PONTO 1
                    // =========================================

                    {
                        label: 'Ponto 1',

                        data: ponto1.map(r => Number(r.temperatura)),

                        borderColor: 'blue',

                        backgroundColor: 'transparent',

                        borderWidth: 1,

                        pointRadius: 2,

                        tension: 0.2,

                        fill: false
                    },


                    // =========================================
                    // LINHA DO PONTO 2
                    // =========================================

                    {
                        label: 'Ponto 2',

                        data: ponto2.map(r => Number(r.temperatura)),

                        borderColor: 'red',

                        backgroundColor: 'transparent',

                        borderWidth: 1,

                        pointRadius: 2,

                        tension: 0.2,

                        fill: false
                    },


                    // =========================================
                    // LINHA DO PONTO 3
                    // =========================================

                    {
                        label: 'Ponto 3',

                        data: ponto3.map(r => Number(r.temperatura)),

                        borderColor: 'green',

                        backgroundColor: 'transparent',

                        borderWidth: 1,

                        pointRadius: 2,

                        tension: 0.2,

                        fill: false
                    },


                    // =========================================
                    // LINHA DO PONTO 4
                    // =========================================

                    {
                        label: 'Ponto 4',

                        data: ponto4.map(r => Number(r.temperatura)),

                        borderColor: 'purple',

                        backgroundColor: 'transparent',

                        borderWidth: 1,

                        pointRadius: 2,

                        tension: 0.2,

                        fill: false
                    },


                    // =========================================
                    // LINHA DO PONTO 5
                    // =========================================

                    {
                        label: 'Ponto 5',

                        data: ponto5.map(r => Number(r.temperatura)),

                        borderColor: 'orange',

                        backgroundColor: 'transparent',

                        borderWidth: 1,

                        pointRadius: 2,

                        tension: 0.2,

                        fill: false
                    }

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

                    legend: {
                        display: true,
                        position: 'top'
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
</script>