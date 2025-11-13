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
            background: #f8f9fa;
            font-family: Arial, sans-serif;
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
            margin-top: 2px;
            overflow-x: auto;
        }

        .card {
            border-radius: 12px;
        }

        /* Cores pastel para os cards */
        .card-pastel-blue {
            background-color: #dbeafe; /* azul claro */
        }

        .card-pastel-green {
            background-color: #dcfce7; /* verde claro */
        }

        .card-pastel-yellow {
            background-color: #fef9c3; /* amarelo claro */
        }

        .card-pastel-red {
            background-color: #fee2e2; /* vermelho claro */
        }

        @media (max-width: 767px) {
            #sidebar {
                display: none !important;
            }

            .row.g-3.mb-4 {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>
    <div class="layout-wrapper">
        <!-- Sidebar -->
        @include('components.menu')

        <!-- Conteúdo Principal -->
        <div id="main-content">

            <!-- Header -->
            <nav class="navbar navbar-light bg-light mb-4 rounded shadow-sm p-3">
                <span class="navbar-brand mb-0 h4">📊 Painel de Controle</span>
                <div>
                    <span class="me-3">Bem-vindo, <strong>{{ Auth::user()->name }}</strong></span>
                </div>
            </nav>

            <!-- Cards principais -->
            <div class="row g-3 mb-4">
                <div class="col-md-3 col-6">
                    <form action="dashboard" method="POST">
                        @csrf
                        <input type="hidden" name="tipo" value="semsolicitacao">
                        <button type="submit" style="all: unset; cursor: pointer; display: block; width: 100%;">
                            <div class="card shadow-sm p-2 card-pastel-blue">
                                <h6 style="color: black;">Novas Cotações</h6>
                                <h3 class="fw-bold text-primary">{{ $pedidos['semsolicitacao'] }}</h3>
                            </div>
                        </button>
                    </form>
                </div>

                <div class="col-md-3 col-6">
                    <form action="dashboard" method="POST">
                        @csrf
                        <input type="hidden" name="tipo" value="naoenviado">
                        <button type="submit" style="all: unset; cursor: pointer; display: block; width: 100%;">
                            <div class="card shadow-sm p-2 card-pastel-green">
                                <h6 style="color: black;">Cotações não enviadas</h6>
                                <h3 class="fw-bold text-success">{{ $pedidos['semenvio'] }}</h3>
                            </div>
                        </button>
                    </form>
                </div>

                <div class="col-md-3 col-6">
                    <form action="dashboard" method="POST">
                        @csrf
                        <input type="hidden" name="tipo" value="semaprovacao">
                        <button type="submit" style="all: unset; cursor: pointer; display: block; width: 100%;">
                            <div class="card shadow-sm p-2 card-pastel-yellow">
                                <h6 style="color: black;">Cotações sem Aprovação</h6>
                                <h3 class="fw-bold text-warning">{{ $pedidos['semaprovacao'] }}</h3>
                            </div>
                        </button>
                    </form>
                </div>

                <div class="col-md-3 col-6">
                    <form action="dashboard" method="POST">
                        @csrf
                        <input type="hidden" name="tipo" value="atrasado">
                        <button type="submit" style="all: unset; cursor: pointer; display: block; width: 100%;">
                            <div class="card shadow-sm p-2 card-pastel-red">
                                <h6 style="color: black;">Cotações Atrasadas</h6>
                                <h3 class="fw-bold text-danger">{{ $pedidos['atrasados'] }}</h3>
                            </div>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Formulário de filtros -->
            <form action="dashboard" method="POST">
            @csrf
                <div class="input-group mb-3">
                    <input type="number" class="form-control mx-1" name="numeropedido" value="" placeholder="Pesquisar número do pedido" style="color: black;">
                    <button type="submit" class="btn btn-info mx-1">🔍</button>
                </div>
            </form>

            <!-- Tabela de exemplo -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>📦 Pedidos 
                        @if (request()->tipo == 'semsolicitacao')
                            - Novas Cotações
                        @elseif (request()->tipo == 'naoenviado')
                            - Cotações não enviadas
                        @elseif (request()->tipo == 'semaprovacao')
                            - Cotações sem Aprovação
                        @elseif (request()->tipo == 'atrasado')
                            - Cotações Atrasadas
                        @endif
                    </strong>
                </div>
                <div class="card-body table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Data Solicitação</th>
                                <th>Solicitante</th>
                                <th>Setor</th>
                                <th>Ordem Serviço</th>
                                <th>Data Retorno</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dados as $dado)
                                <tr>
                                    <td><a href="{{ route('timeline', [ 'pedido_id'=>$dado->id]) }}" title="Visualizar timeline" style="cursor: pointer; text-decoration: underline; font-weight: bold">{{ $dado->numero_pedido }}</a></td>
                                    <td>{{ $dado->data_solicitacao ? $dado->data_solicitacao->format('d-m-Y') : '' }}</td>
                                    <td>{{ $dado->solicitante }}</td>
                                    <td>{{ $dado->setor }}</td>
                                    <td>{{ $dado->ordem_servico }}</td>
                                    <td>
                                        @if ($dado->finalizado == 1)
                                            Finalizado
                                        @elseif (!is_null($dado->data_aprovacao))
                                            Aprovado
                                        @elseif (!is_null($dado->dias_retorno) && !is_null($dado->data_envio_cotacao))
                                            @if (($dado->data_envio_cotacao->addDays($dado->dias_retorno)) < now())
                                                <span style="color: red;">
                                                    {{ $dado->data_envio_cotacao->addDays($dado->dias_retorno)->format('d-m-Y') }}
                                                </span> 
                                            @else
                                                {{ $dado->data_envio_cotacao->addDays($dado->dias_retorno)->format('d-m-Y') }}
                                            @endif
                                        @else
                                            --
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Nenhum dado encontrado</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div> <!-- fim main-content -->
    </div> <!-- fim layout-wrapper -->

</body>
</html>
