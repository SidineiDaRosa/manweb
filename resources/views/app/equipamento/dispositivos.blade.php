@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h3>Dispositivos ESP32</h3>

        <button class="btn btn-primary" onclick="novo()">
            Novo
        </button>
    </div>

    <table class="table table-bordered" id="tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Device ID</th>
                <th>Status</th>
                <th width="150">Ações</th>
            </tr>
        </thead>

        <tbody></tbody>

    </table>

</div>


<!-- Modal -->

<div class="modal fade" id="modal">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5>Dispositivo</h5>
            </div>

            <div class="modal-body">

                <input type="hidden" id="id">

                <div class="mb-2">
                    <label>Nome</label>
                    <input class="form-control" id="nome">
                </div>

                <div class="mb-2">
                    <label>Device ID</label>
                    <input class="form-control" id="device_id">
                </div>

            </div>

            <div class="modal-footer">

                <button class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Cancelar
                </button>

                <button class="btn btn-success"
                    onclick="salvar()">
                    Salvar
                </button>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

const modal=new bootstrap.Modal(document.getElementById('modal'));

listar();

async function listar(){

    const r=await fetch('/api/dispositivos');

    const j=await r.json();

    let html='';

    j.data.data.forEach(d=>{

        html+=`
        <tr>

            <td>${d.id}</td>

            <td>${d.nome}</td>

            <td>${d.device_id}</td>

            <td>${d.status_label}</td>

            <td>

                <button class="btn btn-sm btn-primary"
                    onclick="editar(${d.id})">

                    Editar

                </button>

                <button class="btn btn-sm btn-danger"
                    onclick="excluir(${d.id})">

                    Excluir

                </button>

            </td>

        </tr>`;
    });

    document.querySelector('#tabela tbody').innerHTML=html;

}

function novo(){

    id.value='';

    nome.value='';

    device_id.value='';

    modal.show();

}

async function salvar(){

    const dados={

        nome:nome.value,

        device_id:device_id.value

    };

    await fetch('/dispositivo_store',{

        method:'POST',

        headers:{
            'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content,
            'Content-Type':'application/json'
        },

        body:JSON.stringify(dados)

    });

    modal.hide();

    listar();

}

</script>

@endpush