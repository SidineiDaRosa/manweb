@extends('app.layouts.app')
<h1>O.S. FECHADAS POR EQUIPAMENTO</h1>

<h1>{{$equipamento->nome}}</h1>
<div style="font-size:20px;">
    @foreach($ordens_servicos as $ordens_servico)

    <div>ID:{{$ordens_servico->id}}</div>
    <div>Data Fim{{ \Carbon\Carbon::parse($ordens_servico->data_fim)->format('d/m/Y') }} às  {{$ordens_servico->hora_fim}}</div>
    
    <div style="font-weight:300;">{{$ordens_servico->descricao}}</div>
    <div style="color: green;">{{$ordens_servico->responsavel}}</div>
    <hr>
    @endforeach
</div>