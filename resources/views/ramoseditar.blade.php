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
                <span class="h5 mb-0">Gestão de Compras Consumo - RAMOS</span>
            </div>

            <!-- Formulário de filtros -->
            <form action="salvaramo" method="POST">
                @csrf
                <div class="col-md-6">
                    <input type="hidden" name="ramo_id" value="{{ $ramo->id }}">
                    <label for="nomeramo">Ramo</label>
                    <input type="text" class="form-control" name="nomeramo" value="{{ $ramo->descricao }}" required>
                    <br>
                    <button type="submit" class="btn btn-info mx-1">SALVAR</button>
                </div>

                <br>
                <div>
                    <a href="{{ route('ramos') }}">⬅️ Voltar</a>
                </div>
            </form>
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
