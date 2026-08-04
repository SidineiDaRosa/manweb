@extends('app.layouts.app')

@section('content')

@include('app.dispositivo.create')
@include('app.dispositivo.edit')
@include('app.dispositivo.show')

<main class="content">

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h3>Dispositivos ESP32</h3>

            <button type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#modalCadastrar">

                <i class="bi bi-plus-circle"></i>
                Novo

            </button>

        </div>
        <div class="card shadow-sm">

            <div class="card-body">


                <table class="table table-hover align-middle">

                    <thead class="table-dark">

                        <tr>
                            <th>Equipamento</th>
                            <th>Device ID</th>
                            <th>Nome</th>
                            <th>Modelo</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>

                    </thead>


                    <tbody>


                        @forelse($dispositivos as $item)

                        <tr>

                            <td>
                                {{ $item->equipamento->nome ?? 'Sem equipamento' }}
                            </td>

                            <td>
                                {{ $item->device_id }}
                            </td>

                            <td>
                                {{ $item->nome }}
                            </td>

                            <td>
                                {{ $item->modelo }}
                            </td>


                            <td>

                                @if($item->status_online)

                                <span class="badge bg-success">
                                    Online
                                </span>

                                @else

                                <span class="badge bg-danger">
                                    Offline
                                </span>

                                @endif

                            </td>


                            <td>

                                <button
                                    class="btn btn-warning btn-sm btnEditar"

                                    data-id="{{ $item->id }}"
                                    data-equipamento="{{ $item->equipamento_id }}"
                                    data-device="{{ $item->device_id }}"
                                    data-nome="{{ $item->nome }}"
                                    data-api="{{ $item->api_key }}"
                                    data-mac="{{ $item->mac_address }}"
                                    data-modelo="{{ $item->modelo }}"
                                    data-firmware="{{ $item->firmware_versao }}"
                                    data-intervalo="{{ $item->intervalo_envio }}"
                                    data-ativo="{{ $item->ativo }}"

                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditar">

                                    Editar

                                </button>
                                <button
                                    class="btn btn-info btn-sm btnShow"

                                    data-equipamento="{{ $item->equipamento->nome ?? 'Sem equipamento' }}"
                                    data-nome="{{ $item->nome }}"
                                    data-device="{{ $item->device_id }}"
                                    data-api="{{ $item->api_key }}"
                                    data-mac="{{ $item->mac_address }}"
                                    data-modelo="{{ $item->modelo }}"
                                    data-firmware="{{ $item->firmware_versao }}"
                                    data-intervalo="{{ $item->intervalo_envio }}"
                                    data-ativo="{{ $item->ativo }}"

                                    data-bs-toggle="modal"
                                    data-bs-target="#modalShow">

                                    <i class="bi bi-eye"></i>

                                </button>

                                <button class="btn btn-danger btn-sm">
                                    Excluir
                                </button>
                                <a href="{{ route('dispositivos.monitorar', $item->id) }}"
                                    class="btn btn-success btn-sm">

                                    <i class="bi bi-display"></i>
                                    Monitorar

                                </a>

                            </td>

                        </tr>


                        @empty

                        <tr>

                            <td colspan="6" class="text-center">
                                Nenhum dispositivo cadastrado.
                            </td>

                        </tr>

                        @endforelse


                    </tbody>


                </table>


            </div>

        </div>


    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>
    document.querySelectorAll('.btnEditar').forEach(btn => {

        btn.addEventListener('click', function() {


            document.getElementById('edit_equipamento').value = this.dataset.equipamento;
            document.getElementById('edit_device').value = this.dataset.device;
            document.getElementById('edit_nome').value = this.dataset.nome;
            document.getElementById('edit_api').value = this.dataset.api;
            document.getElementById('edit_mac').value = this.dataset.mac;
            document.getElementById('edit_modelo').value = this.dataset.modelo;
            document.getElementById('edit_firmware').value = this.dataset.firmware;
            document.getElementById('edit_intervalo').value = this.dataset.intervalo;
            document.getElementById('edit_ativo').value = this.dataset.ativo;


            document.getElementById('formEditar').action =
                '/dispositivos/' + this.dataset.id;


        });

    });
</script>
<script>
    // 1. CÓDIGO DO MODAL EDITAR
    document.getElementById('modalEditar').addEventListener('show.bs.modal', function(event) {
        // Botão que disparou o modal
        const button = event.relatedTarget;

        // Preenche os inputs do formulário de edição
        document.getElementById('edit_equipamento').value = button.dataset.equipamento;
        document.getElementById('edit_device').value = button.dataset.device;
        document.getElementById('edit_nome').value = button.dataset.nome;
        document.getElementById('edit_api').value = button.dataset.api;
        document.getElementById('edit_mac').value = button.dataset.mac;
        document.getElementById('edit_modelo').value = button.dataset.modelo;
        document.getElementById('edit_firmware').value = button.dataset.firmware;
        document.getElementById('edit_intervalo').value = button.dataset.intervalo;
        document.getElementById('edit_ativo').value = button.dataset.ativo;

        // Define dinamicamente a rota correta para o envio (Action do Form)
        document.getElementById('formEditar').action = '/dispositivos/' + button.dataset.id;
    });

    // 2. CÓDIGO DO MODAL SHOW (VISUALIZAR)
    document.getElementById('modalShow').addEventListener('show.bs.modal', function(event) {
        // Botão que disparou o modal
        const button = event.relatedTarget;

        // Preenche os inputs de visualização (readonly)
        document.getElementById('show_equipamento').value = button.dataset.equipamento;
        document.getElementById('show_nome').value = button.dataset.nome;
        document.getElementById('show_device_id').value = button.dataset.device;
        document.getElementById('show_api_key').value = button.dataset.api;
        document.getElementById('show_mac_address').value = button.dataset.mac;
        document.getElementById('show_modelo').value = button.dataset.modelo;
        document.getElementById('show_firmware').value = button.dataset.firmware;

        // Formata o intervalo para incluir a palavra "segundos" se houver valor
        const intervalo = button.dataset.intervalo;
        document.getElementById('show_intervalo').value = intervalo ? intervalo + ' segundos' : 'Não definido';

        // Converte o valor binário (1 ou 0) para texto legível
        const ativo = button.dataset.ativo;
        document.getElementById('show_ativo').value = (ativo == '1') ? 'Ativo' : 'Inativo';
    });
</script>


@endsection