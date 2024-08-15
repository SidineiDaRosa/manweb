<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipamento</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaM51w5Cx8sL+sM2t+ERPC5PFOdYPhLSV1p7Y4g6Mj4y/8cFw5yIHqz13pC" crossorigin="anonymous">

    <!-- Bootstrap JS (opcional, para componentes como modals, tooltips, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12/Se9EAU8z9+54IeaXzRrE1F/nz0tmvf8WU70GPP6z2K2v5" crossorigin="anonymous"></script>


</head>

<main class="content">
    <div class="container">
        <style>
            .qr-code-container {
                display: none;
                margin-top: 10px;
                text-align: center;
            }

            .qr-code-container img {
                width: 400px;
                /* Ajuste o tamanho da imagem aqui */
                height: 400px;
                /* Ajuste o tamanho da imagem aqui */
            }
        </style>
        <div class="text-center" style="margin-top:20px;">
            <button type="button" class="btn btn-outline-primary" onclick="toggleQRCode()">
                <h4>{{ $equipamento->nome }}</h4> QR Code

                @php
                $url = route('assets', ['asset_id' => $equipamento->id]);
                @endphp
                
                <div id="qrCodeContainer" style="display: none; margin-top: 10px; text-align: center;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($url) }}" alt="QR Code">
                </div>
        </div>
        </button>
    </div>

    <script>
        function toggleQRCode() {
            var qrCodeContainer = document.getElementById('qrCodeContainer');
            if (qrCodeContainer.style.display === 'none' || qrCodeContainer.style.display === '') {
                qrCodeContainer.style.display = 'block';
            } else {
                qrCodeContainer.style.display = 'none';
            }
        }
    </script>
    <script>
        function toggleQRCode() {
            var qrCodeContainer = document.getElementById('qrCodeContainer');
            var divLista = document.getElementById('div-ls');
            if (qrCodeContainer.style.display === 'none' || qrCodeContainer.style.display === '') {
                qrCodeContainer.style.display = 'block';
                divLista.style.display = 'none';
            } else {
                qrCodeContainer.style.display = 'none';
                divLista.style.display = 'block';
            }
        }
    </script>

    <hr>
    <div id="div-ls" style="margin-left:20px;font-size:30px;">
        @foreach($equipamento_filho as $equipamento_filho_f)
        {{ $equipamento_filho_f->nome }}

        <a href="#" onclick="submitForm({{ $equipamento_filho_f->id }}, 1);" style="display:flex; align-items:center; margin-left:auto;">
            <button type="submit" class="btn btn-outline-primary btn-bg">Buscar</button>
        </a>

        <form id="postForm" action="{{ route('asset_history') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="asset_id" id="asset_id">
            <input type="hidden" name="tipofiltro" id="tipofiltro">
            <button type="submit">Enviar</button>
        </form>

        <div class="card-body" hidden>
            <?php
            $protocolo = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === "on") ? "https" : "http";
            $url = '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $urlPaginaAtual = $protocolo . $url;
            ?>
            {!! QrCode::size(150)->backgroundColor(255,255,255)->generate($urlPaginaAtual) !!}
        </div>

        @php
        $url = route('asset.show', ['asset_id' => $equipamento_filho_f->id ]);
        @endphp
        <div>
            <p><span style="font-size:20px;color:green;">Descrição:</span> <span style="font-size:20px;color:black;">{{$equipamento_filho_f->descricao}}</span></p>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($url) }}" alt="QR Code" hidden>
        </div>



        <hr>
        @endforeach
    </div>
</main>

<script>
    function submitForm(assetId, tipoFiltro) {
        document.getElementById('asset_id').value = assetId;
        document.getElementById('tipofiltro').value = tipoFiltro;
        document.getElementById('postForm').submit();
    }
</script>