<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Almox - Tambasa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-extended.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontes.css') }}">

    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .layout-wrapper {
            display: flex;
            min-height: 100vh;
            transition: all 0.3s ease;
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

        #mensagem {
            transition: opacity 1s ease;
        }
    </style>
</head>

<body>
    <div class="layout-wrapper">

        @include('components.menu')

<!-- Conteúdo principal -->
<main id="main-content">
    <!-- Botão para mostrar/ocultar menu -->
    <div class="d-flex align-items-center mb-2">
        <button class="btn btn-outline-secondary d-none d-md-block" id="toggleSidebar" style="margin-right: 40px;">
            ☰
        </button>
        <span class="h5 mb-0">Gestão de Compras Consumo - EDITAR COTAÇÃO - Pedido #{{ $pedido->numero_pedido }}</span>
    </div>

    <!-- Adiciona container-fluid aqui -->
    <div class="container-fluid">
        <div class="p-2 mb-1" style="background: #fff; border: 1px solid #dee2e6; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            <form action="{{ route('salvarcotacaofornec') }}" method="POST">
                @csrf
                @foreach ($cotacaos as $i => $cotacao)

                    <input type="hidden" name="dados[{{ $i }}][id]" value="{{ $cotacao->id }}">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nomeproduto">Descrição Produto</label>
                            <input type="text" class="form-control" name="dados[{{ $i }}][nomeproduto]" value="{{ $cotacao->nomeproduto }}" disabled>
                        </div>
                        <div class="col-md-1">
                            <label for="qtde">Qtde</label>
                            <input type="text" class="form-control" name="dados[{{ $i }}][qtde]" value="{{ $cotacao->qtde }}" disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="preco_un">Preço UN</label>
                            <input type="text" class="form-control preco"  name="dados[{{ $i }}][preco_un]" value="{{ number_format($cotacao->preco_un, 2, ',', '.') }}">
                        </div>
                    </div>
                    <br>
                @endforeach                
                <br>

                <label>FRETE / DESCONTO</label>

                <div class="row">
                    <div class="col-md-1">
                        <label for="diasenvio">Dias envio</label>
                        <input type="number" class="form-control" name="dias_envio" value="{{ $cotacao->dias_envio }}">
                    </div>
                    <div class="col-md-2">
                        <label for="frete">Frete</label>
                        <input type="text" class="form-control preco" name="frete" value="{{ number_format($cotacao->frete, 2, ',', '.') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="desconto">Desconto</label>
                        <input type="text" class="form-control preco" name="desconto" value="{{ number_format($cotacao->desconto, 2, ',', '.') }}">
                    </div>
                </div>

                    <br>
                <br>
                <button type="submit" class="btn btn-success mx-1">SALVAR DADOS</button>
            </form>
        </div>
        <br>
        <br>
        <div>
            <a href="{{ route('visualizacotacaofornec', ['pedido_id' => $pedido->id]) }}">⬅️ Voltar</a>

        </div>
    </div>
</main>

    </div>

</body>

<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('jquery/jquery.mask.min.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Alternar sidebar
        document.getElementById('toggleSidebar')?.addEventListener('click', function () {
            document.getElementById('sidebar')?.classList.toggle('hidden');
        });
    });

    $(document).ready(function() {
        $('.preco').each(function() {
            var $campo = $(this);
            var valorInicial = $campo.val();

            $campo.mask("000.000.000,00", {reverse: true});
            $campo.val(valorInicial);
        });
    });

        
</script>

</html>
