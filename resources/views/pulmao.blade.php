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
        background-color: rgb(156, 200, 206);
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

    <form action="pulmao" method="POST">
        @csrf
        <div class="input-group">
            <input inputmode="numeric" class="form-control mr-1 mx-1" name="desc" id="desc" style="color: black;" placeholder="Código Produto" autocomplete="off" required>
            <button type="submit" class="btn btn-info mx-1">🔍</button>
        </div>
    </form>

    <!-- Mensagem -->
    @if (session('msg'))
        <div id="mensagem" style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0; transition: opacity 1s ease;">
            {{ session('msg') }}
        </div>
    @endif

    @forelse ($produtos as $produto)
        <div style="border-radius: 10px; padding: 10px 15px; font-size: 14px; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

            <div class="card card-pedido ok"
                style="width: 100%; border-radius: 10px; padding: 10px 15px; font-size: 14px; font-weight: bold; 
                box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; flex-direction: column; justify-content: space-between;">

                <div style="display: flex; justify-content: space-between;">
                    <span style="color: black; font-size: 18px;"><strong>Código {{ $produto->codigosap }}</strong></span>
                </div>

                <div style="display: flex; justify-content: space-between;">
                    <span style="color: black">{{ $produto->descricao }}</span>
                </div>

                <span style="color: black; font-size: 16px;"><strong>➤ {{ $produto->codigorua }}</strong></span>
            </div>

            <div class="form-container">

                <form method="POST" action="{{ route('imprimirpulmao') }}" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="produto_id" value="{{ $produto->id }}">

                    <div class="form-group">
                        <label for="unidades" style="color: black; font-size: 16px;">Unid.</label>
                        <input type="number" id="unidades" name="unidades" min="1">
                    
                        <label for="qtde_impressao" style="color: black; font-size: 16px;">Qtd.</label>
                        <input type="number" id="qtde_impressao" name="qtde_impressao" min="1">
    
                        <button type="submit" class="btn btn-info d-flex align-items-center justify-content-center rounded ml-2" style="width: 45px; height: 45px; font-size: 22px;">
                            🖨️
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @empty
        <div class="d-flex justify-content-between align-items-center my-2 mx-1">
            {{ $msg }}
        </div>
    @endforelse

</body>
<script src="{{ asset('vendors/js/jquery-3.6.0.min.js') }}"></script>

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('desc');
        const form = document.getElementById('form-barras');

        let entrada = '';
        let startTime = null;
        let timer = null;

        input.focus();

        input.addEventListener('input', () => {
            if (!startTime) {
                startTime = Date.now(); 
                entrada = '';
            }

            entrada = input.value;

            clearTimeout(timer);
            timer = setTimeout(() => {
                const endTime = Date.now();
                const tempoTotal = endTime - startTime;
                const digitos = entrada.length;
                const mediaTempoPorCaractere = tempoTotal / digitos;

                if (digitos >= 9 && mediaTempoPorCaractere < 120) {
                    form.submit();
                }

                // Reset
                startTime = null;
                entrada = '';
            }, 400); // pausa após última tecla
        });

        // input.addEventListener('blur', () => {
        //     setTimeout(() => input.focus(), 100);
        // });
    });

    setTimeout(() => {
        const el = document.getElementById('mensagem');
        if (el) {
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 1000);
        }
    }, 3000);
</script>
</html>
