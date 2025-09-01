
//  < !--Script que gera o gráfico de gantt-- >

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
    //--------------------------------//
    const barra = document.createElement('div');

    barra.className = 'registro-barra';
    barra.style.position = 'relative'; // importante para posicionar elementos absolutos internamente
    //----------------------------------------//
    //  Rezizable
    //---------------------------------------//
    const leftHandle = document.createElement('div');
    leftHandle.className = 'resize-handle left';

    const rightHandle = document.createElement('div');
    rightHandle.className = 'resize-handle right';

    barra.appendChild(leftHandle);
    barra.appendChild(rightHandle);
    // Código de redimensionamento que te passei
    let barraAtiva = null;
    let handleAtivo = null;
    let posInicial = 0;
    let larguraInicial = 0;

    document.querySelectorAll('.resize-handle').forEach(handle => {
      handle.addEventListener('mousedown', (e) => {
        barraAtiva = e.target.parentElement; // a div .registro-barra
        handleAtivo = e.target.classList.contains('left') ? 'left' : 'right';
        posInicial = e.clientX;
        larguraInicial = barraAtiva.offsetWidth;
        document.body.style.userSelect = 'none'; // evita seleção
      });
    });

    document.addEventListener('mousemove', (e) => {
      if (!barraAtiva) return;
      const dx = e.clientX - posInicial;
      if (handleAtivo === 'right') {
        barraAtiva.style.width = `${Math.max(10, larguraInicial + dx)}px`;
      } else {
        barraAtiva.style.width = `${Math.max(10, larguraInicial - dx)}px`;
        barraAtiva.style.left = `${barraAtiva.offsetLeft + dx}px`;
      }
    });

    document.addEventListener('mouseup', () => {
      if (barraAtiva) {
        barraAtiva = null;
        handleAtivo = null;
        document.body.style.userSelect = 'auto';
        // aqui você pode chamar AJAX para atualizar as datas
      }
    });
    //=========================================//
    // Define a cor com base na especialidade
    switch ((tarefa.especialidade || '').toLowerCase()) {
      case 'eletrica':
        barra.style.backgroundColor = 'rgba(255, 193, 7, 0.3)';
        break;
      case 'mecanica':
        barra.style.backgroundColor = 'rgba(0, 68, 102, 0.3)'; // azul petróleo
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

    // Barra de progresso
    const progresso = document.createElement('div');
    progresso.style.height = '50%';
    progresso.style.position = 'absolute';
    progresso.style.top = '25%';
    progresso.style.width = `${tarefa.status_servicos}%`;
    progresso.style.backgroundColor = 'rgba(0, 0, 0, 0.2)';
    progresso.style.borderRadius = '4px 0 0 4px';
    progresso.style.pointerEvents = 'none';

    // Texto do progresso
    const textoStatus = document.createElement('span');
    textoStatus.textContent = `${tarefa.status_servicos}%`;
    textoStatus.style.fontSize = '12px';
    textoStatus.style.color = '#000';
    textoStatus.style.position = 'absolute';
    textoStatus.style.right = '5px';
    textoStatus.style.bottom = '4px';
    textoStatus.style.opacity = '0.8';

    // Adiciona progresso e texto
    barra.appendChild(progresso);
    barra.appendChild(textoStatus);

    // Status da O.S.
    const statusBadge = document.createElement('div');
    statusBadge.style.position = 'absolute';
    statusBadge.style.top = '0';
    statusBadge.style.left = '20px'; // deslocado para caber a bolinha
    statusBadge.style.fontSize = '12px';
    statusBadge.style.padding = '1px 4px';
    statusBadge.style.borderRadius = '4px';
    statusBadge.style.color = '#fff';

    switch ((tarefa.situacao || '').toLowerCase()) {
      case 'aberto':
        statusBadge.textContent = 'Aberto';
        statusBadge.style.backgroundColor = '#d8c071ff';
        break;
      case 'em andamento':
        statusBadge.textContent = 'Executando';
        statusBadge.style.backgroundColor = '#169b12ff';
        break;
      case 'pausado':
        statusBadge.textContent = 'Pausado';
        statusBadge.style.backgroundColor = '#dc3545';
        break;
      default:
        statusBadge.textContent = 'Desconhecido';
        statusBadge.style.backgroundColor = '#6c757d';
        break;
    }

    // Adiciona status
    barra.appendChild(statusBadge);

    // Calcula prioridade pela matriz GUT
    const gravidade = parseInt(tarefa.gravidade) || 0;
    const urgencia = parseInt(tarefa.urgencia) || 0;
    const tendencia = parseInt(tarefa.tendencia) || 0;
    const prioridade = gravidade * urgencia * tendencia;

    // Cria bolinha de prioridade
    const bolinhaPrioridade = document.createElement('div');
    bolinhaPrioridade.style.width = '10px';
    bolinhaPrioridade.style.height = '10px';
    bolinhaPrioridade.style.borderRadius = '50%';
    bolinhaPrioridade.style.position = 'absolute';
    bolinhaPrioridade.style.top = '5px';
    bolinhaPrioridade.style.left = '5px';
    bolinhaPrioridade.title = `Prioridade: ${prioridade}`;
    bolinhaPrioridade.style.boxShadow = '0 0 2px #000'; // efeito visual

    // Cor conforme prioridade
    if (prioridade >= 100) {
      bolinhaPrioridade.style.backgroundColor = 'red';
    } else if (prioridade >= 50) {
      bolinhaPrioridade.style.backgroundColor = 'orange';
    } else {
      bolinhaPrioridade.style.backgroundColor = 'green';
    }

    // Adiciona bolinha à barra
    barra.appendChild(bolinhaPrioridade);

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
      //   title
      barra.title = `Tarefa ${tarefa.id}\nInício: ${tarefa.inicio}\nFim: ${tarefa.fim} \nFim: ${tarefa.equipamento.nome} \nFim: ${tarefa.descricao}`;

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

// Inicializa com valores padrão para teste// Pega as variáveis enviadas pelo controller
const inicioServidor = @json($inicioFiltro);
const fimServidor = @json($fimFiltro);

const agora = new Date();

function formatarParaInputDatetimeLocal(dataStr) {
  if (!dataStr) return null;
  // Garante o formato 'YYYY-MM-DDTHH:mm'
  const dt = new Date(dataStr);
  if (isNaN(dt)) return null;
  return dt.toISOString().slice(0, 16);
}

const inicioPadrao = formatarParaInputDatetimeLocal(inicioServidor) ||
  new Date(agora.getFullYear(), agora.getMonth(), agora.getDate(), 6, 0).toISOString().slice(0, 16);

const fimPadrao = formatarParaInputDatetimeLocal(fimServidor) ||
  new Date(agora.getFullYear(), agora.getMonth(), agora.getDate() + 1, 18, 0).toISOString().slice(0, 16);

inputInicio.value = inicioPadrao;
inputFim.value = fimPadrao;

atualizarTimeline(inputInicio.value, inputFim.value);

// <!------------------------------------------------->
// <!-- Script que envia a requisição via jason da modal-->
//
document.getElementById('form-editar').addEventListener('submit', function (event) {
  event.preventDefault();

  const id = document.getElementById('modal-id').value;

  const inicioCompleto = document.getElementById('modal-inicio').value;
  const fimCompleto = document.getElementById('modal-fim').value;
  const status = document.getElementById('modal-status').value;
  const situacao = document.getElementById('modal-situacao').value;

  // ✅ Validação com data e hora
  const dataHoraInicio = new Date(inicioCompleto);
  const dataHoraFim = new Date(fimCompleto);

  if (dataHoraInicio > dataHoraFim) {
    alert('Erro: A data/hora de início não pode ser maior que a data/hora de fim.');
    return; // ❌ interrompe o envio
  }

  // Separa data e hora (opcional, se você quiser continuar mandando separado)
  const inicio = inicioCompleto.split('T')[0]; // 'YYYY-MM-DD'
  const horaInicio = inicioCompleto.split('T')[1]; // 'HH:MM'

  const fim = fimCompleto.split('T')[0]; // 'YYYY-MM-DD'
  const horaFim = fimCompleto.split('T')[1]; // 'HH:MM'

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

      const index = tarefas.findIndex(t => t.id == id);
      if (index !== -1) {
        tarefas[index].inicio = inicioCompleto;
        tarefas[index].fim = fimCompleto;
        tarefas[index].descricao = document.getElementById('modal-descricao').value;
        tarefas[index].status_servicos = status;
        tarefas[index].situacao = situacao;
      }

      atualizarTimeline(inputInicio.value, inputFim.value);
      document.getElementById('modal').style.display = 'none';
    })
    .catch(error => {
      console.error('Erro ao enviar:', error);
      alert('Erro ao enviar os dados!');
    });
});


