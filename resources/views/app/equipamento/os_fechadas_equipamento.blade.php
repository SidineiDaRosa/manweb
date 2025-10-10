   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <main class="content">
       <div class="div-title-main">O.S. FECHADAS POR EQUIPAMENTO</div>
       <div class="container">
           <style>
               .div-title-main {
                   font-family: sans-serif;
                   font-weight: 500;
                   font-size: 30px;
                   text-transform: uppercase;
                   color: darkgray;
                   text-align: center;
                   /* Centraliza o texto dentro da div */
                   display: flex;
                   justify-content: center;
                   /* Centraliza a div no container pai */
                   align-items: center;
                   /* Alinha verticalmente se necessário */
                   margin: 0 auto;
                   /* Garante que a margem esquerda e direita sejam iguais */
               }

               .div-title-subtitle {
                   font-family: sans-serif;
                   font-weight: 500;
                   font-size: 25px;
                   text-transform: uppercase;
               }

               .div-title-subtitle {
                   font-family: sans-serif;
                   font-weight: 500;
                   font-size: 25px;
                   text-transform: uppercase;
                   color: orchid;
               }

               .div-title-subtitle :hover {
                   color: red;
               }

               .div-title-subtitle-md {
                   font-family: sans-serif;
                   font-weight: 500;
                   font-size: 20px;
                   text-transform: uppercase;
               }

               .div-conteudo-md {
                   font-family: sans-serif;
                   font-weight: 300;
                   font-size: 18px;
               }

               .txt-link {
                   color: cornflowerblue;
                   font-family: Arial, Helvetica, sans-serif;
                   font-size: 18px;
               }

               .txt-link:hover {
                   color: red;
               }

               @media (max-width: 900px) {
                   .div-box-main {
                       height: 300px;

                   }
               }
           </style>

           <div class="div-title-subtitle">
               <a href="{{ route('equipamento.show', ['equipamento' => $equipamento->id]) }}" class="fw-bold text-decoration-none">
                   {{ $equipamento->nome }}
               </a>
           </div>

           <!-- Botão para documentos, manual e diagrama elétrico -->
           <a href="{{ $equipamento->anexo_1 }}" target="_blank" class="btn btn-outline-primary btn-md me-2 mt-2">
               <i class="bi bi-file-earmark-text me-1"></i> Documentos anexados, Manual, Diagrama elétrico
           </a>

           <!-- Botão para procedimentos de manutenção -->
           <a href="{{ $equipamento->anexo_2 }}" target="_blank" class="btn btn-outline-success btn-md mt-2">
               <i class="bi bi-gear-wide-connected me-1"></i> Procedimentos de Manutenção
           </a>
           <!-- Certifique-se de ter Bootstrap Icons incluído -->
           <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

           <a href="{{ route('check-list-funcionario', ['equipamento_id' => $equipamento->id]) }}"
               class="btn btn-primary btn-md me-2">
               <i class="bi bi-check2-square me-1"></i> Iniciar Check-List
           </a>

           <a href="{{ route('executar.lubrificacao', ['equipamento' => $equipamento->id]) }}"
               class="btn btn-success btn-md">
               <i class="bi bi-droplet-half me-1"></i> Iniciar Lubrificação
           </a>


           @foreach($equipamento_filho as $equipamento_filho_f)
           <h4 hidden>{{$equipamento_filho_f->nome}}</h4>
           @endforeach
           <div class="div-box-main" style="font-size: 20px; margin: 10px;">
               @foreach($usuarios as $usuario_f)
               @endforeach
               @foreach($ordens_servicos as $ordens_servico)
               <div style=" border: 1px solid darkgrey;border-radius:5px;padding:10px;">
                   <span style="font-family: Arial, Helvetica, sans-serif;font-size:25px;">ID: {{$ordens_servico->id}}</span> <br>
                   <span style="color: green;font-family:Arial, Helvetica, sans-serif">Responsável: {{$ordens_servico->responsavel}}</span> <br>
                   <span style="color: blue;font-family:Arial, Helvetica, sans-serif">Data e hora: {{ \Carbon\Carbon::parse($ordens_servico->data_fim)->format('d/m/Y') }} às {{$ordens_servico->hora_fim}}</span>
                   <div style="color:darkblue;font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
                       Descrição da solicitação:</div>
                   <div class="div-conteudo-md">
                       {{$ordens_servico->descricao}}
                   </div>
                   <hr>
                   <div style="color:darkblue;font-family:Arial;">
                       Serviços executados:
                   </div>
                   @php
                   // Filtra serviços executados com base no 'ordem_servico_id'
                   $servicosFiltrados = $servicos_executados_colecao->where('ordem_servico_id', $ordens_servico->id);
                   @endphp
                   @foreach($servicosFiltrados as $servico_executado)
                   <hr>
                   <span style="font-family:Arial, Helvetica, sans-serif">Executor: {{$servico_executado->funcionario->primeiro_nome}},
                       {{ \Carbon\Carbon::parse($servico_executado->data_inicio)->format('d/m/Y') }} às {{$servico_executado->hora_inicio}} <br>
                   </span>
                   <span style="font-family:Arial, Helvetica, sans-serif;font-size:16px; font-weight:300;">{{$servico_executado->descricao}} </span><br>

                   @endforeach

               </div>
               <div style="height:20px;background-color:lightgreen;margin:5px;"></div>
               @endforeach
           </div>
       </div>
   </main>