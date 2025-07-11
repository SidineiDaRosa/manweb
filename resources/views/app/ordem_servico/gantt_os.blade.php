@extends('app.layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gantt com intervalo dinâmico e cores cinza</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body,
    html {
      margin: 0;
      padding: 0;
      height: 100vh;
      font-family: Arial, sans-serif;
      background: #ddd;
      color: #333;
    }

    #container {
      display: flex;
      flex-direction: column;
      height: 100vh;
      overflow: hidden;
    }

    #intervalo {
      padding: 10px;
      background: #eee;
      border-bottom: 1px solid #ccc;
      display: flex;
      gap: 10px;
      align-items: center;
      font-size: 14px;
    }

    #intervalo label {
      font-weight: bold;
    }

    /* inputs para selecionar o intervalo*/
    #intervalo input[type="datetime-local"] {
      padding: 4px 6px;
      font-size: 14px;
      border: 1px solid #aaa;
      border-radius: 4px;
    }

    #data-tasks {
      display: flex;
      flex-direction: column;
      flex: 1;
      overflow: hidden;

    }

    .linha-tarefa-container {
      display: flex;
      width: 100%;
      height: 40px;
      border-bottom: 1px solid #bbb;

    }

    /* Div que engloba todos os dados das os*/
    .dados {
      width: 510px;
      padding: 8px 10px;
      background: rgb(243, 242, 242);
      display: flex;
      align-items: center;
      border-right: 1px solid #bbb;
      color: #444;
    }

    /*  Dados da O.S*/
    .registro {
      font-size: 14px;
    }

    /* Div que contem os gráficos de barras */
    .timeline-container {
      flex: 1;
      position: relative;
      overflow-x: auto;
      /* <- Habilita a rolagem horizontal */
      background: rgb(248, 246, 246);
      white-space: nowrap;
      /* Impede quebra de linha horizontal */
    }

    .timeline-years {
      display: flex;
      background: rgb(224, 217, 217);
      color: #444;
      font-weight: bold;
      border-bottom: 1px solid #aaa;
      height: 25px;
      line-height: 25px;
      user-select: none;
    }

    .year {
      text-align: center;
      border-left: 1px solid #999;
      flex-shrink: 0;
      padding: 0 10px;
      font-size: 14px;
    }

    .year:first-child {
      border-left: none;
    }

    .timeline-months {
      display: flex;
      background: #d6d6d6;
      color: #555;
      font-weight: bold;
      border-bottom: 1px solid #999;
      height: 30px;
      line-height: 30px;
      user-select: none;
    }

    .month {
      text-align: center;
      border-left: 1px solid #999;
      flex-shrink: 0;
      padding: 0 10px;
      font-size: 16px;
    }

    .month:first-child {
      border-left: none;
    }

    /* =========Dias===========*/
    .timeline-days {
      display: flex;
      background: #ccc;
      color: #444;
      font-weight: 300;
      border-bottom: 1px solid #999;
      height: 25px;
      line-height: 25px;
      user-select: none;
    }

    .day {
      text-align: center;
      border-left: 1px solid #999;
      flex-shrink: 0;
      padding: 0 6px;
      font-size: 12px;
    }

    .day:first-child {
      border-left: none;
    }

    /*==========================*/
    .timeline-header {
      display: flex;
      background: #eaeaea;
      border-bottom: 1px solid #ccc;
      z-index: 10;
      height: 40px;
    }

    .hora {
      line-height: 40px;
      text-align: center;
      border-left: 1px solid #999;
      font-size: 14px;
      user-select: none;
      color: #555;
    }

    .hora:first-child {
      border-left: none;
    }

    .grid {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      pointer-events: none;
      display: flex;
    }

    .grid-line {
      border-left: 1px dotted #aaa;
      height: 100%;
      flex-shrink: 0;
    }

    .timeline-body {
      position: relative;
    }

    .registro-barra {
      position: absolute;
      height: 30px;
      background-color: #6ca06c;
      border-radius: 4px;
      top: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .registro-barra:hover {
      background-color: #4f7a4f;
    }

    /* Modal styles */
    #modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 999;
      display: none;
    }

    #modal-overlay {
      position: absolute;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
    }

    #modal-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #fefefe;
      padding: 20px;
      border-radius: 6px;
      min-width: 320px;
      color: #000;
      z-index: 1000;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
    }

    #modal-content h2 {
      margin: 0 0 2px 0;
      display: inline-block;
    }

    #btn-fechar {
      float: right;
      background: none;
      border: none;
      font-size: 22px;
      cursor: pointer;
      line-height: 1;
      padding: 0;
      color: #888;
      transition: color 0.3s ease;
    }

    #btn-fechar:hover {
      color: #444;
    }

    #modal-content input {
      width: 100%;
      box-sizing: border-box;
      padding: 6px 8px;
      font-size: 14px;
      margin-top: 4px;
      margin-bottom: 1px;
    }

    #modal-content button {
      margin-top: 5px;
      padding: 5px 14px;
      font-size: 14px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    #btn-salvar {
      background-color: #4caf50;
      color: white;
      margin-right: 10px;
    }

    #btn-salvar:hover {
      background-color: #3e8e41;
    }

    #btn-cancelar {
      background-color: #ccc;
      color: #333;
    }

    #btn-cancelar:hover {
      background-color: #bbb;
    }

    #form-editar label {
      display: block;
      margin-top: 5px;
      margin-bottom: 0px;
      font-weight: 400;

    }

    #form-editar input,
    #form-editar textarea {
      width: 100%;
      box-sizing: border-box;
      padding: 6px 8px;
      font-size: 14px;
      margin-top: 4px;
    }

    .status-badge {
      position: absolute;
      top: 2px;
      left: 4px;
      font-size: 11px;
      font-weight: bold;
      padding: 1px 5px;
      border-radius: 4px;
      color: #fff;
    }
  </style>
