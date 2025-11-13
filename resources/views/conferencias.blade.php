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

</head>
<!-- END: Head-->
<style>
    .card-pedido.ok {
        background-color: rgba(189, 202, 205, 1);
        border-left: 5px solid rgb(0, 99, 247);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s;
    }

    .card-pedido:hover {
        transform: scale(1.02);
    }

    .card-pedido .pedido-numero {
        font-size: 1rem;
        font-weight: bold;
        color: rgb(0, 0, 0);
    }

    .card-pedido .pedido-numero {
        margin-bottom: -14px;
    }

    .input-group {
        margin-bottom: 15px;
    }

    .form-control {
        padding: 10px;
        font-size: 14px;
    }

    .btn-info {
        font-size: 16px;
    }

    .form-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 10px;
    }

    .form-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-group input {
        padding: 5px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 100%;
    }

    .form-group label {
        font-size: 14px;
        color: black;
    }

    .emoji {
        font-size: 22px;
    }
</style>

<body>
    <div class="d-flex justify-content-between align-items-center my-2 mx-1">
        <a href="{{ route('menu.index') }}" class="btn btn-primary">☰ Menu</a>
        <a href="{{ route('menu.index') }}">⬅️ Voltar</a>
    </div>

    <div class="d-flex justify-content-between align-items-center mx-1">
        <form action="criaconferencia" method="POST"  class="d-flex align-items-center">
            @csrf
            <input type="text" class="form-control" name="nome" style="color: black;" placeholder="Nome da conferência" required>
            <button type="submit" class="btn btn-success mx-1">CRIAR</button>
        </form>
    </div>
    <br>

    <!-- Mensagem -->
    @if (session('msg'))
        <div id="mensagem" style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0; transition: opacity 1s ease;">
            {{ session('msg') }}
        </div>
    @endif

    @forelse ($conferencias as $conferencia)
    <a href="conferidos/{{ $conferencia->id }}">
        <div style="border-radius: 10px; padding: 0px 15px; font-size: 14px; font-weight: bold">

            <div class="card card-pedido ok"
                style="width: 100%; border-radius: 10px; padding: 10px 15px; font-size: 14px; font-weight: bold; 
                box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; flex-direction: column; justify-content: space-between;">

                <div style="display: flex; justify-content: space-between;">
                    <span style="color: black; font-size: 18px;"><strong>{{ $conferencia->descricao }}</strong></span>
                </div>

                <div style="display: flex; justify-content: space-between;">
                    <span style="color: black; font-size: 19px;">Produtos: {{ $conferencia->total_produtos }}</span>
                    <span style="color: black; font-size: 14px;">
                            <strong>Data: 
                                <span>{{ date_format($conferencia->created_at, 'd-m-Y') }}
                            </strong>
                        </span>
                </div>

            </div>
        </div>
    </a>
    @empty
        <div class="d-flex justify-content-between align-items-center my-2 mx-1">
            {{ $msg }}
        </div>
    @endforelse

</body>
<script src="{{ asset('vendors/js/jquery-3.6.0.min.js') }}"></script>

<script>
    setTimeout(() => {
        const el = document.getElementById('mensagem');
        if (el) {
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 1000);
        }
    }, 3000);
</script>
</html>
