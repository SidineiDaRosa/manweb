<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manutenção · Telemetria</title>
  <!-- Font Awesome 6 (gratuito) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    body {
      background: #f4f7fc;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 0;
    }

    .card {
      max-width: 100%;
      width: 100%;
      min-height: 100vh;
      background: white;
      border-radius: 0;
      box-shadow: none;
      overflow: hidden;
      transition: all 0.2s ease;
    }

    .card-header {
      background: linear-gradient(145deg, #0b2a3b, #0a1e2b);
      padding: 1.8rem 2rem;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
      border-bottom: 3px solid #2f9bc0;
    }

    .card-header h1 {
      font-weight: 600;
      font-size: 1.8rem;
      letter-spacing: -0.02em;
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }

    .card-header h1 i {
      color: #7ac7e8;
      font-size: 2rem;
    }

    .sensor-badge {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(4px);
      padding: 0.6rem 1.2rem;
      border-radius: 60px;
      font-size: 0.9rem;
      border: 1px solid rgba(255, 255, 255, 0.15);
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }

    .sensor-badge i {
      color: #7ac7e8;
    }

    .status-dot {
      display: inline-block;
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: #3dd68c;
      margin-right: 6px;
      animation: pulse-dot 1.6s infinite;
    }

    @keyframes pulse-dot {
      0% { opacity: 0.6; transform: scale(0.9); }
      50% { opacity: 1; transform: scale(1.2); }
      100% { opacity: 0.6; transform: scale(0.9); }
    }

    .filter-bar {
      background: #f0f4fa;
      padding: 0.8rem 2rem;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 1.2rem;
      border-bottom: 1px solid #dde5ef;
    }

    .filter-bar span {
      font-weight: 500;
      color: #1f3b4b;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .filter-group {
      display: flex;
      flex-wrap: wrap;
      gap: 0.4rem;
    }

    .filter-btn {
      background: transparent;
      border: 1px solid #cbd8e8;
      padding: 0.35rem 1rem;
      border-radius: 40px;
      font-size: 0.8rem;
      font-weight: 500;
      color: #1f3b4b;
      cursor: pointer;
      transition: all 0.2s;
    }

    .filter-btn.active {
      background: #1f3b4b;
      border-color: #1f3b4b;
      color: white;
    }

    .filter-btn:hover {
      background: #d9e2ef;
    }

    .filter-btn.active:hover {
      background: #14303e;
    }

    .notification-list {
      padding: 1.2rem 2rem 2rem;
      max-height: calc(100vh - 250px);
      overflow-y: auto;
      background: #fafcff;
    }

    .notification-item {
      background: white;
      border-radius: 20px;
      padding: 1.2rem 1.5rem;
      margin-bottom: 0.9rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
      border-left: 6px solid #a0c4d9;
      transition: 0.15s ease;
      display: flex;
      align-items: flex-start;
      gap: 1rem;
      border: 1px solid #ecf2f8;
      border-left-width: 6px;
    }

    .notification-item:hover {
      background: #f6faff;
      border-color: #cbdae8;
      box-shadow: 0 6px 14px rgba(0, 20, 30, 0.06);
    }

    .notification-item.critical {
      border-left-color: #dc3545;
    }

    .notification-item.warning {
      border-left-color: #f3a33d;
    }

    .notification-item.info {
      border-left-color: #2f9bc0;
    }

    .notification-item.resolved {
      opacity: 0.75;
      border-left-color: #6c8a9e;
    }

    .notification-item .icon-area {
      width: 40px;
      height: 40px;
      background: #eef4fa;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #1f3b4b;
      font-size: 1.2rem;
      flex-shrink: 0;
    }

    .notification-item.critical .icon-area {
      background: #fce8ea;
      color: #b02b37;
    }

    .notification-item.warning .icon-area {
      background: #fef0dd;
      color: #b86d1f;
    }

    .notification-item.info .icon-area {
      background: #e2eff7;
      color: #0f5b7a;
    }

    .notification-content {
      flex: 1;
    }

    .notification-title {
      font-weight: 600;
      font-size: 1rem;
      color: #0d1f2b;
      display: flex;
      flex-wrap: wrap;
      align-items: baseline;
      gap: 0.5rem;
    }

    .notification-title .sensor-tag {
      background: #dce7f2;
      font-size: 0.65rem;
      font-weight: 600;
      padding: 0.2rem 0.7rem;
      border-radius: 40px;
      color: #1a3f55;
      letter-spacing: 0.02em;
      text-transform: uppercase;
    }

    .notification-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 0.8rem 1.2rem;
      margin-top: 0.4rem;
      font-size: 0.8rem;
      color: #3d5b6e;
    }

    .notification-meta i {
      width: 16px;
      color: #577f99;
    }

    .notification-desc {
      margin-top: 0.5rem;
      color: #1f3b4b;
      font-size: 0.9rem;
      background: #f4f9ff;
      padding: 0.5rem 0.9rem;
      border-radius: 12px;
      display: inline-block;
      border: 1px solid #e4edf6;
      width: 100%;
    }

    .notification-actions {
      display: flex;
      gap: 0.5rem;
      margin-left: auto;
      align-self: center;
      flex-shrink: 0;
    }

    .action-btn {
      background: transparent;
      border: none;
      color: #5b7b93;
      font-size: 0.9rem;
      padding: 0.3rem 0.6rem;
      border-radius: 40px;
      transition: 0.15s;
      cursor: pointer;
    }

    .action-btn:hover {
      background: #e3edf6;
      color: #0e293b;
    }

    .action-btn.ack {
      background: #dbeaf5;
      color: #105a7a;
      font-weight: 500;
      font-size: 0.7rem;
      padding: 0.25rem 0.9rem;
      border-radius: 40px;
    }

    .action-btn.ack:hover {
      background: #b8d4e9;
    }

    .empty-state {
      text-align: center;
      padding: 3rem 1rem;
      color: #5b788c;
    }

    .empty-state i {
      font-size: 3rem;
      color: #b6cedf;
      margin-bottom: 0.5rem;
    }

    .card-footer {
      background: #ecf2f9;
      padding: 0.9rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 0.8rem;
      font-size: 0.85rem;
      color: #1f3f53;
      border-top: 1px solid #d6e0ec;
    }

    .footer-actions button {
      background: #1f3b4b;
      border: none;
      color: white;
      padding: 0.4rem 1.2rem;
      border-radius: 60px;
      font-weight: 500;
      font-size: 0.8rem;
      cursor: pointer;
      transition: 0.15s;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .footer-actions button:hover {
      background: #102a38;
    }

    .footer-actions .simulate-btn {
      background: #2f7b9e;
    }

    .footer-actions .simulate-btn:hover {
      background: #1a5e7a;
    }

    .timestamp {
      color: #3f627c;
    }

    /* scroll */
    .notification-list::-webkit-scrollbar {
      width: 6px;
    }

    .notification-list::-webkit-scrollbar-track {
      background: #eef3f8;
      border-radius: 10px;
    }

    .notification-list::-webkit-scrollbar-thumb {
      background: #b8ccdd;
      border-radius: 10px;
    }

    @media (max-width: 640px) {
      .card-header {
        flex-direction: column;
        align-items: start;
      }
      .notification-item {
        flex-wrap: wrap;
      }
      .notification-actions {
        margin-left: 0;
        width: 100%;
        justify-content: flex-end;
      }
    }
  </style>
</head>
<body>
<div class="card">
  <!-- cabeçalho -->
  <div class="card-header">
    <h1>
      <i class="fas fa-satellite-dish"></i> 
      Telemetria · Manutenção
    </h1>
    <div class="sensor-badge">
      <i class="fas fa-wifi"></i> 
      <span>3 sensores ativos</span>
      <span class="status-dot"></span>
    </div>
  </div>

  <!-- barra de filtros -->
  <div class="filter-bar">
    <span><i class="fas fa-sliders-h"></i> Filtro:</span>
    <div class="filter-group" id="filterGroup">
      <button class="filter-btn active" data-filter="all">Todos</button>
      <button class="filter-btn" data-filter="critical">Crítico</button>
      <button class="filter-btn" data-filter="warning">Atenção</button>
      <button class="filter-btn" data-filter="info">Info</button>
      <button class="filter-btn" data-filter="resolved">Resolvido</button>
    </div>
  </div>

  <!-- lista de notificações -->
  <div class="notification-list" id="notificationList">
    <!-- as notificações são injetadas via JS -->
  </div>

  <!-- rodapé com ações -->
  <div class="card-footer">
    <span>
      <i class="far fa-clock"></i> 
      <span id="lastUpdateLabel">Última atualização: agora</span>
    </span>
    <div class="footer-actions">
      <button class="simulate-btn" id="simulateBtn">
        <i class="fas fa-sync-alt"></i> Simular telemetria
      </button>
      <button id="clearAllBtn">
        <i class="fas fa-check-double"></i> Limpar todos
      </button>
    </div>
  </div>
</div>

<script>
  (function() {
    // ---------- DADOS INICIAIS (simulando sensores) ----------
    let notifications = [
      {
        id: 'n1',
        sensor: 'PT-101',
        title: 'Pressão hidráulica acima do limite',
        description: 'Sensor PT-101 registrou 215 bar (limite 190 bar) na linha principal.',
        severity: 'critical',
        timestamp: new Date(Date.now() - 1000 * 60 * 8),
        acknowledged: false,
      },
      {
        id: 'n2',
        sensor: 'TC-204',
        title: 'Temperatura do motor em elevação',
        description: 'TC-204 aponta 87°C, tendência de subida contínua nos últimos 12 min.',
        severity: 'warning',
        timestamp: new Date(Date.now() - 1000 * 60 * 25),
        acknowledged: false,
      },
      {
        id: 'n3',
        sensor: 'FL-077',
        title: 'Fluxo de combustível instável',
        description: 'Variação de ±8% no fluxo, possível contaminação ou bolhas.',
        severity: 'warning',
        timestamp: new Date(Date.now() - 1000 * 60 * 45),
        acknowledged: false,
      },
      {
        id: 'n4',
        sensor: 'VM-312',
        title: 'Vibração anômala no eixo',
        description: 'Espectro indica harmônicos fora do padrão (2x e 3x RPM).',
        severity: 'critical',
        timestamp: new Date(Date.now() - 1000 * 60 * 120),
        acknowledged: true,
      },
      {
        id: 'n5',
        sensor: 'PS-009',
        title: 'Pressão de óleo normalizada',
        description: 'Após manutenção corretiva, pressão retornou a 4.2 bar.',
        severity: 'resolved',
        timestamp: new Date(Date.now() - 1000 * 60 * 180),
        acknowledged: true,
      },
      {
        id: 'n6',
        sensor: 'TC-089',
        title: 'Temperatura ambiente dentro da faixa',
        description: 'Estabilização registrada, 34°C (limite 42°C).',
        severity: 'info',
        timestamp: new Date(Date.now() - 1000 * 60 * 300),
        acknowledged: false,
      },
    ];

    // referências
    const listEl = document.getElementById('notificationList');
    const filterGroup = document.getElementById('filterGroup');
    const lastUpdateLabel = document.getElementById('lastUpdateLabel');
    const simulateBtn = document.getElementById('simulateBtn');
    const clearAllBtn = document.getElementById('clearAllBtn');

    let currentFilter = 'all';
    let updateTimer = null;

    // ---------- helpers ----------
    function formatTime(date) {
      const now = new Date();
      const diffMs = now - date;
      const diffMin = Math.floor(diffMs / 60000);
      if (diffMin < 1) return 'agora';
      if (diffMin < 60) return `${diffMin} min atrás`;
      const diffH = Math.floor(diffMin / 60);
      if (diffH < 24) return `${diffH}h ${diffMin % 60}min`;
      return date.toLocaleString('pt-BR', { hour: '2-digit', minute: '2-digit' });
    }

    function severityIcon(sev) {
      const map = {
        critical: 'fa-exclamation-triangle',
        warning: 'fa-exclamation-circle',
        info: 'fa-info-circle',
        resolved: 'fa-check-circle',
      };
      return map[sev] || 'fa-circle';
    }

    // renderiza a lista com base no filtro
    function render() {
      const filtered = notifications.filter(n => {
        if (currentFilter === 'all') return true;
        return n.severity === currentFilter;
      });

      if (filtered.length === 0) {
        listEl.innerHTML = `
          <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p style="margin-top: 0.5rem;">Nenhuma notificação com este filtro</p>
          </div>
        `;
        return;
      }

      let html = '';
      filtered.forEach(n => {
        const severityClass = n.severity;
        const icon = severityIcon(n.severity);
        const timeStr = formatTime(n.timestamp);
        const ackLabel = n.acknowledged ? 'Reconhecido' : 'Marcar como lido';

        html += `
          <div class="notification-item ${severityClass}" data-id="${n.id}">
            <div class="icon-area">
              <i class="fas ${icon}"></i>
            </div>
            <div class="notification-content">
              <div class="notification-title">
                ${n.title}
                <span class="sensor-tag"><i class="fas fa-microchip"></i> ${n.sensor}</span>
              </div>
              <div class="notification-meta">
                <span><i class="far fa-clock"></i> ${timeStr}</span>
                <span><i class="fas fa-tag"></i> ${n.severity.charAt(0).toUpperCase() + n.severity.slice(1)}</span>
              </div>
              <div class="notification-desc">
                ${n.description}
              </div>
            </div>
            <div class="notification-actions">
              <button class="action-btn ack" data-action="ack" data-id="${n.id}">
                ${n.acknowledged ? '<i class="fas fa-check"></i>' : '<i class="far fa-circle"></i>'} ${ackLabel}
              </button>
              <button class="action-btn" data-action="delete" data-id="${n.id}">
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          </div>
        `;
      });

      listEl.innerHTML = html;
      updateLastUpdate();
    }

    // atualiza label de última atualização
    function updateLastUpdate() {
      const now = new Date();
      lastUpdateLabel.innerText = `Última atualização: ${now.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit', second: '2-digit' })}`;
    }

    // ---------- ações da UI (delegação) ----------
    listEl.addEventListener('click', (e) => {
      const btn = e.target.closest('button');
      if (!btn) return;

      const action = btn.dataset.action;
      const id = btn.dataset.id;
      if (!id) return;

      if (action === 'ack') {
        const notif = notifications.find(n => n.id === id);
        if (notif) {
          notif.acknowledged = !notif.acknowledged;
          render();
        }
      } else if (action === 'delete') {
        notifications = notifications.filter(n => n.id !== id);
        render();
      }
    });

    // ---------- filtros ----------
    filterGroup.addEventListener('click', (e) => {
      const btn = e.target.closest('.filter-btn');
      if (!btn) return;
      const filter = btn.dataset.filter;
      if (!filter) return;

      // atualiza visual dos botões
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentFilter = filter;
      render();
    });

    // ---------- simular nova notificação ----------
    function generateRandomNotification() {
      const sensors = ['PT-101', 'TC-204', 'FL-077', 'VM-312', 'PS-009', 'TC-089', 'HX-442', 'SP-551'];
      const titles = {
        critical: ['Pressão crítica no sistema', 'Temperatura extrema', 'Falha iminente no eixo'],
        warning: ['Variação de pressão', 'Temperatura acima do normal', 'Fluxo instável'],
        info: ['Leitura dentro do esperado', 'Sinal de telemetria estável', 'Manutenção preventiva recomendada'],
        resolved: ['Alarme resetado', 'Condição normalizada', 'Falha corrigida'],
      };
      const severities = ['critical', 'warning', 'info', 'resolved'];
      const weights = [0.35, 0.35, 0.2, 0.1]; // mais crítica e warning

      // escolhe severidade com peso
      let sev = 'info';
      const r = Math.random();
      if (r < 0.35) sev = 'critical';
      else if (r < 0.70) sev = 'warning';
      else if (r < 0.90) sev = 'info';
      else sev = 'resolved';

      const sensor = sensors[Math.floor(Math.random() * sensors.length)];
      const titlePool = titles[sev] || ['Notificação de sensor'];
      const title = titlePool[Math.floor(Math.random() * titlePool.length)];
      const descriptions = [
        `Sensor ${sensor} reportou valor fora do esperado.`,
        `Leitura anômala detectada em ${sensor}.`,
        `Oscilação registrada no canal ${sensor}.`,
        `Telemetria indica necessidade de verificação em ${sensor}.`,
        `Tendência anormal identificada por ${sensor}.`,
      ];
      const desc = descriptions[Math.floor(Math.random() * descriptions.length)];

      return {
        id: 'n' + Date.now() + Math.random().toString(36).substring(2, 6),
        sensor: sensor,
        title: title,
        description: desc,
        severity: sev,
        timestamp: new Date(),
        acknowledged: false,
      };
    }

    function addSimulatedNotification() {
      const newNotif = generateRandomNotification();
      notifications = [newNotif, ...notifications];
      render();
      // scroll para o topo
      listEl.scrollTop = 0;
    }

    simulateBtn.addEventListener('click', () => {
      addSimulatedNotification();
    });

    // limpar todos (exceto os já resolvidos? vamos limpar todos mesmo)
    clearAllBtn.addEventListener('click', () => {
      if (notifications.length === 0) return;
      if (confirm('Remover todas as notificações?')) {
        notifications = [];
        render();
      }
    });

    // ---------- atualização automática (a cada 45s) ----------
    function autoSimulate() {
      addSimulatedNotification();
    }

    // inicia timer (a cada 45 segundos)
    if (updateTimer) clearInterval(updateTimer);
    updateTimer = setInterval(autoSimulate, 45000);

    // render inicial
    render();

    // cleanup (caso seja SPA)
    window.addEventListener('beforeunload', () => {
      if (updateTimer) clearInterval(updateTimer);
    });

    // atualiza relógio do rodapé a cada 10s
    setInterval(() => {
      updateLastUpdate();
    }, 10000);

  })();
</script>
</body>
</html>