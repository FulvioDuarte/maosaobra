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
        <span class="h5 mb-0">Gestão de Compras Consumo - FORNECEDORES</span>
    </div>

    <!-- Adiciona container-fluid aqui -->
    <div class="container-fluid">
        <div class="p-2 mb-1" style="background: #fff; border: 1px solid #dee2e6; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <form action="gravafornecedor" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <label for="nome">Nome Fornecedor</label>
                            <input type="text" class="form-control" name="nomefornecedor" required>
                        </div>
                        <div class="col-md-2">
                            <label for="telefone1">Telefone</label>
                            <input type="text" class="form-control" name="telefonefornecedor1" required>
                        </div>
                        <div class="col-md-2">
                            <label for="telefone2">Telefone 2</label>
                            <input type="text" class="form-control" name="telefonefornecedor2">
                        </div>
                        <div class="col-md-3">
                            <label for="contato">Contato</label>
                            <input type="text" class="form-control" name="contatofornecedor">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" name="emailfornecedor">
                        </div>
                        <div class="col-md-3">
                            <label for="email2">E-mail 2</label>
                            <input type="email2" class="form-control" name="email2fornecedor">
                        </div>
                        <div class="col-md-3">
                            <label for="cidade">Cidade</label>
                            <input type="txt" class="form-control" name="cidadefornecedor">
                        </div>
    
                        <div class="col-md-1">
                            <label for="uf">UF</label>
                            <select class="form-control" name="uf" id="uf">
                                <option value=""></option>
                                <option value="AC">AC</option>
                                <option value="AL">AL</option>
                                <option value="AP">AP</option>
                                <option value="AM">AM</option>
                                <option value="BA">BA</option>
                                <option value="CE">CE</option>
                                <option value="DF">DF</option>
                                <option value="ES">ES</option>
                                <option value="GO">GO</option>
                                <option value="MA">MA</option>
                                <option value="MT">MT</option>
                                <option value="MS">MS</option>
                                <option value="MG">MG</option>
                                <option value="PA">PA</option>
                                <option value="PB">PB</option>
                                <option value="PR">PR</option>
                                <option value="PE">PE</option>
                                <option value="PI">PI</option>
                                <option value="RJ">RJ</option>
                                <option value="RN">RN</option>
                                <option value="RS">RS</option>
                                <option value="RO">RO</option>
                                <option value="RR">RR</option>
                                <option value="SC">SC</option>
                                <option value="SP">SP</option>
                                <option value="SE">SE</option>
                                <option value="TO">TO</option>
                            </select>
                        </div>
    
                        <div class="col-md-7">
                            <label for="ramofornecedor">Ramo</label>
                            <select class="form-control" name="ramofornecedor">
                                @foreach ($ramos as $ramo)
                                    <option value="{{ $ramo->id }}">{{ $ramo->descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-success mx-1">GRAVAR</button>
                </form>
        </div>
        <br>
        <div>
            <a href="{{ route('fornecedor') }}">⬅️ Voltar</a>
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
