@extends('app.layouts.app')

<main class="content">
    <h3>Agrupamento do equipamento</h3>
    <h4>{{$equipamento->nome}}</h4>
    <hr>
    @foreach($equipamento_filho as $equipamento_filho_f)
    {{$equipamento_filho_f->nome}}

    <!-- resources/views/example.blade.php -->
    <a href="#" onclick="submitForm({{ $equipamento_filho_f->id }}, 1);" style="display:flex; align-items:center; margin-left:auto;">
        <span class="material-symbols-outlined">open_in_new</span>
    </a>

    <form id="postForm" action="{{ route('asset_history') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="asset_id" id="asset_id">
        <input type="hidden" name="tipofiltro" id="tipofiltro">
        <button type="submit" >Enviar</button>
    </form>

    <script>
        function submitForm(assetId, tipoFiltro) {
            document.getElementById('asset_id').value = assetId;
            document.getElementById('tipofiltro').value = tipoFiltro;
            document.getElementById('postForm').submit();
        }
    </script>

    <hr>
    @endforeach
</main>