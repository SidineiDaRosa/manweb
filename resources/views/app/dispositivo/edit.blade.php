<!-- Modal Editar -->

<div class="modal fade" id="modalEditar" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <form id="formEditar" method="POST">

            @csrf
            @method('PUT')

            <div class="modal-content">


                <div class="modal-header">

                    <h5 class="modal-title">
                        Alterar Dispositivo
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">


                    <div class="row">


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Equipamento
                            </label>

                            <select name="equipamento_id" 
                                    id="edit_equipamento"
                                    class="form-control"
                                    required>

                                @foreach($equipamentos as $equipamento)

                                    <option value="{{ $equipamento->id }}">
                                        {{ $equipamento->nome }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nome
                            </label>

                            <input type="text"
                                   name="nome"
                                   id="edit_nome"
                                   class="form-control">

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Device ID
                            </label>

                            <input type="text"
                                   name="device_id"
                                   id="edit_device"
                                   class="form-control"
                                   required>

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                API Key
                            </label>

                            <input type="text"
                                   name="api_key"
                                   id="edit_api"
                                   class="form-control"
                                   required>

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                MAC Address
                            </label>

                            <input type="text"
                                   name="mac_address"
                                   id="edit_mac"
                                   class="form-control">

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Modelo
                            </label>

                            <input type="text"
                                   name="modelo"
                                   id="edit_modelo"
                                   class="form-control">

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Firmware
                            </label>

                            <input type="text"
                                   name="firmware_versao"
                                   id="edit_firmware"
                                   class="form-control">

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Intervalo envio
                            </label>

                            <input type="number"
                                   name="intervalo_envio"
                                   id="edit_intervalo"
                                   class="form-control">

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Ativo
                            </label>

                            <select name="ativo"
                                    id="edit_ativo"
                                    class="form-control">

                                <option value="1">
                                    Sim
                                </option>

                                <option value="0">
                                    Não
                                </option>

                            </select>

                        </div>


                    </div>


                </div>


                <div class="modal-footer">


                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        Cancelar

                    </button>


                    <button type="submit"
                            class="btn btn-primary">

                        Atualizar

                    </button>


                </div>


            </div>


        </form>

    </div>

</div>
