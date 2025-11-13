<!DOCTYPE html>
<html class="loading" lang="pt-br" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta charset="UTF-8">
    <title>Amox - Tambasa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS e Ícones -->
    <link rel="stylesheet" href="{{ asset('vendors/css/bootstrap/min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/bootstrap/bootstrap-icons.css') }}">

    <!-- Estilos adicionais (opcional) -->
    <style>
        body {
            background-color:rgb(212, 230, 249);
        }
        .card i {
            color: #0d6efd;
        }
        .card:hover {
            transform: scale(1.02);
            transition: 0.2s;
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="blank-page">

    <!-- BEGIN: Main Menu (Cards) -->
    <div class="container-fluid min-vh-100 d-flex flex-column justify-content-center align-items-center mt-1">
        <h6 class="mb-1 text-center" style="font-size: 14px;">Bem-vindo</h6>
        <h6 class="mb-2 text-center">{{ Auth::user()->name }}</h6>

        <div class="row w-100 px-3 g-3 justify-content-center">
            
            @if (Auth::user()->acesso_almox == 1)
                <!-- Card -->
                <div class="col-6 col-md-4">
                    <a href="{{ route('menu.index') }}" class="text-decoration-none">
                        <div class="card text-center shadow-lg h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center py-2">
                                <div style="font-size: 3rem;">🏗️</div>
                                <h6 class="mt-3">Separação</h6>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            @if (Auth::user()->acesso_compras == 1)
                 <!-- Card -->
                <div class="col-6 col-md-4">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none">
                        <div class="card text-center shadow-lg h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center py-2">
                                <div style="font-size: 3rem;">🛒</div>
                                <h6 class="mt-3">Gestão de Compras</h6>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            <!-- Card -->
            <div class="col-6 col-md-4">
                <a href="{{ route('welcome') }}" class="text-decoration-none">
                    <div class="card text-center shadow-lg h-100">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center py-2">
                            <div style="font-size: 3rem;">🔓</div>
                            <h6 class="mt-3">Sair</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- END: Main Menu -->
</body>
<!-- END: Body-->
</html>
