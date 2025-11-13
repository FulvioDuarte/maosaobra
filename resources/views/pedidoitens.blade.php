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
    background-color:rgb(85, 225, 118);
    border-left: 5px solid rgb(54, 40, 253);
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    transition: transform 0.2s;
    }

    .card-pedido.pendente {
    background-color:rgb(250, 216, 112);
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
    font-size: 1rem;
    font-weight: bold;
    color:rgb(0, 0, 0);
    }

    .card-pedido .info-item {
    font-size: 0.95rem;
    color: #6c757d;
    }

    .card-pedido .pedido-numero {
    margin-bottom: -14px; 
    }

    .card-pedido .pedido-conferido {
    margin-bottom: -14px; 
    font-size: 16px;
    }

    .card-pedido .pedido-descricao {
        font-size: 14px;
        font-weight: bold;
        color:rgb(0, 0, 0);
    }
</style>

<body> 
    
    <div class="d-flex justify-content-between align-items-center my-2 mx-1">
        <a href="{{ route('menu.index') }}" class="btn btn-primary">☰ Menu</a>
        <a href="{{ route('pedidoopcoes.index', ['id' => $itens[0]->pedido_id]) }}">⬅️ Voltar</a>
            
    </div>

    <form action="{{ route('pesquisaitem') }}" method="POST" id="form-barras">
    @csrf
        <input type="hidden" name="pedido_id" value="{{ $itens[0]->pedido_id }}">

        <div class="input-group">
            <input type="number" class="form-control mr-1 mx-1" name="codigo" id="codigo" style="color: black;" placeholder="Código Produto" autocomplete="off">
            <button type="submit" class="btn btn-info mx-1">🔍</button>
        </div>
    </form>
        
    <div style="display: flex; justify-content: space-between; padding: 0 20px;">
        <h4 class="section-title d-flex justify-content-center mt-1" style="color: black; font-size: 16px;">
            <strong>Reserva #{{ $itens[0]->numero }}</strong>
        </h4>
        <h4 class="section-title d-flex justify-content-center mt-1" style="color: black; font-size: 16px;">
            <strong>{{ $itens[0]->conferidototal }} / {{ $itens[0]->qtdetotal }}</strong>
        </h4>
    </div>

    @forelse ($itens as $item)  
        @if ($item->conferido == 1)
            <div class="card card-pedido iniciado my-1 mx-1"> 
        @elseif ($item->conferido == 2)
            <div class="card card-pedido ok my-1 mx-1"> 
        @else
            <div class="card card-pedido pendente my-1 mx-1"> 
        @endif

                <div style="border-radius: 10px; padding: 10px 15px; font-size: 14px; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: black; font-size: 18px;"><strong>Código {{ $item->codigosap }}</strong></span>
                        
                        @if ($item->conferido == 2)
                            <span style="color: black; font-size: 14px;"><strong>☑️</strong></span>
                        @elseif ($item->conferido == 1)
                            <span style="color: black; font-size: 14px;"><strong>PARCIAL</strong></span>
                        @else
                            <span style="color: black; font-size: 14px;"><strong>NOVO</strong></span>          
                        @endif
                    </div>

                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: black; font-size: 14px;">
                            <strong>Itens: 
                                <span style="color: black; font-size: 18px;">{{ $item->qtde }}
                            </strong>
                        </span>
                        <span style="color: black; font-size: 14px;">
                            <strong>Conferidos: 
                                <span style="color: black; font-size: 18px;">{{ $item->qtdeconferida }}
                            </strong>
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: black">{{ $item->descricao }}</span>
                    </div>
                        
                    <span style="color: black; font-size: 14px;"><strong>Rua: {{ $item->codigorua }}</strong></span>
                    
                </div>
            </div>
            @empty
                <div id="mensagem" style=" background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0;transition: opacity 1s ease;">
                    Nenhum produto encontrado
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
        const input = document.getElementById('codigo');
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

                if (digitos >= 7 && mediaTempoPorCaractere < 120) {
                    form.submit();
                }

                // Reset
                startTime = null;
                entrada = '';
            }, 400); // pausa após última tecla
        });

        input.addEventListener('blur', () => {
            setTimeout(() => input.focus(), 100);
        });

        setTimeout(() => {
            const el = document.getElementById('mensagem');
            if (el) {
                el.style.opacity = '0'; 
                setTimeout(() => el.remove(), 1000); 
            }
        }, 4000); 

    });
</script>

</html>