<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Painel OS Grid</title>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f8;
        margin: 0;
        padding: 20px;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .grid-os {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }

    .os-card {
        background: #fff;
        padding: 12px;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        font-size: 14px;
    }

    .os-card h3 {
        margin-top: 0;
        color: #0d6efd;
        font-size: 16px;
    }

    .item {
        margin-bottom: 5px;
    }

    .label {
        font-weight: bold;
    }

    /* Lightbox overlay */
    .lightbox {
        display: none; /* escondido por padrão */
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        justify-content: center;
        align-items: center;
    }

    .lightbox img {
        max-width: 90%;
        max-height: 90%;
        border-radius: 6px;
        box-shadow: 0 0 15px #000;
    }

    /* Responsivo grid */
    @media (max-width: 1200px) {
        .grid-os { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 700px) {
        .grid-os { grid-template-columns: 1fr; }
    }
</style>
</head>
<body>

<h1>Painel de Ordens de Serviço</h1>

<div class="grid-os">
    @foreach($ordem_servicos as $ordem_servico)
        <div class="os-card">
            <h3>{{ $ordem_servico->id }} <span style="color: darkblue;">{{ $ordem_servico->equipamento->nome }}</span> - {{ $ordem_servico->situacao ?? 'Não definido' }}</h3>

            <div class="item"><span class="label">Datas:</span> {{ $ordem_servico->data_inicio }} - {{ $ordem_servico->hora_inicio }}, {{ $ordem_servico->data_fim }} - {{ $ordem_servico->hora_fim }}</div>
            <div class="item"><span class="label">Descrição:</span> {{ $ordem_servico->descricao }}</div>

            @if($ordem_servico->ss && $ordem_servico->ss->imagem)
                <div class="item" style="margin-top:10px;">
                    <img src="{{ asset('img/request_os/' . $ordem_servico->ss->imagem) }}" 
                         alt="Foto SS" 
                         class="click-expand" 
                         style="width:100%; max-height:200px; object-fit:cover; border-radius:4px; cursor:pointer;">
                </div>
            @endif
        </div>
    @endforeach
</div>

<!-- Lightbox -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <img id="lightbox-img" src="">
</div>

<script>
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');

    // Quando clicar na imagem
    document.querySelectorAll('.click-expand').forEach(img => {
        img.addEventListener('click', () => {
            lightbox.style.display = 'flex';
            lightboxImg.src = img.src;
        });
    });

    function closeLightbox() {
        lightbox.style.display = 'none';
        lightboxImg.src = '';
    }
</script>

</body>
</html>
