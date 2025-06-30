@extends('layouts.app')

@section('content')

<h2>Gráfico Gantt com filtro e dados dinâmicos</h2>

<!-- Formulário de filtro -->
<div style="margin: 15px 0; display: flex; gap: 15px; flex-wrap: wrap; align-items: center;">
  <label>
    Data Início OS:
    <input type="date" id="inicioOs" value="{{ request('data_inicio', $inicio->format('Y-m-d')) }}" />
  </label>
  <label>
    Data Fim OS:
    <input type="date" id="fimOs" value="{{ request('data_fim', $inicio->copy()->addDays($diasIntervalo - 1)->format('Y-m-d')) }}" />
  </label>
  <label>
    Data Início Gráfico:
    <input type="date" id="inicioGrafico" value="{{ $inicio->format('Y-m-d') }}" />
  </label>
  <label>
    Data Fim Gráfico:
    <input type="date" id="fimGrafico" value="{{ $inicio->copy()->addDays($diasIntervalo - 1)->format('Y-m-d') }}" />
  </label>

  <button id="btnAtualizarGrafico" style="padding: 5px 10px;">Atualizar Gráfico</button>
  <button id="btnBuscarBanco" style="padding: 5px 10px;">Buscar no Banco</button>
</div>

<!-- Container do gráfico -->
<div id="gantt-container"></div>

<script>
  // Dados já vindos do backend na primeira carga
  let tarefas = @json($tarefas);
  let dataInicio = new Date("{{ $inicio->format('Y-m-d') }}");
  let totalDias = {{ $diasIntervalo }};

  const ganttContainer = document.getElementById('gantt-container');

  function criarGrafico(tarefas, dataInicio, totalDias) {
    ganttContainer.innerHTML = '';

    // Cabeçalho dos dias
    const cabecalho = document.createElement('div');
    cabecalho.classList.add('cabecalho-dias');
    for (let i = 0; i < totalDias; i++) {
      const dia = new Date(dataInicio);
      dia.setDate(dia.getDate() + i);
      const diaDiv = document.createElement('div');
      diaDiv.classList.add('celula-dia');
      diaDiv.textContent = dia.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit' });
      cabecalho.appendChild(diaDiv);
    }
    ganttContainer.appendChild(cabecalho);

    tarefas.forEach(tarefa => {
      const linha = document.createElement('div');
      linha.classList.add('gantt-row');

      const info = document.createElement('div');
      info.classList.add('coluna-info');
      info.innerHTML = `
        <div><strong>ID:</strong> ${tarefa.id}</div>
        <div><strong>Responsável:</strong> ${tarefa.responsavel}</div>
      `;
      linha.appendChild(info);

      const detalhe = document.createElement('div');
      detalhe.classList.add('gantt-detalhes');

      for (let i = 0; i < totalDias; i++) {
        const celula = document.createElement('div');
        celula.classList.add('celula-dia');
        detalhe.appendChild(celula);
      }

      const barra = document.createElement('div');
      barra.classList.add('bar');

      const leftPercent = (tarefa.dia_inicio / totalDias) * 100;
      const widthPercent = (tarefa.duracao_dias / totalDias) * 100;

      barra.style.left = `${leftPercent}%`;
      barra.style.width = `${widthPercent}%`;

      // Cor por equipamento (pode adaptar conforme dados)
      const corEquipamento = {
        'Trator': '#4caf50',
        'Colheitadeira': '#ff9800',
        'Irrigador': '#2196f3'
      };

      barra.style.backgroundColor = corEquipamento[tarefa.equipamento] || '#777';

      barra.textContent = `OS ${tarefa.id}`;
      detalhe.appendChild(barra);

      linha.appendChild(detalhe);
      ganttContainer.appendChild(linha);
    });
  }

  // Inicializa gráfico
  criarGrafico(tarefas, dataInicio, totalDias);

  // Atualiza gráfico local (só altera intervalo gráfico, não dados)
  document.getElementById('btnAtualizarGrafico').addEventListener('click', () => {
    const inicioGrafico = document.getElementById('inicioGrafico').value;
    const fimGrafico = document.getElementById('fimGrafico').value;

    if (!inicioGrafico || !fimGrafico) {
      alert('Preencha as datas do intervalo do gráfico.');
      return;
    }
    if (inicioGrafico > fimGrafico) {
      alert('Data Início Gráfico deve ser menor ou igual à Data Fim Gráfico.');
      return;
    }

    dataInicio = new Date(inicioGrafico);
    totalDias = (new Date(fimGrafico) - new Date(inicioGrafico)) / (1000*60*60*24) + 1;

    criarGrafico(tarefas, dataInicio, totalDias);
  });

  // Busca dados filtrados no backend e atualiza gráfico
  document.getElementById('btnBuscarBanco').addEventListener('click', () => {
    const inicioOs = document.getElementById('inicioOs').value;
    const fimOs = document.getElementById('fimOs').value;
    const inicioGrafico = document.getElementById('inicioGrafico').value;
    const fimGrafico = document.getElementById('fimGrafico').value;

    if (!inicioOs || !fimOs || !inicioGrafico || !fimGrafico) {
      alert('Preencha todas as datas antes de buscar.');
      return;
    }
    if (inicioOs > fimOs) {
      alert('Data Início OS deve ser menor ou igual à Data Fim OS.');
      return;
    }
    if (inicioGrafico > fimGrafico) {
      alert('Data Início Gráfico deve ser menor ou igual à Data Fim Gráfico.');
      return;
    }

    // Exemplo: rota que retorna JSON com as tarefas filtradas (você adapta a rota)
    fetch(`/rota-para-filtrar-gantt?data_inicio=${inicioOs}&data_fim=${fimOs}`)
      .then(res => {
        if (!res.ok) throw new Error('Erro na requisição');
        return res.json();
      })
      .then(data => {
        tarefas = data.tarefas;
        dataInicio = new Date(inicioGrafico);
        totalDias = (new Date(fimGrafico) - new Date(inicioGrafico)) / (1000*60*60*24) + 1;
        criarGrafico(tarefas, dataInicio, totalDias);
      })
      .catch(() => alert('Erro ao buscar dados do servidor'));
  });
</script>

<style>
  /* Mantenha seus estilos do Gantt aqui (igual seu código anterior) */
  .cabecalho-dias {
    display: flex;
    position: sticky;
    top: 0;
    background: #ddd;
    border-bottom: 2px solid #444;
    height: 40px;
    margin-left: 300px;
    z-index: 10;
  }
  .cabecalho-dias .celula-dia {
    flex: 1;
    border-right: 1px solid #999;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 12px;
    box-sizing: border-box;
    height: 100%;
  }
  .gantt-row {
    display: flex;
    width: 100%;
    border-bottom: 1px solid #ccc;
    min-height: 80px;
  }
  .coluna-info {
    width: 300px;
    flex-shrink: 0;
    background-color: #f9f9f9;
    padding: 10px;
    box-sizing: border-box;
    border-right: 1px solid #ccc;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .gantt-detalhes {
    width: 100%;
    display: flex;
    position: relative;
    height: 80px;
    background: #f0f0f0;
  }
  .gantt-detalhes .celula-dia {
    flex: 1;
    height: 80px;
    border-right: 1px dotted #666;
    box-sizing: border-box;
    text-align: center;
    line-height: 80px;
    font-size: 12px;
    background: #eaeaea;
    position: relative;
  }
  .bar {
    position: absolute;
    top: 25px;
    height: 30px;
    color: white;
    border-radius: 4px;
    padding: 5px;
    font-size: 12px;
    text-align: center;
    white-space: nowrap;
  }
</style>

@endsection