</head>

<body>
  <div id="container">
    <div id="intervalo" style="margin-left:480px">
      <label for="inicio">Início:</label>
      <input class="form-control w-25" type="datetime-local" id="inicio" /> <br>
      <label for="fim">Fim:</label>
      <input class="form-control w-25" type="datetime-local" id="fim" />
      <button class="btn btn-primary btn-sm" id="btnAtualizar">Atualizar</button>
      <button class="btn btn-outline-dark btn-sm"
        onclick="window.open('{{ route('equipamento.index', ['empresa'=>2]) }}', '_blank')">
        Ativos->Nova O.S.
      </button>
    </div>

    <div id="data-tasks">
      <div style="display: flex; width: 100%;">
        <div style="width: 480px; background: #f5f5f5; border-right: 1px solid #bbb;">
          <h5>Dados da O.S.</h5>
        </div>

        <div class="timeline-container" id="timeline-container">
          <div class="timeline-years" id="timeline-years"></div>
          <div class="timeline-months" id="timeline-months"></div>
          <div class="timeline-days" id="timeline-days"></div>
          <div class="timeline-header" id="timeline-header"></div>
        </div>
      </div>
      <div id="tarefas-container" style="flex: 1; overflow-y: auto;"></div>
    </div>
  </div>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Modal -->
  <div id="modal">
    <div id="modal-overlay"></div>
    <div id="modal-content">
      <button id="btn-fechar" aria-label="Fechar modal">×</button>
      <form id="form-editar">
        <input class="form-control" id="modal-id" readonly />
        <label for="modal-responsavel">Responsável:</label>
        <input class="form-control" type="text" id="modal-responsavel" required readonly />
        <label for="modal-equipamento">Equipamento:</label>
        <input class="form-control" type="text" id="modal-equipamento" readonly />
        <label for="modal-inicio">Início:</label>
        <input class="form-control" type="datetime-local" id="modal-inicio" required />
        <label for="modal-fim">Fim:</label>
        <input class="form-control" type="datetime-local" id="modal-fim" required />
        <label for="modal-inicio">Status:</label>
        <div style="display: flex;flex-direction:row;"><input class="form-control" style="width: 60px;" type="number" id="modal-status" required />%
          &nbsp &nbsp &nbsp
          <select class="form-control" style="width: 200px;" id="modal-situacao" required>
            <option value="aberto">Aberto</option>
            <option value="em andamento">Em andamento</option>
            <option value="pausado">Pausado</option>
          </select>
        </div>


        <label for="modal-descricao">Descrição:</label>

        <textarea class="form-control" style="font-family:Arial, Helvetica, sans-serif;height:auto;" id="modal-descricao" rows="5" required></textarea>

        <div style="margin-top: 15px; display: flex; justify-content: flex-end;">
          <button type="submit" id="btn-salvar">Salvar</button>
          <button type="button" id="btn-cancelar">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Script que gera o gráfico de gantt -->
  <script>
    const tarefas = @json($ordens);
    const mesesNomes = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

    const inputInicio = document.getElementById('inicio');
    const inputFim = document.getElementById('fim');
    const btnAtualizar = document.getElementById('btnAtualizar');

    const timelineYears = document.getElementById('timeline-years');
    const timelineMonths = document.getElementById('timeline-months');
    const timelineHeader = document.getElementById('timeline-header');
    const tarefasContainer = document.getElementById('tarefas-container');

    // Modal elements
    const modal = document.getElementById('modal');
    const modalOverlay = document.getElementById('modal-overlay');
    const modalId = document.getElementById('modal-id');
    const modalResp = document.getElementById('modal-responsavel');
    const modalInicio = document.getElementById('modal-inicio');
    const modalFim = document.getElementById('modal-fim');
    const modalStatus = document.getElementById('modal-status'); //Satus do seviço
    const modalSituacao = document.getElementById('modal-situacao'); //Satus da os estado
    const modalDescricao = document.getElementById('modal-descricao');
    const modalEquipamento = document.getElementById('modal-equipamento');
    const btnCancelar = document.getElementById('btn-cancelar');
    const btnFechar = document.getElementById('btn-fechar');
    const formEditar = document.getElementById('form-editar');

    function abrirModal(tarefa) {
      modalId.value = tarefa.id;
      modalResp.value = tarefa.responsavel;
      modalInicio.value = tarefa.inicio;
      modalFim.value = tarefa.fim;
      modalDescricao.value = tarefa.descricao;
      modalEquipamento.value = tarefa.equipamento.nome;
      modalStatus.value = tarefa.status_servicos; //atualiza o valor de statsu na modal.
      modalSituacao.value = tarefa.situacao; //atualiza o valor de situação na modal.
      modal.style.display = 'block';
      modalResp.focus();
    }

    function fecharModal() {
      modal.style.display = 'none';
    }

    modalOverlay.addEventListener('click', fecharModal);
    btnFechar.addEventListener('click', fecharModal);
    btnCancelar.addEventListener('click', fecharModal);
    document.addEventListener('keydown', e => {
      if (e.key === "Escape") {
        fecharModal();
      }
    });

    formEditar.addEventListener('submit', (e) => {
      e.preventDefault();
      const id = modalId.value;
      const index = tarefas.findIndex(t => t.id === id);
      if (index !== -1) {
        tarefas[index].responsavel = modalResp.value;
        tarefas[index].inicio = modalInicio.value;
        tarefas[index].fim = modalFim.value;
        tarefas[index].descricao = modalDescricao.value;
        atualizarTimeline(inputInicio.value, inputFim.value);
        fecharModal();
      }
    });

    function atualizarTimeline(inicioStr, fimStr) {
      if (!inicioStr || !fimStr) return;
      const inicio = new Date(inicioStr);
      const fim = new Date(fimStr);
      if (isNaN(inicio) || isNaN(fim) || fim <= inicio) return;

      const intervaloHoras = (fim - inicio) / (1000 * 60 * 60);
      const largura = window.innerWidth - 510;
      const PIXELS_POR_HORA = largura / intervaloHoras;

      timelineYears.innerHTML = '';
      timelineMonths.innerHTML = '';
      timelineHeader.innerHTML = '';
      tarefasContainer.innerHTML = '';

      //=========== Anos  ===============//

      const anoInicio = inicio.getFullYear();
      const anoFim = fim.getFullYear();
      for (let ano = anoInicio; ano <= anoFim; ano++) {
        const divAno = document.createElement('div');
        divAno.className = 'year';
        divAno.style.width = `${largura / (anoFim - anoInicio + 1)}px`;
        divAno.textContent = ano;
        timelineYears.appendChild(divAno);
      }

      //============= Meses==============//

      let mesAtual = new Date(inicio.getFullYear(), inicio.getMonth(), 1);
      const fimMeses = new Date(fim.getFullYear(), fim.getMonth(), 1);
      const meses = [];

      while (mesAtual <= fimMeses) {
        const inicioMes = new Date(mesAtual);
        const fimMes = new Date(mesAtual.getFullYear(), mesAtual.getMonth() + 1, 1);

        const inicioDentro = inicioMes < inicio ? inicio : inicioMes;
        const fimDentro = fimMes > fim ? fim : fimMes;

        const horas = (fimDentro - inicioDentro) / (1000 * 60 * 60);

        meses.push({
          nome: mesesNomes[mesAtual.getMonth()],
          ano: mesAtual.getFullYear(),
          horas
        });

        mesAtual.setMonth(mesAtual.getMonth() + 1);
      }

      meses.forEach(mes => {
        const divMes = document.createElement('div');
        divMes.className = 'month';
        divMes.style.width = `${mes.horas * PIXELS_POR_HORA}px`;
        divMes.textContent = `${mes.nome} ${mes.ano}`;
        timelineMonths.appendChild(divMes);
      });

      //======  dias   ====//
      const timelineDays = document.getElementById('timeline-days');
      timelineDays.innerHTML = ''; // limpa antes

      let diaAtual = new Date(inicio);

      while (diaAtual <= fim) {
        const divDia = document.createElement('div');
        divDia.className = 'day';

        // Formata o dia para aparecer (ex: 01, 02, 15...)
        const diaNum = diaAtual.getDate().toString().padStart(2, '0');
        divDia.textContent = diaNum;

        // Calcula o início e fim do dia atual (meia-noite até meia-noite do próximo dia)
        const inicioDia = new Date(diaAtual);
        inicioDia.setHours(0, 0, 0, 0);

        const fimDia = new Date(inicioDia);
        fimDia.setHours(24, 0, 0, 0);

        // Define o intervalo visível para o dia atual dentro do intervalo geral
        const inicioVisivel = inicioDia < inicio ? inicio : inicioDia;
        const fimVisivel = fimDia > fim ? fim : fimDia;

        // Calcula quantas horas do dia estão visíveis
        const horasVisiveis = (fimVisivel - inicioVisivel) / (1000 * 60 * 60);

        // Define a largura proporcional da div do dia
        divDia.style.width = `${PIXELS_POR_HORA * horasVisiveis}px`;

        timelineDays.appendChild(divDia);

        // Incrementa 1 dia
        diaAtual.setDate(diaAtual.getDate() + 1);
      }
      // Depois desse trecho que cria os dias:
      while (diaAtual <= fim) {
        const divDia = document.createElement('div');
        divDia.className = 'day';

        // ... código para ajustar largura e texto do dia ...

        timelineDays.appendChild(divDia);

        // Adiciona linha vertical tracejada para o dia
        const linhaDia = document.createElement('div');
        linhaDia.className = 'grid-line';
        linhaDia.style.height = '100%'; // cobre toda a altura da barra de dias
        linhaDia.style.position = 'absolute'; // posicionamento absoluto
        linhaDia.style.left = divDia.offsetLeft + divDia.offsetWidth + 'px'; // posição após o dia
        linhaDia.style.top = '0';
        linhaDia.style.borderLeft = '1px dotted #999';

        timelineDays.appendChild(linhaDia);

        diaAtual.setDate(diaAtual.getDate() + 1);
      }
      // ==========Horas (somente se intervalo <= 48 horas)======//

      if (intervaloHoras <= 48) {
        const horasInteiras = Math.ceil(intervaloHoras);
        for (let h = 0; h < horasInteiras; h++) {
          const divHora = document.createElement('div');
          divHora.className = 'hora';
          divHora.style.width = `${PIXELS_POR_HORA}px`;
          const horaReal = new Date(inicio.getTime() + h * 3600000).getHours();
          divHora.textContent = horaReal + 'h';
          timelineHeader.appendChild(divHora);
        }
      }

      // dados das Tarefas
      tarefas.forEach(tarefa => {
        const linha = document.createElement('div');
        linha.className = 'linha-tarefa-container';

        const dados = document.createElement('div');
        dados.className = 'dados';
        dados.innerHTML = `
  <div styele="margin-top:0px" class="registro-id"><strong>${tarefa.id}</strong></div>
  <div class="registro-responsavel">-<strong style="color:blue;">${tarefa.responsavel}</strong></div>
  <div class="registro-inicio">- ${tarefa.inicio.replace('T', ' ')}</div>
  <div class="registro-fim">- ${tarefa.fim.replace('T', ' ')}</div>
  <hr style="margin=opx;">
  <div class="registro-fim">${tarefa.especialidade}</div>
`;

        const divBotao = document.createElement('div');
        divBotao.style.marginLeft = 'auto';
        divBotao.innerHTML = `<a href="/ordem-servico/${tarefa.id}" target="_blank" class="btn btn-sm btn-outline-primary">O.S.</a>`;

        dados.appendChild(divBotao);
        //----------------------------fim de dados----------------//
        const timeline = document.createElement('div');
        timeline.className = 'timeline-container';
        timeline.style.minWidth = `${largura}px`;
        timeline.style.position = 'relative';

        const grid = document.createElement('div');
        grid.className = 'grid';
        grid.style.minWidth = `${largura}px`;

        // Grid lines (somente se intervalo <= 48 horas)
        const horasInteirasGrid = Math.ceil(intervaloHoras);
        for (let i = 0; i < horasInteirasGrid; i++) {
          const line = document.createElement('div');
          line.className = 'grid-line';
          line.style.width = `${PIXELS_POR_HORA}px`;
          if (intervaloHoras > 48) {
            line.style.display = 'none';
          }
          grid.appendChild(line);
        }

        timeline.appendChild(grid);
        //--------------------------------//
        // Gera a barra de tarefas timeline
        //-------------------------------//
        const barra = document.createElement('div');
        barra.className = 'registro-barra';
        // Define a cor com base na especialidade
        switch ((tarefa.especialidade || '').toLowerCase()) {
          case 'eletrica':
            barra.style.backgroundColor = 'rgba(255, 193, 7, 0.3)';
            break;
          case 'mecanica':
            barra.style.backgroundColor = 'rgba(0, 68, 102, 0.3)'; // azul petroleo
            break;
          case 'civil':
            barra.style.backgroundColor = 'rgba(2, 117, 216, 0.3)'; // azul
            break;
          case 'sesmet':
            barra.style.backgroundColor = 'rgba(76, 175, 80, 0.3)'; // verde folha
            break;
          default:
            barra.style.backgroundColor = '#808080'; // cinza médio
        }
        // Criar barra de progresso interna do status_servicos
        const progresso = document.createElement('div');
        progresso.style.height = '50%';
        progresso.style.position = 'absolute';
        progresso.style.top = '25%';
        progresso.style.width = `${tarefa.status_servicos}%`;
        progresso.style.backgroundColor = 'rgba(0, 0, 0, 0.2)';
        progresso.style.borderRadius = '4px 0 0 4px'; // bordas arredondadas no início
        progresso.style.pointerEvents = 'none';

        // Texto com o percentual
        const textoStatus = document.createElement('span');
        textoStatus.textContent = `${tarefa.status_servicos}%`;
        textoStatus.style.fontSize = '12px';
        textoStatus.style.color = '#000'; // ou '#fff' se o fundo for escuro
        textoStatus.style.position = 'absolute';
        textoStatus.style.right = '5px';
        textoStatus.style.bottom = '4px';
        textoStatus.style.opacity = '0.8';

        // Adiciona na ordem certa
        barra.appendChild(progresso);
        barra.appendChild(textoStatus);
        //
        // Indicador de status da O.S.
        const statusBadge = document.createElement('div');
        statusBadge.style.position = 'absolute';
        statusBadge.style.top = '0';
        statusBadge.style.left = '5px';
        statusBadge.style.fontSize = '11px';
        statusBadge.style.fontWeight = 'bold';
        statusBadge.style.padding = '1px 4px';
        statusBadge.style.borderRadius = '4px';
        statusBadge.style.backgroundColor = '#999';
        statusBadge.style.color = '#fff';

        switch ((tarefa.situacao || '').toLowerCase()) {
          case 'aberto':
            statusBadge.textContent = 'Aberto';
            statusBadge.style.backgroundColor = '#d8c071ff'; // azul claro
            break;
          case 'em andamento':
            statusBadge.textContent = 'Executando';
            statusBadge.style.backgroundColor = '#169b12ff'; // verde
            break;
          case 'pausado':
            statusBadge.textContent = 'Pausado';
            statusBadge.style.backgroundColor = '#dc3545'; // vermelho
            break;
          default:
            statusBadge.textContent = 'Desconhecido';
            statusBadge.style.backgroundColor = '#6c757d'; // cinza
            break;
        }

        barra.appendChild(statusBadge);


        //--------------------------------------------//
        const iniT = new Date(tarefa.inicio);
        const fimT = new Date(tarefa.fim);

        if (fimT > inicio && iniT < fim) {
          const inicioVisivel = iniT < inicio ? inicio : iniT;
          const fimVisivel = fimT > fim ? fim : fimT;

          const duracao = (fimVisivel - inicioVisivel) / 3600000;
          const desloc = (inicioVisivel - inicio) / 3600000;

          barra.style.left = `${desloc * PIXELS_POR_HORA}px`;
          barra.style.width = `${duracao * PIXELS_POR_HORA}px`;

          barra.title = `Tarefa ${tarefa.id}\nInício: ${tarefa.inicio}\nFim: ${tarefa.fim}`;

          barra.addEventListener('click', () => abrirModal(tarefa));

          timeline.appendChild(barra);
        }

        linha.appendChild(dados);
        linha.appendChild(timeline);
        tarefasContainer.appendChild(linha);
      });
    }

    btnAtualizar.addEventListener('click', () => {
      atualizarTimeline(inputInicio.value, inputFim.value);
    });

    // Inicializa com valores padrão para teste
    const agora = new Date();
    const inicioPadrao = new Date(agora.getFullYear(), agora.getMonth(), agora.getDate(), 6, 0);
    const fimPadrao = new Date(agora.getFullYear(), agora.getMonth(), agora.getDate() + 1, 18, 0);

    inputInicio.value = inicioPadrao.toISOString().slice(0, 16);
    inputFim.value = fimPadrao.toISOString().slice(0, 16);

    atualizarTimeline(inputInicio.value, inputFim.value);
  </script>
  <!------------------------------------------------->
  <!-- Script que envia a requisição via jason da modal-->
  <script>
    // Envia dados atualizados via fetch para o controller
    document.getElementById('form-editar').addEventListener('submit', function(event) {
      event.preventDefault();

      const id = document.getElementById('modal-id').value;

      const inicioCompleto = document.getElementById('modal-inicio').value;
      const fimCompleto = document.getElementById('modal-fim').value;
      const status = document.getElementById('modal-status').value;
      const situacao = document.getElementById('modal-situacao').value;
      // Separa data e hora
      const inicio = inicioCompleto.split('T')[0]; // 'YYYY-MM-DD'
      const horaInicio = inicioCompleto.split('T')[1]; // 'HH:MM'

      const fim = fimCompleto.split('T')[0]; // 'YYYY-MM-DD'
      const horaFim = fimCompleto.split('T')[1]; // 'HH:MM'
      //alert( inicio+ horaInicio+ fim+horaFim)
      // Monta o objeto com todos os dados
      const dadosParaEnviar = {
        id: id,
        inicio: inicio,
        horaInicio: horaInicio,
        fim: fim,
        horaFim: horaFim,
        status: status,
        situacao_os: situacao
      };

      fetch('{{ route("update.os.interval") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify(dadosParaEnviar)
        })
        .then(response => response.json())
        .then(data => {
          console.log('Resposta do servidor:', data.retorno);

          // Atualiza os dados no array tarefas para manter coerência
          const id = document.getElementById('modal-id').value;
          const index = tarefas.findIndex(t => t.id == id);
          if (index !== -1) {
            tarefas[index].inicio = document.getElementById('modal-inicio').value;
            tarefas[index].fim = document.getElementById('modal-fim').value;
            tarefas[index].descricao = document.getElementById('modal-descricao').value;
            tarefas[index].status_servicos = document.getElementById('modal-status').value; // essa linha é opcional, mas já garante o status atualizado
            tarefas[index].situacao = document.getElementById('modal-situacao').value; // ⬅️ esta é a que faltava!
          }

          // Atualiza o gráfico usando o intervalo selecionado nos inputs 'inicio' e 'fim' principais
          atualizarTimeline(inputInicio.value, inputFim.value);

          // Fecha o modal
          document.getElementById('modal').style.display = 'none';
        })
        .catch(error => {
          console.error('Erro ao enviar:', error);
          alert('Erro ao enviar os dados!');
        });
    });
  </script>
  <style>
    .dados {
      display: flex;
      flex-direction: row;
      /* <-- deixa em linha */
      flex-wrap: wrap;
      /* permite quebrar se faltar espaço */
      gap: 12px;
      align-items: center;
      padding: 8px 10px;
      background: rgb(243, 242, 242);
      border-right: 1px solid #bbb;
      width: 510px;
    }

    .dados .registro-id,
    .dados .registro-responsavel,
    .dados .registro-inicio,
    .dados .registro-fim {
      font-size: 14px;
      color: #444;
    }
  </style>
</body>

</html>