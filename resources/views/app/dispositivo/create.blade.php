<!-- Modal Cadastro -->

<div class="modal fade" id="modalCadastrar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('dispositivos.store') }}" method="POST">
            @csrf

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Cadastrar Dispositivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Equipamento</label>

                            <select
                                name="equipamento_id"
                                class="form-select"
                                required>

                                <option value="">Selecione...</option>

                                @foreach($equipamentos as $equipamento)
                                <option value="{{ $equipamento->id }}">
                                    {{ $equipamento->nome }}
                                </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nome</label>

                            <input
                                type="text"
                                name="nome"
                                class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Device ID</label>

                            <input
                                type="text"
                                name="device_id"
                                class="form-control"
                                placeholder="ESP32_EQ001"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">API Key</label>

                            <input
                                type="text"
                                name="api_key"
                                class="form-control"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">MAC Address</label>

                            <input
                                type="text"
                                name="mac_address"
                                class="form-control"
                                placeholder="AA:BB:CC:DD:EE:FF">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Modelo</label>

                            <input
                                type="text"
                                name="modelo"
                                class="form-control"
                                placeholder="ESP32 DevKit">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Firmware</label>

                            <input
                                type="text"
                                name="firmware_versao"
                                class="form-control"
                                placeholder="1.0.0">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Intervalo (segundos)</label>

                            <input
                                type="number"
                                name="intervalo_envio"
                                value="30"
                                min="1"
                                class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ativo</label>

                            <select
                                name="ativo"
                                class="form-select">

                                <option value="1">Sim</option>
                                <option value="0">Não</option>

                            </select>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Salvar
                    </button>

                </div>

            </div>

        </form>
    </div>
</div>