<!DOCTYPE html>
<html class="loading" lang="pt-br" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Tambasa">
    <meta name="keywords" content="Tambasa">
    <meta name="author" content="Tambasa">
    <title>Almox - Tambasa</title>
    <link rel="apple-touch-icon" href="">
    <link rel="shortcut icon" type="image/x-icon" href="../images/ico/favicon.ico">

    <link rel="stylesheet" href="{{ asset('css/fontes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-extended.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .layout-wrapper {
            display: flex;
            min-height: 100vh;
        }

        #sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            transition: all 0.3s ease;
        }

        #sidebar.hidden {
            margin-left: -250px;
        }

        #main-content {
            flex-grow: 1;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .table-responsive {
            margin-top: 20px;
        }

        @media (max-width: 767px) {
            #sidebar {
                display: none !important;
            }
        }

        .stepper {
        display: flex;
        justify-content: space-between;
        margin: 30px 0;
        position: relative;
        gap: 20px;
        }

        .step {
        text-align: center;
        flex: 1;
        position: relative;
        }

        .step::before {
        content: '';
        position: absolute;
        top: 15px;
        left: -50%;
        width: 100%;
        height: 4px;
        background-color: #dee2e6;
        z-index: -1;
        }

        .step:first-child::before {
        display: none;
        }

        .circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        }

        .completed .circle {
        background-color: #28a745; /* Verde */
        }

        .active .circle {
        background-color: #0d6efd; /* Azul */
        }

        .pending .circle {
        background-color: #6c757d; /* Cinza */
        }

        .step p {
        margin-top: 16px;
        font-size: 14px;
        }
    </style>
</head>

<body>
  <div class="layout-wrapper">
 
    @include('components.menu')
    
    <div id="main-content" style="display: flex; flex-direction: column;">
      <h3 class="mt-4 mb-4">Fluxo da Cotação - Pedido #{{ $pedido->numero_pedido }}</h3>
    
      <div class="stepper-container">
        <div class="stepper">


          @if (is_null($pedido->data_solicitacao))
            <div class="step pending">
              <div class="circle">1</div>
              <p style="color: black">Criar Cotação</p>
            </div>
          @else
            <div class="step completed">
              <div class="circle">1</div>
              <p style="color: black">Criar Cotação</p>
              <p style="color:rgb(253, 13, 13);">Solicitação: {{ date_format($pedido->data_solicitacao, 'd/m/y') }}</p>
            </div>
          @endif
            
          @if (count($itens) == 0)
            <div class="step pending">
              <div class="circle">2</div>
              <p style="color: black">Inserir Itens</p>
              <p>Sem itens inseridos</p>
            </div>
          @else
            <div class="step completed">
              <div class="circle">2</div>
              <p style="color: black">Inserir Itens</p>
              <p style="color:rgb(253, 13, 13);"> {{ count($itens) }} item(s)</p>
            </div>
          @endif

          @if ($fornecedores == 0)
            <div class="step pending">
              <div class="circle">3</div>
              <p style="color: black">Fornecedores</p>
              <p>Sem associados</p>
            </div>
          @else
            <div class="step completed">
              <div class="circle">3</div>
              <p style="color: black">Fornecedores</p>
              <p style="color:rgb(253, 13, 13);"> {{ $fornecedores }} fornecedores</p>
            </div>
          @endif

          @if (is_null($pedido->data_envio_cotacao))
            <div class="step pending">
              <div class="circle">4</div>
              <p style="color: black">Envio Cotação Fornec.</p>
              <p> ❌ </p>
            </div>
          @else
            <div class="step completed">
              <div class="circle">4</div>
              <p style="color: black">Envio Cotação Fornec.</p>
              <p style="color:rgb(253, 13, 13);">Enviado: {{ date_format($pedido->data_envio_cotacao, 'd/m/y') }}</p>
            </div>
          @endif

          @if ($preco['semprodutos'])
            <div class="step pending">
              <div class="circle">5</div>
              <p style="color: black">Preencher Preços</p>
              <p> ❌ </p>
            </div>
          @elseif ($preco['sempreco'] == 0)
            <div class="step completed">
              <div class="circle">5</div>
              <p style="color: black">Preencher Preços</p>
              <p> ✔️</p>
            </div>
          @else
            <div class="step pending">
              <div class="circle">5</div>
              <p style="color: black">Preencher Preços</p>
              <p> ❌ </p>
            </div>
          @endif
          
          @if (is_null($pedido->documento_aprovado) || $pedido->documento_aprovado == '')
            <div class="step pending">
              <div class="circle">6</div>
              <p style="color: black">Aprovação</p>
              <p> ❌ </p>
            </div>
          @else
            <div class="step completed">
              <div class="circle">6</div>
              <p style="color: black">Aprovação</p>
              <p> ✔️ </p>
            </div>
          @endif
          
          @if (is_null($pedido->finalizado))
            <div class="step pending">
              <div class="circle">6</div>
              <p style="color: black">Finalização</p>
              <p> ❌ </p>
            </div>
          @else
            <div class="step completed">
              <div class="circle">6</div>
              <p style="color: black">Finalização</p>
              <p> ✔️ </p>
            </div>
          @endif

        </div>
      </div>
      <div>
        <a href="{{ url()->previous() }}">⬅️ Voltar</a>
      </div>   
    </div>
  </div>

</body>
</html>