//====================================//
// let barraAtiva = null;
//let handleAtivo = null;
let posInicial = 0;
let larguraInicial = 0;
let leftInicial = 0; // <-- adicionado

document.querySelectorAll('.resize-handle').forEach(handle => {
  handle.addEventListener('mousedown', (e) => {
    barraAtiva = e.target.parentElement;
    handleAtivo = e.target.classList.contains('left') ? 'left' : 'right';
    posInicial = e.clientX;
    larguraInicial = barraAtiva.offsetWidth;
    leftInicial = barraAtiva.offsetLeft; // <-- armazena a posição inicial
    document.body.style.userSelect = 'none';
  });
});

document.addEventListener('mousemove', (e) => {
  if (!barraAtiva) return;
  const dx = e.clientX - posInicial;
  if (handleAtivo === 'right') {
    barraAtiva.style.width = `${Math.max(10, larguraInicial + dx)}px`;
  } else {
    barraAtiva.style.width = `${Math.max(10, larguraInicial - dx)}px`;
    barraAtiva.style.left = `${leftInicial + dx}px`; // <-- usa leftInicial em vez de offsetLeft
  }
});

document.addEventListener('mouseup', () => {
  if (barraAtiva) {
    barraAtiva = null;
    handleAtivo = null;
    document.body.style.userSelect = 'auto';
    // aqui você pode chamar AJAX para atualizar as datas
  }
});
