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
        <span class="h5 mb-0">Gestão de Compras Consumo - FINALIZAR COTAÇÃO - Pedido #{{ $pedido->numero_pedido }}</span>
    </div>

    <!-- Adiciona container-fluid aqui -->
    <div class="container-fluid">
        <div class="p-2 mb-1" style="background: #fff; border: 1px solid #dee2e6; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            <form action="{{ route('gravafinalizado') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="pedido_id" value="{{ $pedido->id }}">
                <div class="row">
                    <div class="col-md-2">
                        <label for="numero_pedido">Número Pedido</label>
                        <input type="text" class="form-control" value="{{ $pedido->numero_pedido }}" name="numero_pedido" disabled>
                    </div>
                    <div class="col-md-3">
                        <label for="comprador">Comprador</label>
                        <input type="text" class="form-control" value="{{ $pedido->comprador }}" name="comprador" disabled>
                    </div>
                    <div class="col-md-3">
                        <label for="solicitante">Solicitante</label>
                        <input type="text" class="form-control" value="{{ $pedido->solicitante }}" name="solicitante" disabled>
                    </div>
                </div>

                <div row class="row">
                    <div class="col-md-6">
                        <label for="documento">Anexar Documento</label>
                        <input type="file" class="form-control" name="documento" id="documento" required>
                    </div>
                </div>
    
                <br>
                <button type="submit" class="btn btn-success mx-1">SALVAR</button>
            </form>
        </div>
    </div>
    
    <div>
        <a href="{{ route('cotacaoalmox') }}">⬅️ Voltar</a>
    </div>    
</main>

</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Alternar sidebar
        document.getElementById('toggleSidebar')?.addEventListener('click', function () {
            document.getElementById('sidebar')?.classList.toggle('hidden');
        });
    });
</script>

</html>
