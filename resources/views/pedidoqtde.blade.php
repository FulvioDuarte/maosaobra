<!DOCTYPE html>
<html class="loading" lang="pt-br" data-textdirection="ltr">

<head>
    <meta charset="UTF-8">
    <title>Almoxarifado Tambasa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-extended.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <style>
        .card-pedido {
            background-color: rgb(235, 235, 235);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .card-pedido:hover {
            transform: scale(1.02);
        }

        .card-pedido .pedido-numero {
            font-size: 16px;
            font-weight: bold;
            color: rgb(0, 0, 0);
        }
 
        .btn-navegacao {
            background-color: #3c82c7;
            color: white;             
            border: none;             
            border-radius: 8px;       
            padding: 8px 15px;       
            font-weight: 600;         
            transition: 0.3s;         
        }
    </style>
</head>

<body style="background-color: rgb(212, 230, 249);">

    <div class="d-flex justify-content-between align-items-center my-2 mx-1">
        <a href="{{ route('menu.index') }}" class="btn btn-primary">☰ Menu</a>
        @if ($item->conferido <> 2)
            <a href="{{ route('pedidoopcoes.index',  ['id' => $item->pedido_id]) }}">⬅️ Voltar</a>
        @else
            <a href="{{ route('pedidoitens.itens',  ['id' => $item->pedido_id]) }}">⬅️ Voltar</a>
        @endif
    </div>

    <!-- Campo invisível para o leitor de código de barras -->
    <input type="text" id="codigo_lido" autofocus inputmode="none" style="opacity: 0; position: absolute; z-index: 999; height: 0;">
    
    <div class="content-wrapper">
        <div class="card card-pedido my-1 mx-1">

         <div class="d-flex justify-content-between align-items-center">
            @if ($pedidoitens->where('conferido', 0)->min('ordem') < $item->ordem)
                <!-- Botão Anterior (esquerda) -->
                <form action="{{ route('navegaritem') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $item->pedido_id }}">
                    <input type="hidden" name="flag" value="voltar">
                    <input type="hidden" name="posicao" value="{{ $item->ordem }}">
                    <button type="submit" class="btn-navegacao">🡸</button>
                </form>
            @else
                <!-- Espaço reservado para manter alinhamento -->
                <div style="width:40px;"></div>
            @endif

            <span style="font-size: 18px">
                Item {{ $item->ordem + 1 }} / {{ $pedidoitens->max('ordem') + 1 }}
                - Confer: {{ $pedidoitens->where('conferido', '<>', 0)->count() }}
            </span>

            @if ($pedidoitens->where('conferido', 0)->max('ordem') > $item->ordem)
                <!-- Botão Próximo (direita) -->
                <form action="{{ route('navegaritem') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $item->pedido_id }}">
                    <input type="hidden" name="flag" value="pular">
                    <input type="hidden" name="posicao" value="{{ $item->ordem }}">
                    <button type="submit" class="btn-navegacao">🡺</button>
                </form>
            @else
                <!-- Espaço reservado para manter alinhamento -->
                <div style="width:40px;"></div>
            @endif
            </div>

            <form id="formConferido" action="{{ route('confirmarqtde') }}" method="POST">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $item->id }}">
                <input type="hidden" id="quantidade_bipada" name="quantidade_bipada" value="0">
                <input type="hidden" name="flag" value="next">
                <input type="hidden" name="posicao" value="{{ $item->ordem }}">

                <!-- CAMPO INVISÍVEL PARA LEITURA DO COLETOR -->
                <input type="text" id="codigo_barras" autocomplete="off" readonly style="opacity:0; position:absolute; z-index:-1;">

                <div class="row text-center">
                    <div class="col-12">

                        <div class="info-item mt-1" style="font-size: 26px; color: red">
                            <strong>{{ $item->codigorua }}</strong>
                        </div>

                        <span style="color: black; font-size: 16px;"><strong>{{ $item->descricao }}</strong></span>
                        <div>
                            Cod.
                            <span id="codigo_correto" style="color: black; font-size: 16px;">{{ $item->codigosap }}</span>
                        </div>
            
                        @if ($item->conferido <> 2)
                            <span style="color: black; font-size: 15px;"><strong>Separados:</strong></span>
                            
                            <span id="contador" style="color: black; font-size: 40px;"><strong>0</strong></span>
                            
                            <span class="info-item mt-1" style="font-size: 20px">
                                <strong> / {{ $item->qtde }}</strong>
                            </span>
                            <span style="color: black; font-size: 20px;"><strong> - {{ $item->unidade }} </strong></span>

                            <div>
                                <span id="mensagem" style="font-size: 18px; color: red;"></span>
                            </div>
                        @else
                            <div class="info-item mt-1" style="font-size: 16px; color: red"><strong>DATA SEPARAÇÃO</strong></div>
                            <div class="info-item mt-1" style="font-size: 20px; color: red"><strong>{{ date_format($item->updated_at, 'd/m/y H:i') }} hs</strong></div>
                        @endif
                    </div>
                </div>
                <br>

                @if ($item->conferido <> 2)         
                    <div class="row justify-content-center text-center">
                        <div class="col-12 mb-2">
                            <button class="btn btn-warning" style="font-size: 18px;">Qtde Parcial</button>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-danger" style="font-size: 18px;">Sem Estoque</button>
                        </div>
                    </div>
                @endif
                <br>
            </form>

            <form action="{{ route('qtdemanual', ['item_id'=>$item->id]) }}" method="POST">
                @csrf
                <div class="row justify-content-center text-center" id="btnManual" style="">
                    <button class="btn btn-info" style="font-size: 18px;">Inserir Manual</button>
                </div>
            </form>
            <br>
        </div>
    </div>
</body>

<script src="{{ asset('js/sweetalert2@11.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('formConferido');
        const codigoCorreto = document.getElementById('codigo_correto').textContent.trim().toUpperCase();
        const input = document.getElementById('codigo_lido');
        const mensagem = document.getElementById('mensagem');
        const contadorSpan = document.getElementById('contador');
        const qtdeNecessaria = parseInt("{{ $item->qtde }}");

        let contador = 0;

        function isSwalOpen() {
            return document.querySelector('.swal2-container') !== null;
        }

        input.addEventListener('input', () => {
            const valor = input.value.trim().toUpperCase();
            const hiddenInput = document.getElementById('quantidade_bipada');
            input.value = '';

            if (valor === codigoCorreto) {
                contador++;
                contadorSpan.textContent = contador;
                mensagem.textContent = "✅ Código correto!";
                mensagem.style.color = "green";
                hiddenInput.value = contador;

                if (contador >= qtdeNecessaria) {
                    input.blur(); // Evita reabrir o teclado

                    Swal.fire({
                        icon: 'success',
                        title: 'Produto conferido!',
                        text: 'O produto foi totalmente conferido.',
                        confirmButtonText: 'Continuar'
                    }).then(() => {
                        form.submit();
                    });
                }
            } else {
                mensagem.textContent = "❌ Código incorreto! (" + valor + ")";
                mensagem.style.color = "red";
            }
        });

        input.addEventListener('blur', () => {
            // Só retoma o foco se o Swal não estiver visível
            setTimeout(() => {
                if (!isSwalOpen()) {
                    input.focus();
                }
            }, 200);
        });

        // Foco inicial manual
        input.focus();
    });

</script>
</html>
