<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Modelo de Tabelas - Pedido de Compra</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      max-width: 900px;
      margin: 20px auto;
      color: #333;
      line-height: 1.6;
    }
    h1 {
      text-align: center;
      color: #007BFF;
    }
    h2 {
      color: #0056b3;
      margin-top: 40px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      margin-bottom: 10px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 6px 10px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    code {
      background-color: #f4f4f4;
      padding: 2px 4px;
      border-radius: 4px;
      font-family: Consolas, monospace;
    }
    pre {
      background-color: #f4f4f4;
      padding: 10px;
      border-radius: 4px;
      overflow-x: auto;
      font-family: Consolas, monospace;
      margin-bottom: 30px;
    }
  </style>
</head>
<body>

  <h1>Modelo de Tabelas - Sistema de Pedido de Compra</h1>

  <h2>1. Tabela: pedidos_compra (Cabeçalho)</h2>
  <table>
    <tr><th>Campo</th><th>Tipo</th><th>Descrição</th></tr>
    <tr><td>id</td><td>bigint (PK)</td><td>Identificador do pedido</td></tr>
    <tr><td>codigo</td><td>string</td><td>Código do pedido (ex: PO-0001)</td></tr>
    <tr><td>data_pedido</td><td>date</td><td>Data do pedido</td></tr>
    <tr><td>solicitante_id</td><td>bigint (FK)</td><td>Usuário que solicitou</td></tr>
    <tr><td>departamento_id</td><td>bigint (FK)</td><td>Departamento solicitante</td></tr>
    <tr><td>fornecedor_id</td><td>bigint (FK)</td><td>Fornecedor escolhido</td></tr>
    <tr><td>situacao</td><td>string</td><td>Status atual: aberto, aprovado, cancelado...</td></tr>
    <tr><td>observacoes</td><td>text</td><td>Observações gerais</td></tr>
    <tr><td>created_at / updated_at</td><td>timestamps</td><td>Datas de criação e atualização</td></tr>
  </table>
  <pre><code>CREATE TABLE pedidos_compra (
  id BIGINT PRIMARY KEY,
  codigo VARCHAR(255),
  data_pedido DATE,
  solicitante_id BIGINT,
  departamento_id BIGINT,
  fornecedor_id BIGINT,
  situacao VARCHAR(255),
  observacoes TEXT,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
</code></pre>

  <h2>2. Tabela: pedido_compra_itens</h2>
  <table>
    <tr><th>Campo</th><th>Tipo</th><th>Descrição</th></tr>
    <tr><td>id</td><td>bigint (PK)</td><td>Identificador do item</td></tr>
    <tr><td>pedido_compra_id</td><td>bigint (FK)</td><td>Relaciona com o cabeçalho</td></tr>
    <tr><td>produto_id</td><td>bigint (FK)</td><td>Produto ou item relacionado</td></tr>
    <tr><td>descricao</td><td>string</td><td>Descrição do item</td></tr>
    <tr><td>quantidade</td><td>integer</td><td>Quantidade solicitada</td></tr>
    <tr><td>preco_unitario</td><td>decimal(10,2)</td><td>Preço unitário</td></tr>
    <tr><td>subtotal</td><td>decimal(10,2)</td><td>Total do item (quantidade × preço)</td></tr>
    <tr><td>observacoes</td><td>text</td><td>Observações específicas do item</td></tr>
    <tr><td>created_at</td><td>timestamp</td><td>Data de criação</td></tr>
  </table>
  <pre><code>CREATE TABLE pedido_compra_itens (
  id BIGINT PRIMARY KEY,
  pedido_compra_id BIGINT,
  produto_id BIGINT,
  descricao VARCHAR(255),
  quantidade INTEGER,
  preco_unitario DECIMAL(10,2),
  subtotal DECIMAL(10,2),
  observacoes TEXT,
  created_at TIMESTAMP
);
</code></pre>

  <h2>3. Tabela: pedido_compra_eventos (Histórico)</h2>
  <table>
    <tr><th>Campo</th><th>Tipo</th><th>Descrição</th></tr>
    <tr><td>id</td><td>bigint (PK)</td><td>ID do evento</td></tr>
    <tr><td>pedido_compra_id</td><td>bigint (FK)</td><td>Pedido relacionado</td></tr>
    <tr><td>status_anterior</td><td>string</td><td>Status antes da mudança</td></tr>
    <tr><td>status_novo</td><td>string</td><td>Status depois da mudança</td></tr>
    <tr><td>usuario_id</td><td>bigint (FK)</td><td>Quem fez a mudança</td></tr>
    <tr><td>justificativa</td><td>text</td><td>Motivo da alteração</td></tr>
    <tr><td>created_at</td><td>timestamp</td><td>Data da alteração</td></tr>
  </table>
  <pre><code>CREATE TABLE pedido_compra_eventos (
  id BIGINT PRIMARY KEY,
  pedido_compra_id BIGINT,
  status_anterior VARCHAR(255),
  status_novo VARCHAR(255),
  usuario_id BIGINT,
  justificativa TEXT,
  created_at TIMESTAMP
);
</code></pre>

  <h2>4. Tabela: pedido_compra_anexos</h2>
  <table>
    <tr><th>Campo</th><th>Tipo</th><th>Descrição</th></tr>
    <tr><td>id</td><td>bigint (PK)</td><td>ID do anexo</td></tr>
    <tr><td>pedido_compra_id</td><td>bigint (FK)</td><td>Pedido relacionado</td></tr>
    <tr><td>nome_original</td><td>string</td><td>Nome do arquivo enviado</td></tr>
    <tr><td>caminho_arquivo</td><td>string</td><td>Local onde o arquivo está salvo</td></tr>
    <tr><td>tipo_mime</td><td>string</td><td>Tipo do arquivo (ex: application/pdf)</td></tr>
    <tr><td>usuario_id</td><td>bigint (FK)</td><td>Quem anexou</td></tr>
    <tr><td>created_at</td><td>timestamp</td><td>Data do upload</td></tr>
  </table>
  <pre><code>CREATE TABLE pedido_compra_anexos (
  id BIGINT PRIMARY KEY,
  pedido_compra_id BIGINT,
  nome_original VARCHAR(255),
  caminho_arquivo VARCHAR(255),
  tipo_mime VARCHAR(255),
  usuario_id BIGINT,
  created_at TIMESTAMP
);
</code></pre>

  <h2>5. Tabela: pedido_compra_aprovacoes</h2>
  <table>
    <tr><th>Campo</th><th>Tipo</th><th>Descrição</th></tr>
    <tr><td>id</td><td>bigint (PK)</td><td>ID da aprovação</td></tr>
    <tr><td>pedido_compra_id</td><td>bigint (FK)</td><td>Pedido relacionado</td></tr>
    <tr><td>usuario_id</td><td>bigint (FK)</td><td>Usuário que aprovou ou rejeitou</td></tr>
    <tr><td>nivel_aprovacao</td><td>string</td><td>Nível (ex: Financeiro, Gerência)</td></tr>
    <tr><td>status</td><td>string</td><td>aprovado / rejeitado / pendente</td></tr>
    <tr><td>justificativa</td><td>text</td><td>Motivo da decisão</td></tr>
    <tr><td>data_aprovacao</td><td>timestamp</td><td>Data da ação</td></tr>
  </table>
  <pre><code>CREATE TABLE pedido_compra_aprovacoes (
  id BIGINT PRIMARY KEY,
  pedido_compra_id BIGINT,
  usuario_id BIGINT,
  nivel_aprovacao VARCHAR(255),
  status VARCHAR(255),
  justificativa TEXT,
  data_aprovacao TIMESTAMP
);
</code></pre>

</body>
</html>
