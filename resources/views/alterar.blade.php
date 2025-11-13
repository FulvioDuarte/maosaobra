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

<body style="background-color: #e6f0ff;">

    <div class="d-flex justify-content-between align-items-center my-1 mx-1">
        <a href="{{ route('menu.index') }}" class="btn btn-primary">☰ Menu</a>
        <a href="{{ route('pesquisa') }}">⬅️ Voltar</a>
    </div>

    <h4 class="section-title d-flex justify-content-center" style=" color: black; font-size: 18px; background-color: #d4e6f9"><strong>Alterar Produto</strong></h4>
        
    @if ($msg <> "")
        <div id="mensagem" style=" background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0;transition: opacity 1s ease;">
            {{ $msg }}
        </div>
    @endif

    <form action="{{ route('atualizar') }}" method="POST">
    @csrf
        <input type="hidden" id="id" name="id" value="{{ $produto->id }}">

        <div class="row mb-1 mx-1 mt-1">
            <div class="col-12">
                <label for="rua" style="min-width: 120px; color: black; font-size: 16px;">Descrição Produto</label>
                <input type="text" id="descricao" name="descricao" value="{{ $produto->descricao }}" class="form-control" style="color: black; font-size: 18px;" required>
            </div>
        </div>

        <div class="row mb-1 mx-1 mt-1">
            <div class="col-12">
                <label for="rua" style="min-width: 120px; color: black; font-size: 16px;">Rua</label>
                <input type="text" id="rua" name="rua" value="{{ $produto->codigorua }}" class="form-control" style="color: black; font-size: 18px;" required>
            </div>
        </div>

        <div class="row mb-1 mx-1">
            <div class="col-12">
                <label for="codigoproduto" style="min-width: 120px; color: black; font-size: 16px;">Código Produto</label>
                <input type="text" id="codigoproduto" value="{{ $produto->codigosap }}" name="codigoproduto" class="form-control" style="color: black;" readonly>
            </div>
        </div>

        @if (Auth::user()->admin == 1)
            <div class="d-flex justify-content-center my-1">
                <button type="submit" name="atualizar" value="1" class="btn btn-info mx-1">Atualizar</button>
                <button type="submit" name="excluir" value="1" class="btn btn-danger mx-1">Excluir</button>
            </div>
        @endif

    </form>

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
            document.getElementById('desc')?.focus();
        });

        window.addEventListener('DOMContentLoaded', () => {
            document.getElementById('rua')?.focus();
        });

        setTimeout(() => {
            const el = document.getElementById('mensagem');
            if (el) {
                el.style.opacity = '0'; 
                setTimeout(() => el.remove(), 1000); 
            }
        }, 4000); 
    </script>

</body>
<!-- END: Body-->

</html>