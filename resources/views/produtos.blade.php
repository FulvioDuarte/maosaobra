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

    <div class="d-flex justify-content-between align-items-center my-2 mx-1">
        <a href="{{ route('menu.index') }}" class="btn btn-primary">☰ Menu</a>
        <a href="{{ route('menu.index') }}">⬅️ Voltar</a>
    </div>

    <h4 class="section-title d-flex justify-content-center" style=" color: black; font-size: 22px; background-color: #d4e6f9"><strong>Cadastrar Produto</strong></h4>

    <div class="d-flex justify-content-between align-items-center my-2 mx-1">
        <a href="{{ route('limpar') }}" class="btn btn-warning">Limpar Campos</a>
    </div>

    @if ($msg <> "")
        <div id="mensagem" style=" background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0;transition: opacity 1s ease;">
            {{ $msg }}
        </div>
    @endif

        <form action="{{ route('pesquisaSAP') }}" method="POST">
            @csrf
            <div class="row mb-1 mx-1">
                <div class="col-6">
                    <label for="codigoproduto" style="min-width: 120px; color: black; font-size: 16px;">Cod. Produto</label>
                    @if (isset($codproduto))
                        <input type="number" id="codigoproduto" name="codigoproduto" id="codigoproduto" class="form-control" style="color: black;" value="{{ $codproduto }}" readonly>
                    @else
                        <input type="number" id="codigoproduto" name="codigoproduto" id="codigoproduto" class="form-control" style="color: black;" required>
                    @endif
                </div>

                <div class="col-6 mt-2">
                    <input type="submit" class="btn btn-info mx-1" value="Pesquisar">
                </div>
            </div>

            @if (isset($codproduto))
                <input type="hidden" name="codigoproduto" value="{{ $codproduto}}">
            @endif

            <div class="row mb-1 mx-1">
                <div class="col-12">
                    <label for="descricao" style="min-width: 120px; color: black; font-size: 16px;">Descrição Produto</label>
                    <input type="text" id="descricao" name="descricao" class="form-control" style="color: black; font-size: 16px;" value="{{ $descproduto ?? '' }}">
                </div>
            </div>

            <div class="row mb-1 mx-1 mt-1">
                <div class="col-12">
                    <label for="rua" style="min-width: 120px; color: black; font-size: 16px;">Rua</label>
                    <input type="text" id="rua" name="rua" class="form-control" style="color: black; font-size: 16px;">
                </div>
            </div>

            <div class="d-flex justify-content-center my-1">
                <input type="submit" class="btn btn-success mx-1" name="salvar" value="Salvar">
            </div>

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
                document.getElementById('codigoproduto')?.focus();
            });

            setTimeout(() => {
                const el = document.getElementById('mensagem');
                if (el) {
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 1000);
                }
            }, 2000);
        </script>


</body>
<!-- END: Body-->

</html>