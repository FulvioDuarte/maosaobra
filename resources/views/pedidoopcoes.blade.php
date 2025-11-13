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

<body>
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center my-2 mx-1">
            <a href="{{ route('menu.index') }}" class="btn btn-primary">☰ Menu</a>
            <a href="{{ route('pedidos.index') }}">⬅️ Voltar</a>
        </div>

        <h4 class="section-title d-flex justify-content-center" style=" color: black; font-size: 20px; background-color: #d4e6f9"><strong>Reserva #{{ $pedido->numero }} </strong></h4>
        <div class="d-flex justify-content-center align-items-center my-1">
            <span class="badge badge-secondary" style="font-size: 26px;">{{ $pedido->conferido }}
                <span style="font-size: 16px;">conferidos</span>
            </span>
            <span class="text-muted">|</span>
            <span class="badge badge-secondary" style="font-size: 26px;">{{ $pedido->qtde }}
                <span style="font-size: 16px;">itens</span>
            </span>
        </div>

        @if ($pedido->finalizado == 0)
            <form action="{{ route('pedidoqtde.qtde', ['id' => $pedido->id]) }}" method="POST">
                <div class="d-flex justify-content-center my-1">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $pedido->id }}">
                    <input type="hidden" name="flag" value="next">
                    <input type="hidden" name="posicao" value="">
                    
                    <button type="submit" class="btn btn-success flex-fill" style="max-width: 250px; height: 60px; font-size: 1.25rem; display: flex; align-items: center; justify-content: center;">
                    Iniciar Separação
                    </button>
                </div>
            </form>
        @endif
       
        @if ($pedido->finalizado == 1)
            <form action="{{ route('pedidoqtde.qtde', ['id' => $pedido->id]) }}" method="POST">
                <div class="d-flex justify-content-center my-1">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $pedido->id }}">
                    <input type="hidden" name="flag" value="next">
                    <input type="hidden" name="posicao" value="">

                    <button type="submit" class="btn btn-success flex-fill" style="max-width: 250px; height: 60px; font-size: 1.25rem; display: flex; align-items: center; justify-content: center;">
                        Continuar
                    </button>
                </div>
            </form>
        @endif
   
        <div class="d-flex justify-content-center my-1">
            <a href="{{ route('pedidoitens.itens', ['id' => $pedido->id]) }}"
                class="btn btn-info flex-fill"
                style="max-width: 250px; height: 60px; font-size: 1.25rem; display: flex; align-items: center; justify-content: center;">
                Visualizar Itens
            </a>
        </div>

        @if ($pedido->finalizado <> 0)
            <div class="d-flex justify-content-center my-1">
                <a href="{{ route('reiniciar', ['id' => $pedido->id]) }}"
                    class="btn btn-danger flex-fill"
                    style="max-width: 250px; height: 60px; font-size: 1.25rem; display: flex; align-items: center; justify-content: center;">
                    Reiniciar
                </a>
            </div>
        @endif

        @if ($pedido->finalizado <> 2 && $pedido->finalizado <> 0)
            <div class="d-flex justify-content-center my-1 mt-1">
                <a href="{{ route('finalizar', ['id' => $pedido->id]) }}"
                    class="btn btn-warning flex-fill"
                    style="max-width: 250px; height: 60px; font-size: 1.25rem; display: flex; align-items: center; justify-content: center;">
                    Finalizar
                </a>
            </div>
        @endif
    </div>

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });
    </script>

</body>
<!-- END: Body-->

</html>