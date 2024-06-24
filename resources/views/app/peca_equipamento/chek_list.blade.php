@extends('app.layouts.app')

@section('titulo', 'Produtos')

@section('content')
@foreach ($pecas_equipamento as $peca_equipamento)
@endforeach

<main class="content">
    <div class="card-header-template">

        <diV>
            <a class="btn btn-outline-primary" href="{{ route('Peca-equipamento.index') }}">
                <span class="material-symbols-outlined">
                    format_list_bulleted
                </span>
            </a>

            <a class="btn btn-outline-success" href="{{route('equipamento.index', ['empresa'=>2])}}">
                <i class="icofont-tractor"></i>
                ir para o equipamentos
            </a>
            <a class="btn btn-outline-dark" href="{{ route('app.home') }}">
                <i class="icofont-dashboard"></i> dashboard
            </a>
        </div>
    </div>
    </div>
    <div class="titulo-main">
        Chek-List
    </div>
    <style>
        .titulo-main {
            font-size: 20px;
            color: gray;
            text-align: center;
            margin-top: -2;
        }
    </style>
    <div class="card">
        <style>
            .card {
                background-color: rgb(211, 211, 211);
            }

            #equipamento_id {
                font-size: 20px;
            }
        </style>
        @foreach ($equipamentos as $equipamentos_f)
        @endforeach
        <div class="card-body">

            {{----------------------------------------------------------------------}}
            {{--Continer box--}}
            <style>
                .container-box {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: space-around;
                    align-items: flex-start;
                    background-color: white;
                    margin: -1;

                }

                .item {
                    width: calc(33% - 20px);
                    height: auto;
                    margin: 10px;
                    padding: 15px;
                    background-color: white;
                    overflow: auto;
                    /* Impede que o conteúdo transborde */
                    font-weight: 500;
                }

                .box {
                    display: flex;
                    width: 100%;
                    height: auto;
                    margin-bottom: 1px;
                    background-color: #ccc;
                    border-radius: 5px;
                    padding: 5px;


                }

                @media (max-width: 900px) {
                    .item {
                        width: 100%;
                        margin: 0px -80;
                    }
                }

                hr {
                    margin: -5px;
                }

                .box-conteudo {
                    margin-left: 2px;
                    justify-content: flex-start;
                }

                .titulo {
                    display: flex;
                    font-size: 15px;
                    font-family: 'Poppins', sans-serif;

                }

                .conteudo {
                    display: flex;
                    font-size: 20px;
                    font-family: 'Poppins', sans-serif;
                    color: #007b00;
                    margin-bottom: 5px;
                }

                #patrimonio {
                    color: #2174d4;
                }

                .input-text {
                    margin-top: 5px;
                    width: 50%;
                    border: none;
                    color: #2174d4;
                    margin-right: 2px;
                }
            </style>
            <div class="container-box">
                {{--Box 1--}}
                <div class="item">
                    <div class="box-conteudo">
                        <div class="titulo">ID:</div>
                        <hr style="margin:-5px;">
                        <div class="conteudo">
                            {{ $peca_equipamento->id }}
                        </div>
                        <div class="titulo">Descrição:</div>
                        <hr style="margin:-5px;">
                        <div class="conteudo">
                            {{ $peca_equipamento->descricao}}hs
                        </div>
                        <div class="titulo">Quantidade:</div>
                        <hr style="margin:-5px;">
                        <div class="conteudo">
                            {{ $peca_equipamento->quantidade}}
                        </div>
                        <div class="titulo">Intervalo:</div>
                        <hr style="margin:-5px;">
                        <div class="conteudo">
                            {{ $peca_equipamento->intervalo_manutencao}}hs
                        </div>
                    </div>
                </div>
                {{--Box 2--}}
                <div class="item">
                    <div class="box-conteudo">
                        <div class="titulo">Data ultima Atualização:</div>
                        <hr style="margin:-5px;">
                        <div class="conteudo">
                            {{ date( 'd/m/Y' , strtotime($peca_equipamento['data_substituicao']))}} as {{ $peca_equipamento->hora_substituicao}}
                        </div>
                        <div class="titulo">Data da próxima:</div>
                        <hr style="margin:-5px;">
                        <div class="conteudo">
                            {{ date( 'd/m/Y' , strtotime($peca_equipamento['data_proxima_manutencao']))}}
                        </div>
                        <div class="titulo">Horas restante para próxima manutenção</div>
                        <hr style="margin:-5px;">
                        <div class="conteudo">
                            <div class="
    @if($peca_equipamento->horas_proxima_manutencao >= 48)
        bg-success
    @elseif($peca_equipamento->horas_proxima_manutencao < 48 && $peca_equipamento->horas_proxima_manutencao > 0)
        bg-warning
    @else
        bg-danger
    @endif
