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
                <span class="h5 mb-0">Gestão de Compras Consumo - COTAÇÕES  - Pedido #{{ $pedido->numero_pedido }}</span>
            </div>
    
            @if (count($cotacaofornec) <> 3)
                <a href="{{ route('acrescentarfornecedor', ['pedido_id'=>$pedido->id]) }}" class="btn btn-success btn">➕ Acrescentar Fornecedor</a>
            @endif

            @if (session('msg'))
                <div id="mensagem" style=" background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0;transition: opacity 1s ease;">
                    {{ session('msg') }}
                </div>
            @endif

            <div class="table-responsive">
                
                <div class="p-1 mb-1" style="background: #fff; border: 1px solid #dee2e6; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fornecedor</th>
                                <th>contato</th>
                                <th>Telefone</th>
                                <th>Telefone2</th>
                                <th>Emal</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cotacaofornec as $fornec)
                                <tr>
                                    <td>{{ $fornec->id }}</td>
                                    <td>{{ $fornec->nome }}</td>
                                    <td>{{ $fornec->contato }}</td>
                                    <td>{{ $fornec->telefone1 }}</td>
                                    <td>{{ $fornec->telefone2 }}</td>
                                    <td>{{ $fornec->email }}</td>
                                    <td>
                                        <!-- Editar -->
                                        <form method="POST" action="{{ route('editarcotacaofornec', ['pedido_id'=>$pedido->id]) }}" style="display: inline;">
                                        @csrf
                                            <input type="hidden" name="fornec_id" value="{{ $fornec->id }}">
                                            <span onclick="this.closest('form').submit()" style="cursor: pointer; margin: 0 4px" title="Editar preços fornecedor">💰</span>
                                        </form>

                                        <!-- Excluir -->
                                        <form method="POST" action="{{ route('excluircotacaofornec', ['pedido_id'=>$pedido->id]) }}" style="display: inline;" onsubmit="return false;">
                                        @csrf
                                            <input type="hidden" name="fornec_id" value="{{ $fornec->id }}">
                                            <span onclick="confirmarExclusao(this)" style="cursor: pointer; margin: 0 4px" title="Excluir fornecedor associado">🗑️</span>
                                        </form>      
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-success">Nenhum fornecedor associado</td>
                                </tr>   
                            @endforelse 
                        </tbody>
                    </table>
                </div>

                <br>
                <label class="h5 mb-0" for="nomeramo">GERAÇÃO DO ENVIO</label>
                <br>
                <br>
                
                <div class="p-1 mb-1" style="background: #fff; border: 1px solid #dee2e6; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <form method="POST" action="{{ route('solicitarcotacaofornec') }}" style="display: inline;">
                        @csrf
                        <input type="hidden" name="pedido_id" value="{{ $pedido->id }}">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-4">
                                    <label for="diasretorno">Comprador</label>
                                    <select class="form-control" name="localcompra" required>
                                       <option value=""></option>
                                       @foreach ($entregas as $entrega)
                                        <option value="{{ $entrega['id'] }}" {{ $pedido->localcompra_id == $entrega['id'] ?  'selected' : $entrega['codigo'] }} - {{  $entrega['nome'] }}> {{ $entrega['codigo'] }} - {{  $entrega['nome'] }} </option>   
                                       @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="diasretorno">Local entrega</label>
                                    <select class="form-control" name="localentrega" required>
                                       <option value=""></option>
                                       @foreach ($entregas as $entrega)
                                        <option value="{{ $entrega['id'] }}" {{ $pedido->localentrega_id == $entrega['id'] ?  'selected' : $entrega['codigo'] }} - {{  $entrega['nome'] }}> {{ $entrega['codigo'] }} - {{  $entrega['nome'] }} </option>   
                                       @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="dataenvio">Data Envio Cotação para Fornecedor</label>
                                    <input type="date" class="form-control" name="dataenvio" value="{{ $pedido->data_envio_cotacao ? \Carbon\Carbon::parse($pedido->data_envio_cotacao)->format('Y-m-d') : '' }}">
                                </div>
                                <button type="submit" class="btn btn-primary" title="Solicitar orçamento">🖨️</button>
                            </div>
                            <br>
                        </div>
                    </form>
                </div>

                <br>
                <label class="h5 mb-0" for="nomeramo">SOLICITAÇÕES ENVIADAS</label>
                <br>
                <br>
                
                <div class="p-1 mb-1" style="background: #fff; border: 1px solid #dee2e6; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <form method="POST" action="{{ route('gravadataspedido', ['pedido_id'=>$pedido->id]) }}" style="display: inline;">
                        @csrf
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-2">
                                    <label for="diasretorno">Dias Retorno</label>
                                    <input type="number" class="form-control" name="diasretorno" value="{{ $pedido->dias_retorno }}">
                                </div>
                                <div class="col-3">
                                    <label for="dataenvio">Data Envio Cotação para Fornecedor</label>
                                    <input type="date" class="form-control" name="dataenvio" value="{{ $pedido->data_envio_cotacao ? \Carbon\Carbon::parse($pedido->data_envio_cotacao)->format('Y-m-d') : '' }}">
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">salvar</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <br>
            <br>
            <a href="{{ route('cotacaoalmox') }}">⬅️ Voltar</a>
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
                text: "Esta ação excluirá a associação do fornecedor a cotação!",
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
