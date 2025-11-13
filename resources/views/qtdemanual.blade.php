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

        /* Começam invisíveis */
        #quantidade_bipada,
        #btnInserir {
            display: none;
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
            
                    <span style="color: black; font-size: 15px;"><strong>Qtde:</strong></span>
                    <span class="info-item mt-1" style="font-size: 20px"><strong>{{ $item->qtde }}</strong></span>
                    <div>
                        <span id="mensagem" style="font-size: 18px; color: red;"></span>
                    </div>
                    <br>
                    <span class="info-item mt-1" style="font-size: 20px"><strong>BIPAR CÓDIGO DE BARRAS</strong></span>
                </div>
            </div>
            <br>

            <form id="formConferido" action="{{ route('confirmarqtde') }}" method="POST">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $item->id }}">
                <input type="hidden" name="flag" value="next">
                <input type="hidden" name="posicao" value="{{ $item->ordem }}">

                <div class="row justify-content-center text-center">
                    <div class="col-6 mb-2">
                        <input type="number" class="form-control" id="quantidade_bipada" name="quantidade_bipada" style="color: black; font-size: 22px; text-align: center;" required>
                    </div> 
                </div>
                <div class="row justify-content-center text-center">
                    <button id="btnInserir" class="btn btn-info" style="font-size: 18px;">Inserir Manual</button>
                </div>
            </form>
            <br>
        </div>
    </div>

    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('formConferido');
        const codigoCorreto = document.getElementById('codigo_correto').textContent.trim().toUpperCase();
        const inputCodigo = document.getElementById('codigo_lido');
        const mensagem = document.getElementById('mensagem');
        const campoNumero = document.getElementById('quantidade_bipada');
        const botaoInserir = document.getElementById('btnInserir');
        const qtdeMaxima = parseInt("{{ $item->qtde }}"); // pega qtde do item
        let modoManual = false;

        function isSwalOpen() {
            return document.querySelector('.swal2-container') !== null;
        }

        // Valida código de barras
        inputCodigo.addEventListener('input', () => {
            if (modoManual) return;

            const valor = inputCodigo.value.trim().toUpperCase();
            inputCodigo.value = ''; // limpa leitura

            if (valor === codigoCorreto) {
                mensagem.textContent = "✅ Código correto!";
                mensagem.style.color = "green";

                // Mostra campos
                campoNumero.style.display = "block";
                botaoInserir.style.display = "inline-block";
                campoNumero.focus();
            } else {
                mensagem.textContent = "❌ Código incorreto! (" + valor + ")";
                mensagem.style.color = "red";

                // Esconde campos
                campoNumero.style.display = "none";
                botaoInserir.style.display = "none";
            }
        });

        // Impede digitar quantidade maior que a permitida
        campoNumero.addEventListener('input', () => {
            const valor = parseInt(campoNumero.value);
            if (valor > qtdeMaxima) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Quantidade inválida',
                    text: `O máximo permitido é ${qtdeMaxima}.`,
                    confirmButtonText: 'Ok',
                });
                campoNumero.value = qtdeMaxima;
            }
        });

        // Controle de foco e modo manual
        inputCodigo.addEventListener('blur', () => {
            setTimeout(() => {
                if (!isSwalOpen() && !modoManual) inputCodigo.focus();
            }, 200);
        });

        campoNumero.addEventListener('focus', () => {
            modoManual = true;
            inputCodigo.blur();
        });

        campoNumero.addEventListener('blur', () => {
            modoManual = false;
            setTimeout(() => {
                if (!isSwalOpen()) inputCodigo.focus();
            }, 200);
        });

        inputCodigo.focus();
    });
</script>


</body>
</html>