" style="color:black; width:50%;margin:8px;">
                                {{ $peca_equipamento->horas_proxima_manutencao }}
                            </div>
                        </div>

                    </div>
                </div>
                {{--Box 3--}}
                <div class="item">
                    <div class="box-conteudo">

                        <div class="titulo">Status</div>
                        <hr style="margin:-5px;">
                        <div class="conteudo">
                            {{ $peca_equipamento->status}}
                        </div>
                        <div class="titulo">Categoria</div>
                        <hr style="margin:-5px;">
                        <div class="conteudo">
                            {{ $peca_equipamento->tipo_componente}}
                        </div>
                        <div class="titulo">Grau de criticidade</div>
                        <hr style="margin:-5px;">
                        <div class="conteudo">
                            {{ $peca_equipamento->criticidade}}
                        </div>
                    </div>
                </div>
            </div>
            </form>
            {{--fim card--}}
            {{--------------fim continer box----------------------------------------}}
            {{--====================================================================--}}
            {{--Função que fecha a ordem de serviço--}}
            <div id="Bt-Conluir" class="d-grid gap-2 d-sm-flex justify-content float-center">
                <button id="enviar" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#confirmModal">
                    <img src="{{ asset('img/icon/finished-work.png') }}" alt="" style="height:25px; width:25px;">
                    concluír Chek-List</button>
                <style>
                    #Bt-Conluir {
                        display: flex;
                        justify-content: center;
                    }
                </style>
            </div>

</main>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JavaScript (bundle includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Modal de Confirmação -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Deseja Concluír Chek-List?
                <hr>
                <input type="number" id="id_os" class="form-control" placeholder="Número da OS" value="" name="id_os" style="background-color: rgba(249, 187, 120, 0.2)" ;onchange="validar()">
                <select class="form-control" name="tipo_de_sercivo" id="tipo_de_servico" name="estado" style="background-color: rgba(249, 187, 120, 0.2) ;">
                    <option value="Inspeção">Inspeção</option>
                    <option value="Preventiva">Preventiva</option>
                    <option value="Corretiva">Corretiva</option>
                    <option value="Ampliação">Ampliação</option>
                </select>
                <select class="form-control" name="" id="estado" name="estado" style="background-color: rgba(249, 187, 120, 0.2) ;">
                    <option value="Bom">Bom</option>
                    <option value="Regular">Regular</option>
                    <option value="Ruim">Ruim</option>
                </select>
                <script>
                    function validar() {
                        var id_os = document.getElementById('id_os').value;

                        if (id_os > 0) {
                            document.getElementById('id_os').style.backgroundColor = 'rgb(150, 255, 150)'; // Cor verde se o valor for maior que zero
                            document.getElementById('confirmarEnvio').focus();
                        } else {
                            document.getElementById('id_os').style.backgroundColor = 'red'; // Cor vermelha se o valor não for maior que zero
                        }
                    }
                </script>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmarEnvio" data-bs-dismiss="modal">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Sucesso -->
<div class="modal fade" id="sucessoModal" tabindex="-1" aria-labelledby="sucessoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sucessoModalLabel">Sucesso</h5>
                <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Chek-List Concluído!
                <div id="id-resp"></div>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Erro -->
<div class="modal fade" id="erroModal" tabindex="-1" aria-labelledby="sucessoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sucessoModalLabel"><i class="icofont-warning"></i>Alerta!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Erro ao fechar Chek-List!
            </div>
        </div>
    </div>
</div>
<input type="text" id="valor" placeholder="Digite um valor" value="{{$peca_equipamento->id }}" name="peca_equip_id" readonly hidden>
<script>
    $(document).ready(function() {
        $('#confirmarEnvio').click(function() {
            var valor = $('#valor').val(); // Obtém o valor do input
            let idOs = $('#id_os').val(); // Obtém o valor do input
            let tipoServico = $('#tipo_de_servico').val(); // Obtém o valor do input
            let estadoServico = $('#estado').val(); // Obtém o valor do input

            $.ajax({
                type: 'GET', // Método HTTP da requisição
                url: '{{ route("update-chek-list") }}', // URL para onde a requisição será enviada 
                data: {
                    valor: valor,
                    id_os: idOs,
                    tipo_de_servico: tipoServico,
                    estado: estadoServico
                }, // Dados a serem enviados (no formato chave: valor)
                success: function(response) {
                    if (response.mensagem) {
                        $('#mensagem').text(response.mensagem); // Exibe a mensagem retornada pelo servidor
                        $('#id-resp').html('ID: ' + response.id + '<br>Intervalo: ' + response.intervalo); // Exibe ID e intervalo na modal
                    } else {
                        $('#mensagem').text('Resposta do servidor: ' + response); // Exibe a resposta do servidor se a mensagem não estiver presente
                    }
                    $('#sucessoModal').modal('show'); // Exibe a modal de sucesso
                },
                error: function(xhr, status, error) {
                    $('#mensagem').text('Erro ao enviar valor: ' + error); // Exibe mensagem de erro, se houver
                    $('#erroModal').modal('show'); // Exibe a modal de sucesso
                }
            });
        });
    });
    document.getElementById('btn-close').addEventListener('click', function() {
        // Aqui você pode adicionar qualquer lógica adicional antes do refresh, se necessário.
        // Por exemplo, uma requisição AJAX para salvar a conclusão no banco de dados.
        // Recarregar a página
        location.reload();
    });
</script>
@endsection