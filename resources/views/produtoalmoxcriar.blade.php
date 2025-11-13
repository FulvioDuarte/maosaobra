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
        <span class="h5 mb-0">Gestão de Compras Consumo - PRODUTOS</span>
    </div>

    @if (session('msg'))
        <div id="mensagem" style=" background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0;transition: opacity 1s ease;">
            {{ session('msg') }}
        </div>
    @endif

    <!-- Adiciona container-fluid aqui -->
    <div class="container-fluid">
        <div class="p-2 mb-1" style="background: #fff; border: 1px solid #dee2e6; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">    
            <form action="gravaprodutoalmox" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-5">
                        <label for="nomeproduto">Descrição</label>
                        <input type="text" class="form-control" name="nomeproduto" required>
                    </div>
                    <div class="col-md-2">
                        <label for="sap">SAP</label>
                        <input type="text" class="form-control" name="sap" required>
                    </div>
                    <div class="col-md-3">
                        <label for="unidade">Unidade</label>
                        <select class="form-control"  name="unidade" required>
                            <option value=""></option>
                            <option value="AMARRADO - AM">AMARRADO - AM </option>
                            <option value="BALDE - BD">BALDE - BD </option>
                            <option value="CAIXA - CX">CAIXA - CX</option>
                            <option value="CARTELA - CT">CARTELA - CT</option>
                            <option value="FARDO - FD">FARDO - FD</option>
                            <option value="GALÃO - GL">GALÃO - GL</option>
                            <option value="LATA - LA">LATA - LA</option>
                            <option value="LITRO - LT">LITRO - LT</option>
                            <option value="MAÇO - MC">MAÇO - MC</option>
                            <option value="PACOTE - PT">PACOTE - PT</option>
                            <option value="PAR - PR">PAR - PR</option>
                            <option value="POTE - PO">POTE - PO</option>
                            <option value="QUILOGRAMA - KG">QUILOGRAMA - KG</option>
                            <option value="ROLO - RL">ROLO - RL</option>
                            <option value="SACO - SC">SACO - SC</option>
                            <option value="UNIDADE - UN">UNIDADE - UN</option>
                        </select>
                    </div>
                </div>

                <br>
                <button type="submit" class="btn btn-success mx-1">GRAVAR</button>
            </form>
        </div>

        <br>
        <div>
            <a href="{{ route('produtoalmox') }}">⬅️ Voltar</a>
        </div>
    </div>
</main>

    </div>

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
