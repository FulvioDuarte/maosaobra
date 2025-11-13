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

    <!-- Campo invisível para o leitor de código de barras -->
    <input type="text" id="codigo_lido" autofocus inputmode="none" style="opacity: 0; position: absolute; z-index: 999; height: 0;">
    
    <div class="content-wrapper">
        <div class="card card-pedido my-1 mx-1">
            <form id="formConferido" action="{{ route('gravaconferido') }}" method="POST">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $item->id }}">
      
                <!-- CAMPO INVISÍVEL PARA LEITURA DO COLETOR -->
                <input type="text" id="codigo_correto" autocomplete="off" readonly style="opacity:0; position:absolute; z-index:-1;">

                <div class="row text-center">
                    <div class="col-12">
                        <br>
                        <span style="color: black; font-size: 16px;"><strong>ECANEAR O QR CODE</strong></span>
                    </div>
                </div>
                <br>
                <br>
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
        const codigosap = parseInt("{{ $item->codigosap }}");
        const codigorua = parseInt("{{ $item->codigorua }}");
        const descricao = parseInt("{{ $item->descricao }}");
        const qtde = parseInt("11");

        function isSwalOpen() {
            return document.querySelector('.swal2-container') !== null;
        }

        input.addEventListener('input', () => {
            const valor = input.value.trim().toUpperCase();
            input.value = '';

            input.blur(); // Evita reabrir o teclado

            const mensagem = `
                <b>Produto SAP:</b> ${codigosap}<br>
                <b>Produto Rua:</b> ${codigorua}<br>
                <b>Quantidade:</b> ${qtde}
            `;

            Swal.fire({
                    icon: 'question',
                    title: 'Os dados estão ok?',
                    html: `${descricao}<br><br>${mensagem}`,
                    showCancelButton: true,  // Habilitar o botão de cancelar (Não)
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Se "Sim" for clicado
                        form.submit();
                    } else {
                        input.focus()
                    }
                });
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
