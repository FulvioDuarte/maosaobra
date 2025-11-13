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

    <div class="content-wrapper">
        <div class="card card-pedido my-1 mx-1">
            <form action="{{ route('confirmarqtde') }}" method="POST">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $item->id }}">
                <input type="hidden" name="posicao" value="{{ $item->ordem }}">
                
                <!-- CAMPO INVISÍVEL PARA LEITURA DO COLETOR -->
                <input type="text" id="codigo_barras" autocomplete="off" style="opacity:0; position:absolute; z-index:-1;">

                <div class="row text-center">
                    <div class="col-12">
                        <div class="info-item mt-1" style="font-size: 18px; color: red">
                            <strong>{{ $item->rua }}</strong>
                        </div>

                        <span style="color: black; font-size: 16px;"><strong>{{ $item->descricao }}</strong></span>

                        @if ($item->conferido <> 2)
                            <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-top: 20px;">
                                <input id="quantidade" type="number" name="quantidade" value="{{ $item->qtdeconferida }}" min="0"
                                    style="text-align: center; font-size: 24px; width: 80px; height: 50px; border: 2px solid #ccc; border-radius: 8px; box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);" readonly>
                            </div>

                            <!-- Exibe quantos ainda faltam -->
                            <div id="faltamConferir" class="mt-1" style="font-size: 18px;"></div>
                        @else
                            <div class="info-item mt-1" style="font-size: 16px; color: red"><strong>DATA SEPARAÇÃO</strong></div>
                            <div class="info-item mt-1" style="font-size: 20px; color: red"><strong>{{ date_format($item->updated_at, 'd/m/y H:i') }} hs</strong></div>
                        @endif

                        <div class="info-item mt-1" style="font-size: 16px">
                            <strong>{{ $item->qtdeconferida }} conferido / {{ $item->qtde }} qtde</strong>
                        </div>
                    </div>
                </div>

                @if ($item->conferido <> 2)
                    <div class="d-flex justify-content-center my-1">
                        <button class="btn btn-success" style="font-size: 18px;">Confirmar</button>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <script src="{{ asset('vendors/js/jquery-3.6.0.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('codigo_barras');
            const quantidadeInput = document.getElementById('quantidade');
            const form = document.querySelector('form');
            const faltamDiv = document.getElementById('faltamConferir');

            const codigoCorreto = "{{ $item->codigo }}";
            const qtdeNecessaria = parseInt("{{ $item->qtde }}");
            let qtdeConferida = parseInt("{{ $item->qtdeconferida }}");

            function atualizarInfo() {
                quantidadeInput.value = qtdeConferida;
                const faltam = qtdeNecessaria - qtdeConferida;
                faltamDiv.textContent = `Faltam ${faltam} unidades`;
            }

            atualizarInfo();
            input.focus();

            input.addEventListener('input', () => {
                const valor = input.value.trim();
                input.value = ''; // Limpa o campo para próximo bip

                if (valor === codigoCorreto) {
                    qtdeConferida += 1;
                    atualizarInfo();

                    if (qtdeConferida >= qtdeNecessaria) {
                        form.submit(); // Envia o formulário automaticamente
                    }
                } else {
                    alert('Código incorreto! Por favor, tente novamente.');
                }
            });

            input.addEventListener('blur', () => {
                setTimeout(() => input.focus(), 100); // Mantém foco sempre
            });
        });
    </script>
</body>
</html>
