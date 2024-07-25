@extends('app.layouts.app')
@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>
                Pedido de saida sem os
            </div>
            <div>
              ID:{{$pedido_saida->id}}
              data:{{$pedido_saida->data_emissao}}
            </div>
        </div>
</main>
@endsection