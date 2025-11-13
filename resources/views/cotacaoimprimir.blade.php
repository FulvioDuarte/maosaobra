<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Cotação Pedido</title>
<style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        font-size: 13px;
        background-color: #f4f6f9;
        color: #333;
        padding: 20px;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        background-color: white;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        border-radius: 6px;
        overflow: hidden;
    }
    td, th {
        border: 1px solid #dcdcdc;
        padding: 6px 8px;
        vertical-align: middle;
        font-size: 12px;
    }
    th {
        background: linear-gradient(#f8f9fa, #e9ecef);
        font-weight: bold;
    }
    .no-border {
        border: none !important;
        background-color: transparent !important;
        box-shadow: none;
    }
    .highlight {
        background-color: #fff3cd;
        font-weight: bold;
        color: #856404;
    }
    .center {
        text-align: center;
    }
    .bold {
        font-weight: bold;
    }
    .right {
        text-align: right;
    }
    tr:hover td {
        background-color: #f1f1f1;
    }
    
</style>
</head>
<body>

<div class="header" style="display: flex; align-items: center; justify-content: space-between;">
    <img src="{{ asset('imgs/tambasalogo.png') }}" alt="Logo Empresa" 
         style="width: 200px; height: auto; margin-right: 15px;">
    <div class="title" style="font-size: 11px; font-weight: bold;">
        COTAÇÃO PEDIDO NÚMERO #{{ $cabecalho->numero_pedido }}
    </div>
</div>

<!-- Datas -->
<table class="no-border" style="margin-bottom: 10px;">
    <tr>
        <td class="no-border"><strong>SOLICITAÇÃO:</strong> {{ $cabecalho->data_solicitacao ? date_format($cabecalho->data_solicitacao, 'd/m/y') : '' }} </td>
    </tr>
    <tr>
        <td class="no-border"><strong>ENVIO COTAÇÕES:</strong> {{ $cabecalho->data_envio_cotacao ? date_format($cabecalho->data_envio_cotacao, 'd/m/y') : '' }} </td>
    </tr>
    <tr>
        <td class="no-border"><strong>APROVAÇÃO:</strong> {{ $cabecalho->data_aprovacao ? date_format($cabecalho->data_aprovacao, 'd/m/y') : '' }} </td>
    </tr>
</table>

<!-- Cabeçalho principal -->
<table>
    <tr>
        <th colspan="30" class="center">COTAÇÃO PEDIDO NÚMERO #{{ $cabecalho->numero_pedido }}</th>
    </tr>

    <!-- Linha de Comprador e Nome das Empresas -->
    <tr>
        <td colspan="12" class="bold">COMPRADOR: {{ $cabecalho->comprador }}</td>

        @if (isset($empresas[0]))
            <td colspan="6" class="center bold" style="background-color:#d4edda;">{{ $empresas[0]->nome }}</td>
        @else
            <td colspan="6" class="center bold" style="background-color:#d4edda;"> - </td>
        @endif

        @if (isset($empresas[1]))
            <td colspan="6" class="center bold" style="background-color:#d4edda;">{{ $empresas[1]->nome }}</td>
        @else
            <td colspan="6" class="center bold" style="background-color:#d4edda;"> - </td>
        @endif

        @if (isset($empresas[2]))
            <td colspan="6" class="center bold" style="background-color:#d4edda;">{{ $empresas[2]->nome }}</td>
        @else
            <td colspan="6" class="center bold" style="background-color:#d4edda;"> - </td>
        @endif
    </tr>

    <!-- Cidade -->
    <tr>
        <td colspan="6" class="bold">SOLICITANTE: {{ $cabecalho->solicitante }}</td>
        <td colspan="6" class="bold" style="background-color:#f6f9d4;">CENTRO DE CUSTO: {{ $cabecalho->centro_custo }}</td>

        @if (isset($empresas[0]))
            <td colspan="6" class="center">{{ $empresas[0]->cidade }} / {{ $empresas[0]->uf }}</td>
        @else
            <td colspan="6" class="center"></td>
        @endif

        @if (isset($empresas[1]))
            <td colspan="6" class="center">{{ $empresas[1]->cidade }} / {{ $empresas[1]->uf }}</td>
        @else
            <td colspan="6" class="center"></td>
        @endif

        @if (isset($empresas[2]))
            <td colspan="6" class="center">{{ $empresas[2]->cidade }} / {{ $empresas[2]->uf }}</td>
        @else
            <td colspan="6" class="center"></td>
        @endif

    </tr>

    <!-- Contato -->
    <tr>
        <td colspan="6" class="bold">SETOR: {{ $cabecalho->setor }}</td>
        <td colspan="6" class="bold" style="background-color:#f6f9d4;">ORDEM DE SERVIÇO: {{ $cabecalho->ordem_servico }}</td>

        @if (isset($empresas[0]))
            <td colspan="6" class="center">{{ $empresas[0]['contato'] }}</td>
        @else
            <td colspan="6" class="center"></td>
        @endif
        
        @if (isset($empresas[1]))
            <td colspan="6" class="center">{{ $empresas[1]->contato }}</td>
        @else
            <td colspan="6" class="center"></td>
        @endif
        
        @if (isset($empresas[2]))
            <td colspan="6" class="center">{{ $empresas[2]->contato }}</td>
        @else
            <td colspan="6" class="center"></td>
        @endif
    </tr>

    <!-- Telefone -->
    <tr>
        <td colspan="12" class="bold">TEL. / RAMAL: {{ $cabecalho->telefone_ramal }}</td>

        @if (isset($empresas[0]))
            <td colspan="6" class="center">{{ $empresas[0]->telefone1 }} {{ $empresas[0]->telefone2 }} </td>
        @else
            <td colspan="6" class="center"></td>
        @endif

        @if (isset($empresas[1]))
            <td colspan="6" class="center">{{ $empresas[1]->telefone1 }} {{ $empresas[1]->telefone2 }} </td>
        @else
            <td colspan="6" class="center"></td>
        @endif

        @if (isset($empresas[2]))
            <td colspan="6" class="center">{{ $empresas[2]->telefone1 }} {{ $empresas[2]->telefone2 }} </td>
        @else
            <td colspan="6" class="center"></td>
        @endif
    </tr>

    <!-- Cabeçalho dos itens -->
    <tr>
        <th colspan="2" class="center">ITEM</th>
        <th colspan="2" class="center">REQUISIÇÃO</th>
        <th colspan="2" class="center">SAP</th>
        <th colspan="2" class="center">QTDE</th>
        <th colspan="2" class="center">UN</th>
        <th colspan="2" class="center">DESCRIÇÃO</th>
 
        <th colspan="2" class="center">ENVIO</th>
        <th colspan="2" class="center">PREÇO UN</th>
        <th colspan="2" class="center">PREÇO TOTAL</th>
 
        <th colspan="2" class="center">ENVIO</th>
        <th colspan="2" class="center">PREÇO UN</th>
        <th colspan="2" class="center">PREÇO TOTAL</th>
 
        <th colspan="2" class="center">ENVIO</th>
        <th colspan="2" class="center">PREÇO UN</th>
        <th colspan="2" class="center">PREÇO TOTAL</th>
    </tr>

    @foreach ($items as $indice=>$item)
        <tr>
            <td colspan="2" class="center">{{ $indice }}</td>
            <td colspan="2" class="center">{{ $item['requisicao'] }}</td>
            <td colspan="2" class="center">{{ $item['sap'] }}</td>
            <td colspan="2" class="center">{{ $item['qtde'] }}</td>
            <td colspan="2" class="center">{{ $item['unidade'] }}</td>
            <td colspan="2" class="center">{{ $item['descricao'] }}</td>    
           
            @if (isset($item->cotacao[0]))
                <td colspan="2" class="center">{{ $item->cotacao[0]->dias_envio }} dias CIF</td>
                <td colspan="2" class="center">{{ number_format($item->cotacao[0]->preco_un, 2, ',', '.') }}</td>
                <td colspan="2" class="center">{{ number_format($item->cotacao[0]->preco_un * $item->cotacao[0]->qtde, 2, ',', '.') }}</td>
            @endif
            
            @if (isset($item->cotacao[1]))
                <td colspan="2" class="center">{{ $item->cotacao[1]->dias_envio }} dias CIF</td>
                <td colspan="2" class="center">{{ number_format($item->cotacao[1]->preco_un, 2, ',', '.') }}</td>
                <td colspan="2" class="center">{{ number_format($item->cotacao[1]->preco_un * $item->cotacao[1]->qtde, 2, ',', '.') }}</td>
            @endif

            @if (isset($item->cotacao[2]))
                <td colspan="2" class="center">{{ $item->cotacao[2]->dias_envio }} dias CIF</td>
                <td colspan="2" class="center">{{ number_format($item->cotacao[2]->preco_un, 2, ',', '.') }}</td>
                <td colspan="2" class="center">{{ number_format($item->cotacao[2]->preco_un * $item->cotacao[2]->qtde, 2, ',', '.') }}</td>
            @endif
        </tr>
    @endforeach
  
    <!-- Frete -->
    <tr>
        <td colspan="12" class="highlight center">
        </td>

        <td colspan="4" class="center">Frete</td>
        @if (isset($freteDesconto[0]))
            <th colspan="2">{{ number_format($freteDesconto[0]->frete, 2, ',', '.') }}</th>
        @else
            <th colspan="2"> -- </th>
        @endif
       
        <td colspan="4" class="center">Frete</td>
        @if (isset($freteDesconto[1]))
            <th colspan="2">{{ number_format($freteDesconto[1]->frete, 2, ',', '.') }}</th>
        @else
            <th colspan="2"> -- </th>
        @endif
       
        <td colspan="4" class="center">Frete</td>
        @if (isset($freteDesconto[2]))
            <th colspan="2">{{ number_format($freteDesconto[2]->frete, 2, ',', '.') }}</th>
        @else
            <th colspan="2"> -- </th>
        @endif
    </tr>
  
    <!-- Desconto -->
    <tr>
        <td colspan="12" class="highlight center" style="font-size: 11px;">
            PARA DEFINIÇÃO CONSIDERAR: PREÇO / FRETE / ENTREGA / MODELO
        </td>

        <td colspan="4" class="center">Desconto</td>
        @if (isset($freteDesconto[0]))
            <th colspan="2" class="center">{{ number_format($freteDesconto[0]->desconto, 2, ',', '.') }}</th>
        @else
            <th colspan="2" class="center"> -- </th>
        @endif
       
        <td colspan="4" class="center">Desconto</td>
        @if (isset($freteDesconto[1]))
            <th colspan="2" class="center">{{ number_format($freteDesconto[1]->desconto, 2, ',', '.') }}</th>
        @else
            <th colspan="2" class="center"> -- </th>
        @endif
       
        <td colspan="4" class="center">Desconto</td>
        @if (isset($freteDesconto[2]))
            <th colspan="2" class="center">{{ number_format($freteDesconto[2]->desconto, 2, ',', '.') }}</th>
        @else
            <th colspan="2" class="center"> -- </th>
        @endif
    </tr>
  
    <!-- Desconto -->
    <tr>
        <td colspan="12" class="highlight center" style="font-size: 11px;">
            APÓS DEFINIÇÃO SERÁ FEITA NOVA NEGOCIAÇÃO DE PREÇO
        </td>

        <td colspan="4" class="center bold" style="background-color:#f6f9d4;">TOTAL</td>
        @if (isset($precoTotal[0]))
            @if ($menorpreco == 0)
                <td colspan="2" class="center bold" style="background-color:#00FFFF;"> {{ number_format($precoTotal[0]['valor_produtos'] + $freteDesconto[0]['frete'] - $freteDesconto[0]['desconto'], 2, ',', '.') }}</td>
            @else
                <td colspan="2" class="center bold" style="background-color:#f6f9d4;"> {{ number_format($precoTotal[0]['valor_produtos'] + $freteDesconto[0]['frete'] - $freteDesconto[0]['desconto'], 2, ',', '.') }}</td>
            @endif
        @else
            <td colspan="2" class="center bold" style="background-color:#f6f9d4;"> -- </td>
        @endif
       
        <td colspan="4" class="center bold" style="background-color:#f6f9d4;">TOTAL</td>
        @if (isset($precoTotal[1]))
            @if ($menorpreco == 1)
                <td colspan="2" class="center bold" style="background-color:#00FFFF;"> {{ number_format($precoTotal[1]['valor_produtos'] + $freteDesconto[1]['frete'] - $freteDesconto[1]['desconto'], 2, ',', '.') }}</td>
            @else
                <td colspan="2" class="center bold" style="background-color:#f6f9d4;"> {{ number_format($precoTotal[1]['valor_produtos'] + $freteDesconto[1]['frete'] - $freteDesconto[1]['desconto'], 2, ',', '.') }}</td>
            @endif
        @else
            <td colspan="2" class="center bold" style="background-color:#f6f9d4;"> -- </td>
        @endif
       
        <td colspan="4" class="center bold" style="background-color:#f6f9d4;">TOTAL</td>
        @if (isset($precoTotal[2]))
            @if ($menorpreco == 2)
                <td colspan="2" class="center bold" style="background-color:#00FFFF;"> {{ number_format($precoTotal[2]['valor_produtos'] + $freteDesconto[2]['frete'] - $freteDesconto[2]['desconto'], 2, ',', '.') }}</td>
            @else
                <td colspan="2" class="center bold" style="background-color:#f6f9d4;"> {{ number_format($precoTotal[2]['valor_produtos'] + $freteDesconto[2]['frete'] - $freteDesconto[2]['desconto'], 2, ',', '.') }}</td>
            @endif
        @else
            <td colspan="2" class="center bold" style="background-color:#f6f9d4;"> -- </td>
        @endif
    </tr>
</table>

<br>
<span class="center bold" style="font-size: 11px; display:block; text-align:right;">  Aprovação </span>
<span class="center bold" style="font-size: 14px; display:block; text-align:right;">  {{ $cabecalho->aprovacao  }} </span>
<br>
<span class="center bold" style="display:block; text-align:right;">  _______________________________________ </span>
</body>
</html>
