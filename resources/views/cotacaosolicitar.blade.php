<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Solicitacao Cotacao - {{ $cabecalho->codigo }}</title>

  <style>
    :root{
      --brand: #2d6cdf;       /* cor principal */
      --brand-2: #6ea8fe;     /* cor auxiliar */
      --ink: #2f343b;         /* texto principal */
      --muted: #6b7177;       /* texto secundário */
      --panel: #ffffff;       /* fundo do cartão */
      --bg: #f4f7fb;          /* fundo da página */
      --line: #e5e9f2;        /* linhas/bordas */
    }

    * { box-sizing: border-box }
    html, body { height: 100% }

    body {
      margin: 40px;
      font-family: "Inter", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      color: var(--ink);
      background:
        radial-gradient(circle at 25px 25px, #e9eef7 2px, transparent 2px) 0 0/22px 22px,
        var(--bg); /* textura de pontos bem discreta */
    }

    /* Faixa superior sutil de marca */
    .brand-bar {
      height: 6px;
      background: linear-gradient(90deg, var(--brand), var(--brand-2));
      border-radius: 10px;
      margin: 0 auto 16px;
      max-width: 900px;
    }

    .container {
      max-width: 900px;
      margin: 0 auto;
      background: var(--panel);
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(24,39,75,0.08);
      border: 1px solid var(--line);
    }

    header {
      text-align: center;
      margin-bottom: 28px;
    }
    header img {
      max-height: 72px;
      margin-bottom: 12px;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.08));
    }
    header h1 {
      margin: 0;
      font-size: 24px;
      font-weight: 700;
      letter-spacing: .2px;
      color: #1f2937;
    }
    header .subtitle {
      margin-top: 4px;
      font-size: 13px;
      color: var(--muted);
    }

    .info {
      margin-bottom: 20px;
      background: linear-gradient(0deg, #f9fbff, #ffffff);
      border: 1px solid var(--line);
      border-left: 4px solid var(--brand);
      border-radius: 10px;
      padding: 16px 18px;
    }
    .info p {
      margin: 6px 0;
      font-size: 14px;
    }
    .info strong { color: #111827; }

    h2 {
      font-size: 18px;
      margin-top: 26px;
      margin-bottom: 8px;
      color: #1f2937;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      font-weight: 700;
    }
    h2::before{
      content: "";
      width: 8px;
      height: 18px;
      border-radius: 4px;
      background: linear-gradient(180deg, var(--brand), var(--brand-2));
      display: inline-block;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 14px;
      overflow: hidden;
      border-radius: 10px;
      border: 1px solid var(--line);
    }
    thead th {
      background: linear-gradient(0deg, #eef4ff, #f6f9ff);
      color: #0f172a;
      font-weight: 700;
      border-bottom: 1px solid var(--line);
    }
    table th, table td {
      padding: 12px 12px;
      font-size: 14px;
      text-align: left;
      border-bottom: 1px solid var(--line);
    }
    tbody tr:nth-child(even) { background: #fbfdff; }
    tbody tr:hover { background: #f3f8ff; }

    footer {
      margin-top: 28px;
      font-size: 13px;
      text-align: center;
      color: var(--muted);
    }

    /* Melhor visual na impressão */
    @media print {
      body { margin: 0; background: #fff; }
      .brand-bar { display: none; }
      .container {
        box-shadow: none;
        border: none;
        padding: 20px 24px;
      }
      a { color: #000; text-decoration: none; }
    }
  </style>
</head>
<body>

  <div class="container">
    <header>
      <img src="{{ asset('imgs/tambasalogo.png') }}" alt="Logo Empresa" style="width: 200px; height: auto; margin-right: 15px;">
      <h1>Solicitação de Cotação</h1>
    </header>
    
    <div class="info">
      <p><strong>Empresa:</strong> {{ $cabecalho->razao }} </p>
      <p><strong>Nome:</strong> {{ $cabecalho->nome }} </p>
      <p><strong>Endereço:</strong> {{ $cabecalho->endereco }} - {{ $cabecalho->cidade }} / {{ $cabecalho->uf }} cep: {{ $cabecalho->cep }}</p>
      <p><strong>contato:</strong> {{ $cabecalho->email }}  / {{ $cabecalho->telefone }}</p>
      <p><strong>Data da Solicitação:</strong> {{ date_format(now(), 'd/m/Y') }}</p>
      <p><strong>Número do Cotação:</strong><span style="font-size: 16px;"> #{{ $pedido->numero_pedido }}</span></p>
    </div>

    <h2>Lista de Produtos - COTAR</h2>
    <p style="margin-top: 6px; line-height: 1.6;"> cnpj: {{ $cabecalho->cidade }} / {{ $cabecalho->uf }} </p>
    <table>
      <thead>
        <tr>
          <th>Descrição</th>
          <th style="width: 120px;">Unidade</th>
          <th style="width: 130px;">Quantidade</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($items as $item)
            <tr>
                <td> {{ $item->descricao }} </td>
                <td> {{ $item->unidade }} </td>
                <td> {{ $item->qtde }} </td>
            </tr>
        @endforeach
        
      </tbody>
    </table>

    <h2>Frete incluso / Local de entrega</h2>
    <div class="subtitle"> {{ $localentrega->nome }} - {{ $localentrega->fantasia }} </div>
    <div class="subtitle"> {{ $localentrega->endereco }} </div>
    <div class="subtitle"> {{ $localentrega->cidade }} / {{ $localentrega->uf }} </div>
    <div class="subtitle"> cep: {{ $localentrega->cep }} </div>
  
    <h2>Compra para uso - consumo</h2>
    <div class="subtitle"> Informar a marca do material </div>
    <div class="subtitle"> Informar valor mínimo para faturar </div>
    <div class="subtitle"> Informar forma de envio </div>
    <div class="subtitle"> Frete CIF será um diferencial para aprovação  </divp>
    </p>

    <footer>
      <p>Tambasa Atacadista – Compras consumo</p>
      <p>{{ Auth::user()->name }} • Telefone: (31) 3333-4444</p>
    </footer>
  </div>
</body>
</html>
