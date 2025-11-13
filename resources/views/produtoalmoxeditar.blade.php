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
                <span class="h5 mb-0">Gestão de Compras Consumo - PRODUTOS </span>
            </div>

            <div class="p-2 mb-1" style="background: #fff; border: 1px solid #dee2e6; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <!-- Formulário de filtros -->
                <form action="salvaprodutoalmox" method="POST">
                    @csrf
                    <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                    
                    <div class="row">
                        <div class="col-md-5">
                            <label for="nomeproduto">Descrição</label>
                            <input type="text" class="form-control" name="nomeproduto" value="{{ $produto->descricao }}" required>
                        </div>
                        <div class="col-md-2">
                            <label for="sapproduto">SAP</label>
                            <input type="text" class="form-control" name="sapproduto" value="{{ $produto->sap }}">
                        </div>
                        <div class="col-md-3">
                            <label for="unidadeproduto">Unidade</label>
                            <select class="form-control" name="unidadeproduto">
                                <option value=""></option>
                                <option value="AMARRADO - AM" {{ $produto->unidade == 'AMARRADO - AM' ? 'selected' : '' }}>AMARRADO - AM</option>
                                <option value="BALDE - BD" {{ $produto->unidade == 'BALDE - BD' ? 'selected' : '' }}>BALDE - BD</option>
                                <option value="CAIXA - CX" {{ $produto->unidade == 'CAIXA - CX' ? 'selected' : '' }}>CAIXA - CX</option>
                                <option value="CARTELA - CT" {{ $produto->unidade == 'CARTELA - CT' ? 'selected' : '' }}>CARTELA - CT</option>
                                <option value="FARDO - FD" {{ $produto->unidade == 'FARDO - FD' ? 'selected' : '' }}>FARDO - FD</option>
                                <option value="GALÃO - GL" {{ $produto->unidade == 'GALÃO - GL' ? 'selected' : '' }}>GALÃO - GL</option>
                                <option value="LATA - LA" {{ $produto->unidade == 'LATA - LA' ? 'selected' : '' }}>LATA - LA</option>
                                <option value="LITRO - LT" {{ $produto->unidade == 'LITRO - LT' ? 'selected' : '' }}>LITRO - LT</option>
                                <option value="MAÇO - MC" {{ $produto->unidade == 'MAÇO - MC' ? 'selected' : '' }}>MAÇO - MC</option>
                                <option value="PACOTE - PT" {{ $produto->unidade == 'PACOTE - PT' ? 'selected' : '' }}>PACOTE - PT</option>
                                <option value="PAR - PR" {{ $produto->unidade == 'PAR - PR' ? 'selected' : '' }}>PAR - PR</option>
                                <option value="POTE - PO" {{ $produto->unidade == 'POTE - PO' ? 'selected' : '' }}>POTE - PO</option>
                                <option value="QUILOGRAMA - KG" {{ $produto->unidade == 'QUILOGRAMA - KG' ? 'selected' : '' }}>QUILOGRAMA - KG</option>
                                <option value="ROLO - RL" {{ $produto->unidade == 'ROLO - RL' ? 'selected' : '' }}>ROLO - RL</option>
                                <option value="SACO - SC" {{ $produto->unidade == 'SACO - SC' ? 'selected' : '' }}>SACO - SC</option>
                                <option value="UNIDADE - UN" {{ $produto->unidade == 'UNIDADE - UN' ? 'selected' : '' }}>UNIDADE - UN</option>
                            </select>
    
                            <br>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success">SALVAR</button>
                </form>
            </div>
            <br>
            <div>
                <a href="{{ route('produtoalmox') }}">⬅️ Voltar</a>
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
