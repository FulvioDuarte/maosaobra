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
            <form action="salvafornecedor" method="POST">
                @csrf
                <input type="hidden" name="fornecedor_id" value="{{ $fornecedor->id }}">

                <div class="row">
                    <div class="col-md-3">
                        <label for="nome">Nome Fornecedor</label>
                        <input type="text" class="form-control" name="nomefornecedor" value="{{ $fornecedor->nome }}" required>
                    </div>
                    <div class="col-md-2">
                        <label for="telefone1">Telefone</label>
                        <input type="text" class="form-control" name="telefonefornecedor1" value="{{ $fornecedor->telefone1 }}" required>
                    </div>
                    <div class="col-md-2">
                        <label for="telefone2">Telefone 2</label>
                        <input type="text" class="form-control" name="telefonefornecedor2" value="{{ $fornecedor->telefone2 }}">
                    </div>
                    <div class="col-md-3">
                        <label for="contato">Contato</label>
                        <input type="text" class="form-control" name="contatofornecedor" value="{{ $fornecedor->contato }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" name="emailfornecedor" value="{{ $fornecedor->email }}">
                    </div>
                    <div class="col-md-3">
                        <label for="email2">E-mail 2</label>
                        <input type="email2" class="form-control" name="email2fornecedor" value="{{ $fornecedor->email2 }}">
                    </div>
                    <div class="col-md-3">
                        <label for="cidade">Cidade</label>
                        <input type="txt" class="form-control" name="cidadefornecedor" value="{{ $fornecedor->cidade }}">
                    </div>
    
                    <div class="col-md-1">
                        <label for="uf">UF</label>
                        <select class="form-control" name="uf" id="uf">
                            <option value=""></option>
                            <option value="AC" {{ (old('uf', $fornecedor->uf ?? '') == 'AC') ? 'selected' : '' }}>AC</option>
                            <option value="AL" {{ (old('uf', $fornecedor->uf ?? '') == 'AL') ? 'selected' : '' }}>AL</option>
                            <option value="AP" {{ (old('uf', $fornecedor->uf ?? '') == 'AP') ? 'selected' : '' }}>AP</option>
                            <option value="AM" {{ (old('uf', $fornecedor->uf ?? '') == 'AM') ? 'selected' : '' }}>AM</option>
                            <option value="BA" {{ (old('uf', $fornecedor->uf ?? '') == 'BA') ? 'selected' : '' }}>BA</option>
                            <option value="CE" {{ (old('uf', $fornecedor->uf ?? '') == 'CE') ? 'selected' : '' }}>CE</option>
                            <option value="DF" {{ (old('uf', $fornecedor->uf ?? '') == 'DF') ? 'selected' : '' }}>DF</option>
                            <option value="ES" {{ (old('uf', $fornecedor->uf ?? '') == 'ES') ? 'selected' : '' }}>ES</option>
                            <option value="GO" {{ (old('uf', $fornecedor->uf ?? '') == 'GO') ? 'selected' : '' }}>GO</option>
                            <option value="MA" {{ (old('uf', $fornecedor->uf ?? '') == 'MA') ? 'selected' : '' }}>MA</option>
                            <option value="MT" {{ (old('uf', $fornecedor->uf ?? '') == 'MT') ? 'selected' : '' }}>MT</option>
                            <option value="MS" {{ (old('uf', $fornecedor->uf ?? '') == 'MS') ? 'selected' : '' }}>MS</option>
                            <option value="MG" {{ (old('uf', $fornecedor->uf ?? '') == 'MG') ? 'selected' : '' }}>MG</option>
                            <option value="PA" {{ (old('uf', $fornecedor->uf ?? '') == 'PA') ? 'selected' : '' }}>PA</option>
                            <option value="PB" {{ (old('uf', $fornecedor->uf ?? '') == 'PB') ? 'selected' : '' }}>PB</option>
                            <option value="PR" {{ (old('uf', $fornecedor->uf ?? '') == 'PR') ? 'selected' : '' }}>PR</option>
                            <option value="PE" {{ (old('uf', $fornecedor->uf ?? '') == 'PE') ? 'selected' : '' }}>PE</option>
                            <option value="PI" {{ (old('uf', $fornecedor->uf ?? '') == 'PI') ? 'selected' : '' }}>PI</option>
                            <option value="RJ" {{ (old('uf', $fornecedor->uf ?? '') == 'RJ') ? 'selected' : '' }}>RJ</option>
                            <option value="RN" {{ (old('uf', $fornecedor->uf ?? '') == 'RN') ? 'selected' : '' }}>RN</option>
                            <option value="RS" {{ (old('uf', $fornecedor->uf ?? '') == 'RS') ? 'selected' : '' }}>RS</option>
                            <option value="RO" {{ (old('uf', $fornecedor->uf ?? '') == 'RO') ? 'selected' : '' }}>RO</option>
                            <option value="RR" {{ (old('uf', $fornecedor->uf ?? '') == 'RR') ? 'selected' : '' }}>RR</option>
                            <option value="SC" {{ (old('uf', $fornecedor->uf ?? '') == 'SC') ? 'selected' : '' }}>SC</option>
                            <option value="SP" {{ (old('uf', $fornecedor->uf ?? '') == 'SP') ? 'selected' : '' }}>SP</option>
                            <option value="SE" {{ (old('uf', $fornecedor->uf ?? '') == 'SE') ? 'selected' : '' }}>SE</option>
                            <option value="TO" {{ (old('uf', $fornecedor->uf ?? '') == 'TO') ? 'selected' : '' }}>TO</option>
                        </select>
                    </div>

                    <div class="col-md-7">
                        <label for="ramofornecedor">Ramo</label>
                        <select class="form-control" name="ramofornecedor">
                            @foreach ($ramos as $ramo)
                                <option value="{{ $ramo->id }}" {{ (old('ramofornecedor', $fornecedor->ramo_id ?? '') == $ramo->id) ? 'selected' : '' }}>
                                    {{ $ramo->descricao }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <br>
                <button type="submit" class="btn btn-success mx-1">SALVAR</button>
            </form>
        </div>
        <br>
        <div>
            <a href="{{ route('fornecedor') }}">⬅️ Voltar</a>
        </div>
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
