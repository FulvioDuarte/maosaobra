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
            <a href="{{ route('pedidosenviar') }}">⬅️ Voltar</a>
        </div>

        <h4 class="section-title d-flex justify-content-center" style=" color: black; font-size: 20px; background-color: #d4e6f9"><strong>Pedido #{{ $pedido->numero }} </strong></h4>
        <div class="d-flex justify-content-center align-items-center my-1">
            <span class="badge badge-secondary" style="font-size: 26px;">{{ $pedido->qtde }}
                <span style="font-size: 16px;">itens</span>
            </span>
        </div>

        <form action="{{ route('enviaremail') }}" method="POST" id="form-barras">
        @csrf
            <input type="hidden" name="pedido_id" value="{{ $pedido->id }}">
            
            <div class="row mb-1 mx-1 mt-1">
                <div class="col-12">      
                    <label for="email" style="min-width: 120px; color: black; font-size: 16px;">E-mail</label>
                    <input type="email" name="email" class="form-control" style="color: black; font-size: 18px;" required>
                </div>
            </div>

            <div class="d-flex justify-content-center my-1">
            <button type="submit" class="btn btn-success mx-1">Enviar para o Email</button>
            </div>
        </form>
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