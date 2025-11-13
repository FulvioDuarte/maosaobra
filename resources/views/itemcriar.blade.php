<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Almox - Tambasa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-extended.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontes.css') }}">

    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .layout-wrapper {
            display: flex;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        #sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            transition: all 0.3s ease;
        }

        #sidebar.hidden {
            margin-left: -250px;
        }

        #main-content {
            flex-grow: 1;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .table-responsive {
            margin-top: 20px;
        }

        @media (max-width: 767px) {
            #sidebar {
                display: none !important;
            }
        }

        #mensagem {
            transition: opacity 1s ease;
        }
    </style>
</head>

<body>
    <div class="layout-wrapper">

        @include('components.menu')

        <!-- Conteúdo principal -->
        <main id="main-content">
            <!-- Botão para mostrar/ocultar menu -->
            <div class="d-flex align-items-center mb-2">
                <button class="btn btn-outline-secondary d-none d-md-block" id="toggleSidebar" style="margin-right: 40px;">
                    ☰
                </button>
                <span class="h5 mb-0">Gestão de Compras Consumo - ITEM - Pedido #{{ $pedido->numero_pedido }}</span>
            </div>

            @if (session('msg'))
                <div id="mensagem" style=" background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0;transition: opacity 1s ease;">
                    {{ session('msg') }}
                </div>
            @endif

            <div class="p-2 mb-1" style="background: #fff; border: 1px solid #dee2e6; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <!-- Formulário de filtros -->
                <form action="{{ route('gravaitem') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pedido_id" value="{{ $pedido->id }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="requisicao">Requisição</label>
                            <input type="text" class="form-control" name="requisicao" required>
                        </div>
                        <div class="col-md-2">
                            <label for="qtde">Quantidade</label>
                            <input type="number" class="form-control" name="qtde" required>
                        </div>
                        <br>
                        <div class="col-md-7">
                            <label for="produto_id">Produto</label>
                            <select class="form-control" name="produto_id" required>
                                <option value=""></option>
                                @foreach ($produtos as $produto)
                                    <option value="{{ $produto->id }}" >{{ $produto->descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-success">GRAVAR</button>

                    @if ($fornecAssociado > 0)
                        <div style=" background-color:rgb(253, 218, 211); color:rgb(0, 0, 0); padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0;transition: opacity 1s ease;">
                            ⚠️ ATENÇÃO: A inclusão do novo Item removerá os Fornecedores associados.
                        </div>
                    @endif
                </form>
            </div>

            <br>
            <a href="{{ route('visualizacotacaoalmox', ['pedido_id'=>$pedido->id]) }}">⬅️ Voltar</a>
        </main>
    </div>
    
</body>

<script src="{{ asset('js/sweetalert2@11.js') }}"></script>

<script>
        document.addEventListener("DOMContentLoaded", function () {
            // Alternar sidebar
            document.getElementById('toggleSidebar')?.addEventListener('click', function () {
                document.getElementById('sidebar')?.classList.toggle('hidden');
            });
        });

          setTimeout(() => {
                const el = document.getElementById('mensagem');
                if (el) {
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 1000);
                }
            }, 3000);
</script>    
</html>
