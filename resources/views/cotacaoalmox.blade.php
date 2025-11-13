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
                <span class="h5 mb-0">Gestão de Compras Consumo - COTAÇÕES</span>
            </div>

            <!-- Formulário de filtros -->
            <form action="cotacaoalmox" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="number" class="form-control mx-1" name="numeropedido" value="{{ request('numeropedido') }}" id="numeropedido" placeholder="Número do pedido"
                        onkeydown="if(event.key === 'Enter'){ this.form.submit(); }" style="color: black;">

                    <input type="date" class="form-control mx-1" name="datainicio" value="{{ \Carbon\Carbon::parse($dataInicio)->format('Y-m-d') }}" style="color: black;" required>
                    <input type="date" class="form-control mx-1" name="datafim" value="{{ \Carbon\Carbon::parse($dataFim)->format('Y-m-d') }}" style="color: black;" required>
                    <button type="submit" class="btn btn-info mx-1">🔍</button>
                </div>
            </form>

            <a href="{{ route('criacotacaoalmox') }}" class="btn btn-success btn">➕ Criar Cotação</a>

            <!-- Mensagem -->
            @if (session('msg'))
                <div id="mensagem" style=" background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0;transition: opacity 1s ease;">
                    {{ session('msg') }}
                </div>
            @endif

            <!-- Tabela -->
            <div class="table-responsive">
                <table class="table table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Data Solic.</th>
                            <th>Solicitante</th>
                            <th>Setor</th>
                            <th>Itens</th>
                            <th>Forn.</th>
                            <th>Ação</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedidos as $pedido)
                        <tr>
                            <td><a href="{{ route('timeline', [ 'pedido_id'=>$pedido->id]) }}" title="Visualizar timeline" style="cursor: pointer; text-decoration: underline; font-weight: bold">{{ $pedido->numero_pedido }}</a></td>
                            <td>{{ $pedido->data_solicitacao ? $pedido->data_solicitacao->format('d-m-Y') : '' }}</td>
                            <td>{{ $pedido->solicitante }}</td>
                            <td>{{ $pedido->setor }}</td>
                            
                            @if (is_null($pedido->finalizado))
                                <td>
                                    <form method="POST" action="visualizacotacaoalmox" style="display: inline;">
                                    @csrf
                                        <input type="hidden" name="pedido_id" value="{{ $pedido->id }}">
                                        <span onclick="this.closest('form').submit()" style="cursor: pointer; text-decoration: underline; font-weight: bold" 
                                            title="Visualizar Itens">{{ $pedido->qtdeitens }}
                                        </span>
                                    </form>
                                </td>

                                <td>
                                    @if ($pedido->qtdeitens > 0)
                                        <form method="POST" action="{{ route('visualizacotacaofornec', ['pedido_id'=>$pedido->id]) }}" style="display: inline;">
                                        @csrf
                                            <span onclick="this.closest('form').submit()" style="cursor: pointer; text-decoration: underline; font-weight: bold" 
                                                title="Visualizar Fornecedores">{{ $pedido->qtdefornec == 0 ? 0 : $pedido->qtdefornec / $pedido->qtdeitens }}
                                            </span>
                                        </form>
                                    @else
                                     <span> -- </span>
                                    @endif
                                </td>
                            @else
                                <td>
                                    <span>{{ $pedido->qtdeitens }}</span>
                                </td>
                                <td>
                                    <span>{{ $pedido->qtdefornec == 0 ? 0 : $pedido->qtdefornec / $pedido->qtdeitens }}</span>
                                </td>
                            @endif 

                            <td>
                                @if (is_null($pedido->finalizado))
                                    <!-- Editar -->
                                    <form method="POST" action="editacotacaoalmox" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="pedido_id" value="{{ $pedido->id }}">
                                            <span onclick="this.closest('form').submit()" style="cursor: pointer; margin: 0 5px" title="Editar cotação">✏️</span>
                                    </form>

                                    <!-- Excluir -->
                                    <form method="POST" action="excluicotacaoalmox" style="display: inline;" onsubmit="return false;">
                                        @csrf
                                        <input type="hidden" name="pedido_id" value="{{ $pedido->id }}">
                                            <span onclick="confirmarExclusao(this)" style="cursor: pointer; margin: 0 5px" title="Excluir cotação">🗑️</span>
                                    </form>     
                                @else
                                    Finalzado
                                @endif
                            </td>
                            <td>
                                @if (!is_null($pedido->documento_aprovado) && $pedido->documento_aprovado <> '')
                                    
                                <!-- <a href="{{ asset('almox/public/storage/'.$pedido->documento_aprovado) }}" target="_blank">Visualizar documento</a> -->
                                <a href="{{ asset('storage/' . $pedido->documento_aprovado) }}" target="_blank" title="Visualizar Documento Aprovação">📄</a>
                                @else
                                    <a href="{{ route('aprovapedido', ['pedido_id'=>$pedido->id]) }}" title="Aprovar Cotação">🟢</a>
                                @endif
                            
                                @if (is_null($pedido->finalizado))
                                    <a href="{{ route('finalizapedido', ['pedido_id'=>$pedido->id]) }}" title="Finalizar Cotação">☑️</a>
                                @else
                                    <a href="{{ asset('storage/' . $pedido->documento_finalizado) }}" target="_blank" title="Visualizar Nota Fiscal">🧾</a>
                                @endif   
                            
                                <a href="{{ route('cotacaoimprimir', ['pedido_id'=>$pedido->id]) }}" title="Imprimir Cotação">🖨️</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
                text: "Esta ação excluirá a cotação!",
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
