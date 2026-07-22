@extends('app.layouts.app')

@section('content')

<main class="content">

<div class="container-fluid">

    <h3 class="mb-4">
        Monitoramento ESP32
    </h3>

    <div class="row">

        <!-- STATUS -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">

                    <h5>Status</h5>

                    <div id="statusESP" class="fs-3 {{ $dispositivo->status_online ? 'text-success' : 'text-danger' }}">
                        {{ $dispositivo->status_online ? '🟢 Online' : '🔴 Offline' }}
                    </div>

                </div>
            </div>
        </div>

        <!-- TEMPERATURA -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Temperatura</h5>

                    <div class="display-5 dinamico-temperatura">
                        {{ $dispositivo->temperatura ?? 0 }} °C
                    </div>

                </div>
            </div>
        </div>

        <!-- VIBRAÇÃO -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">

                    <h5>Vibração RMS</h5>

                    <div class="display-5 dinamico-vibracao">
                        {{ $dispositivo->vibracao_rms ?? 0 }}
                    </div>

                </div>
            </div>
        </div>

        <!-- HORÍMETRO -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">

                    <h5>Horímetro</h5>

                    <div class="display-5 dinamico-horimetro">
                        {{ number_format($dispositivo->horimetro ?? 0, 2) }} h
                    </div>

                </div>
            </div>
        </div>

        <!-- IP -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">

                    <h5>IP Atual</h5>

                    <div class="display-6 dinamico-ip">
                        {{ $dispositivo->ultimo_ip }}
                    </div>

                </div>
            </div>
        </div>

        <!-- ÚLTIMA COMUNICAÇÃO -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">

                    <h5>Última Comunicação</h5>

                    <div class="dinamico-atualizacao">
                        {{ $dispositivo->updated_at }}
                    </div>

                </div>
            </div>
        </div>

    </div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Informações do Dispositivo</strong>
                <!-- Badge de Status compacta no cabeçalho -->
            </div>
            <div class="card-body">
                <!-- Linha única com pequenos blocos alinhados -->
                <div class="row text-center text-md-start">
                    
                    <div class="col-6 col-md-2 border-end mb-2 mb-md-0">
                        <small class="text-muted d-block">ID</small>
                        <strong>{{ $dispositivo->id }}</strong>
                    </div>

                    <div class="col-6 col-md-3 border-end mb-2 mb-md-0">
                        <small class="text-muted d-block">Device ID</small>
                        <span class="text-truncate d-block">{{ $dispositivo->device_id }}</span>
                    </div>

                    <div class="col-6 col-md-3 border-end mb-2 mb-md-0">
                        <small class="text-muted d-block">Modelo</small>
                        <strong>{{ $dispositivo->modelo }}</strong>
                    </div>

                    <div class="col-6 col-md-2 border-end mb-2 mb-md-0">
                        <small class="text-muted d-block">Firmware</small>
                        <code>{{ $dispositivo->firmware_versao }}</code>
                    </div>

                    <div class="col-12 col-md-2">
                        <small class="text-muted d-block">IP</small>
                        <span class="dinamico-ip font-monospace">{{ $dispositivo->ultimo_ip }}</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mt-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Histórico de Alertas de Telemetria</h5>
        <span class="badge bg-danger">Logs Recentes</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped mb-0 align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Data / Hora</th>
                    <th>Temperatura</th>
                    <th>Código do Erro</th>
                    <th>Mensagem de Erro</th>
                </tr>
            </thead>
            <tbody id="tabelaLogs">
                @forelse($telemetrie_logs as $log)
                    <tr>
                        <td><strong>#{{ $log->id }}</strong></td>
                        <td>
                            <!-- Formata a data de AAAA-MM-DD para DD/MM/AAAA -->
                            <small class="text-muted fw-bold">
                                {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s') }}
                            </small>
                        </td>
                        <td>
                            <span class="badge bg-secondary fs-6">
                                {{ number_format($log->temperatura, 2, ',', '.') }} °C
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-warning text-dark font-monospace">
                                {{ $log->codigo_erro }}
                            </span>
                        </td>
                        <td class="text-start">
                            <div class="alert alert-danger d-inline-block py-1 px-2 mb-0 border-0 compact-alert">
                                ⚠️ {{ $log->mensagem_erro }}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="semLogs">
                        <td colspan="5" class="text-muted py-4">Nenhum log de erro encontrado para este dispositivo.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


</main>

@endsection

<script>
document.addEventListener("DOMContentLoaded", function() {
    const dispositivoId = "{{ $dispositivo->id }}"; 

    function atualizarMonitoramento() {
        fetch(`/dispositivo/${dispositivoId}/status-atual`)
            .then(response => {
                if (!response.ok) throw new Error('Falha na requisição');
                return response.json();
            })
            .then(data => {
                // 1. ATUALIZA O CARD DE STATUS PRINCIPAL E BADGE DA TABELA
                const statusDiv = document.getElementById('statusESP');
                const statusBadge = document.getElementById('statusBadge');
                
                if (data.online) {
                    if (statusDiv) {
                        statusDiv.className = "fs-3 text-success";
                        statusDiv.innerHTML = "🟢 Online";
                    }
                    if (statusBadge) statusBadge.innerHTML = '<span class="badge bg-success">Online</span>';
                } else {
                    if (statusDiv) {
                        statusDiv.className = "fs-3 text-danger";
                        statusDiv.innerHTML = "🔴 Offline";
                    }
                    if (statusBadge) statusBadge.innerHTML = '<span class="badge bg-danger">Offline</span>';
                }

                // 2. ATUALIZA OS VALORES TRATANDO CASOS ONDE OS DADOS VÊM NULOS
                document.querySelectorAll('.dinamico-temperatura').forEach(el => {
                    let temp = data.temperatura !== null && data.temperatura !== undefined ? data.temperatura : 0;
                    el.innerHTML = `${temp} °C`;
                });

                document.querySelectorAll('.dinamico-vibracao').forEach(el => {
                    let vib = data.vibracao_rms !== null && data.vibracao_rms !== undefined ? data.vibracao_rms : 0;
                    el.innerHTML = vib;
                });

                document.querySelectorAll('.dinamico-horimetro').forEach(el => {
                    let valorHorimetro = parseFloat(data.horimetro);
                    if (isNaN(valorHorimetro)) {
                        valorHorimetro = 0.00;
                    }
                    let horimetroFormatado = valorHorimetro.toFixed(2);
                    
                    if(el.tagName === 'TD') {
                        el.innerHTML = `${horimetroFormatado} horas`;
                    } else {
                        el.innerHTML = `${horimetroFormatado} h`;
                    }
                });

                document.querySelectorAll('.dinamico-ip').forEach(el => {
                    el.innerHTML = data.ultimo_ip || 'Sem IP';
                });

                document.querySelectorAll('.dinamico-atualizacao').forEach(el => {
                    el.innerHTML = data.ultima_atualizacao;
                });
            })
            .catch(error => {
                console.error('Erro ao buscar atualizações no Laravel:', error);
            });
    }

    // Executa a checagem imediatamente ao carregar a tela
    atualizarMonitoramento();

    // Configura o temporizador automático para atualizar a cada 5 segundos
    setInterval(atualizarMonitoramento, 5000);
});
</script>

