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
                <span class="h5 mb-0">Gestão de Compras Consumo - ITENS - Pedido #{{ $pedido->numero_pedido }}</span>
            </div>

            <a href="{{ route('criaitem', ['pedido_id' => $pedido->id]) }}" class="btn btn-success btn">➕ INSERIR ITEM</a>            
            <br>
            <br>
            
            <!-- Mensagem -->
            @if (session('msg'))
                <div id="mensagem" style=" background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0;transition: opacity 1s ease;">
                    {{ session('msg') }}
                </div>
            @endif

            <div class="p-1 mb-1" style="background: #fff; border: 1px solid #dee2e6; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <!-- Tabela -->
                <div class="table-responsive">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Requisição</th>
                                <th>SAP</th>
                                <th>Quantidade</th>
                                <th>Descrição</th>
                                <th>Unidade</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $indice=>$item)
                            <tr>
                                <td>{{ $indice + 1 }}</td>
                                <td>{{ $item->requisicao }}</td>
                                <td>{{ $item->sap }}</td>
                                <td>{{ $item->qtde }}</td>
                                <td>{{ $item->descricao }}</td>
                                <td>{{ $item->unidade }}</td>
                                
                                <td>
                                    <!-- Excluir -->
                                    <form method="POST" action="{{ route('excluiitem') }}" style="display: inline;" onsubmit="return false;">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                            <span onclick="confirmarExclusao(this)" style="cursor: pointer; margin: 0 10px" title="Excluir Item">🗑️</span>
                                    </form>       
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>  
            </div>

            <br>
            <div>
                <a href="{{ route('cotacaoalmox') }}">⬅️ Voltar</a>
            </div>             
                       
        </main>
    </div>

    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Alternar sidebar
            document.getElementById('toggleSidebar')?.addEventListener('click', function () {
                document.getElementById('sidebar')?.classList.toggle('hidden');
            });
        });

        function confirmarExclusao(el) {
            Swal.fire({
                title: 'Tem certeza?',
                text: "⚠️ ATENÇÃO: A exclusão do Item também removerá os Fornecedores associados.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    el.closest('form').submit();
                }
            });
        }

        setTimeout(() => {
            const el = document.getElementById('mensagem');
            if (el) {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 1000);
            }
        }, 3000);
    </script>
</body>
</html>
