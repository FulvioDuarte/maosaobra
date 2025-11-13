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

    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
        
</head>
<!-- END: Head-->
 <style>
    
    .card-pedido.ok {
    background-color:rgb(85, 225, 118);
    border-left: 5px solid rgb(54, 40, 253);
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    transition: transform 0.2s;
    }

    .card-pedido.okparcial {
    background-color:rgba(227, 224, 55, 1);
    border-left: 5px solid rgb(54, 40, 253);
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    transition: transform 0.2s;
    }

    .card-pedido.pendente {
    background-color:rgba(218, 210, 191, 1);
    border-left: 5px solid rgb(244, 119, 119);
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    transition: transform 0.2s;
    }

    .card-pedido.iniciado {
    background-color:rgb(253, 137, 149);
    border-left: 5px solid rgb(255, 130, 52);
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    transition: transform 0.2s;
    }

    .card-pedido:hover {
    transform: scale(1.02);
    }

    .card-pedido .pedido-numero {
    font-size: 1.5rem;
    font-weight: bold;
    color: black;
    }

    .card-pedido .info-item {
    font-size: 0.95rem;
    color:rgb(39, 41, 77);
    }
</style>

<!-- BEGIN: Body-->

<body>

    <div class="d-flex justify-content-between align-items-center my-2 mx-1">
        <a href="{{ route('menu.index') }}" class="btn btn-primary">☰ Menu</a>
        <a href="{{ route('menu.index') }}">⬅️ Voltar</a>
    </div>
  
    <form action="pesquisarpedido" method="POST">
    @csrf
         <div class="input-group">
            <input type="number" class="form-control mr-1 mx-1" name="numeropedido" id="numeropedido" style="color: black;" placeholder="Número da Reserva" 
                onkeydown="if(event.key === 'Enter'){ this.form.submit(); }">

            <button type="submit" class="btn btn-info mx-1">🔍</button>
        </div>
    </form>

    @if (!empty($mensagem))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'info',
                    title: 'Aviso',
                    text: @json($mensagem),
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    @forelse ($pedidos as $pedido)
        <a href="{{ route('pedidoopcoes.index', ['id' => $pedido->id]) }}">  

            @if ($pedido->finalizado_parcial == 1)
                <div class="card card-pedido okparcial my-1 mx-1"> 
            @elseif ($pedido->finalizado == 1)
                <div class="card card-pedido iniciado my-1 mx-1"> 
            @elseif ($pedido->finalizado == 2)
                <div class="card card-pedido ok my-1 mx-1"> 
            @else
                <div class="card card-pedido pendente my-1 mx-1"> 
            @endif

            <div style="border-radius: 10px; padding: 10px 15px; font-size: 14px; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: black; font-size: 18px;"><strong>Reserva #{{ $pedido->numero }}</strong></span>
                    <span style="color: black; font-size: 14px;"><strong>{{ date_format($pedido->created_at, 'd/m/y') }}</strong></span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                        <span style="color: black; font-size: 14px;">
                        <strong>Itens: 
                            <span style="color: black; font-size: 18px;">{{ $pedido->qtde }}
                        </strong>
                    </span>
                    <span style="color: black; font-size: 14px;">
                        <strong>Confer.: 
                            <span style="color: black; font-size: 18px;">{{ $pedido->conferido }}
                        </strong>
                    </span>

                    @if ($pedido->finalizado == 2)
                        @if ($pedido->qtde == $pedido->conferido)
                            <span style="color: black; font-size: 14px;"><strong>☑️ {{ date_format($pedido->datafinalizado, 'd/m/y') }}</strong></span>
                        @else
                            <span style="color: black; font-size: 14px;"><strong>🛑 {{ date_format($pedido->datafinalizado, 'd/m/y') }}</strong></span>
                        @endif
                        @elseif ($pedido->finalizado == 1)
                            <span style="color: black; font-size: 14px;"><strong>INICIADO</strong></span>
                        @else
                            <span style="color: black; font-size: 14px;"><strong>NOVO</strong></span>
                        @endif

                    </div>
                </div>
            </div>
            @empty
                <div id="mensagem" style=" background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0;transition: opacity 1s ease;">
                    Nenhum pedido encontrado
                </div>
            </div>
        </a>
    @endforelse

</body>
<!-- END: Body-->
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

        window.addEventListener('DOMContentLoaded', () => {
            document.getElementById('numeropedido')?.focus();
        });

        setTimeout(() => {
            const el = document.getElementById('mensagem');
            if (el) {
                el.style.opacity = '0'; 
                setTimeout(() => el.remove(), 1000); 
            }
        }, 4000); 
    </script>

</html>