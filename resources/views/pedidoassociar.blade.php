<!DOCTYPE html>
<html class="loading" lang="pt-br" data-textdirection="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almox - Tambasa</title>

    <link rel="shortcut icon" type="image/x-icon" href="../images/ico/favicon.ico">
    <link rel="stylesheet" href="{{ asset('css/fontes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-extended.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .container-custom {
            padding: 20px;
        }

        .table-responsive {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container-fluid container-custom">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('menu.index') }}" class="btn btn-primary">☰ Menu</a>
            <a href="{{ route('pedidorelatorio') }}" class="btn btn-secondary">Relatório</a>
            
            <form action="migrarpesquisa" method="POST"  class="d-flex align-items-center">
                @csrf
                    <input type="text" class="form-control" name="numeromigrar" style="color: black;" placeholder="Número Reserva">
                    <button type="submit" class="btn btn-info">MIGRAR</button>
            </form>
            
            <a href="{{ route('menu.index') }}">⬅️ Voltar</a>
        </div>

        @if (session('msg'))
            <div id="mensagem" style=" background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0;transition: opacity 1s ease;">
                {{ session('msg') }}
            </div>
        @endif

        @if (session('msgWrn'))
            <div id="mensagem" style=" background-color: #f9b9abff; color: #060706ff; padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0;transition: opacity 1s ease;">
                {{ session('msgWrn') }}
            </div>
        @endif

        <form action="pedidoassociar" method="POST">
            @csrf
            <div class="input-group mb-3">
                <input type="number" class="form-control mx-1" name="numeropedido" value="{{ request('numeropedido') }}" id="numeropedido" style="color: black;" placeholder="Pesquisar Reserva"
                    onkeydown="if(event.key === 'Enter'){ this.form.submit(); }">

                <select class="form-control mx-1" name="filtronome">
                    <option value="">Todos Usuários</option>
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ request('filtronome') == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>

                <select class="form-control mx-1" name="filtrostatus">
                    <option value="">Status</option>
                    <option value="0" {{ request('filtrostatus') === '0' ? 'selected' : '' }}>Novo</option>
                    <option value="1" {{ request('filtrostatus') === '1' ? 'selected' : '' }}>Pendente</option>
                    <option value="2" {{ request('filtrostatus') === '2' ? 'selected' : '' }}>Finalizado</option>
                    <option value="3" {{ request('filtrostatus') === '3' ? 'selected' : '' }}>Excluído</option>
                </select>

                <input type="date" class="form-control mx-1" value="{{ request('datainicio') }}" name="datainicio" style="color: black;">
                <input type="date" class="form-control mx-1" value="{{ request('datafim') }}" name="datafim" style="color: black;">
                
                <button type="submit" class="btn btn-info mx-1">🔍</button>
            </div>
        </form>

        <form method="POST" action="{{ route('gravarassociacao') }}">
            @csrf

            @if (!in_array(request('filtrostatus'), ['2', '3']))
                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-success">Gravar Associação</button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table w-100">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Reserva</th>
                            <th>Itens</th>
                            <th>Status</th>
                            <th>Data Conf.</th>
                            <th>Tempo Conf.</th>
                            <th>Associado</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pedidos as $pedido)
                            <tr>
                                <td style="color: black">{{ date_format($pedido->created_at, 'd/m/y') }}</td>
                                <td style="color: black">
                                    <a href="{{ route('visualizar', ['id' => $pedido->id]) }}" class="btn-confirmar-visualiza" title="Visualizar Pedido">
                                        <strong><u>{{ $pedido->numero }}</u></strong>
                                    </a>
                                </td>
                                <td style="color: black">{{ $pedido->conferido }} / {{ $pedido->qtde }}</td>
                                <td style="color: black">
                                    @if (request('filtrostatus') == 3)
                                        --
                                    @else
                                        @if ($pedido->finalizado == 1)
                                            PENDENTE
                                        @elseif ($pedido->finalizado == 2)
                                            FINALIZADO
                                        @else
                                            NOVO 
                                        @endif
                                    @endif
                                </td>
                                <td style="color: black">{{ $pedido->datafinalizado ? date_format($pedido->datafinalizado, 'd/m/y') : '-' }}</td>                       
                                <td style="color: black">{{ $pedido->tempo }}</td>                       
                                <td>
                                    @if (request('filtrostatus') == 3)
                                        --
                                    @else
                                        @if ($pedido->finalizado != 2)
                                            <select class="form-control" name="associados[{{ $pedido->id }}][usuario_id]">
                                                <option value="{{ $pedido->usuario_id }}">{{ $pedido->name }}</option>
                                                @foreach ($usuarios as $usuario)
                                                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option> 
                                                @endforeach
                                            </select>
                                        @else
                                            {{ $pedido->name }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if (request('filtrostatus') == 3)
                                        <a href="{{ route('reativar', ['id' => $pedido->id]) }}" class="btn btn-info btn-confirmar-reativar">Reativar</a>
                                    @else
                                        <a href="{{ route('visualizar', ['id' => $pedido->id]) }}" class="btn-confirmar-visualiza" title="Visualizar Pedido">👀</a>
                                        <a href="{{ route('excluir', ['id' => $pedido->id]) }}" class="btn-confirmar-exclusao" title="Excluir Pedido">🗑️</a>
                                        @if ($pedido->finalizado == 2)
                                            (Finalizado)
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-success">Nenhum pedido encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <script src="{{ asset('vendors/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const botoes = document.querySelectorAll(".btn-confirmar-exclusao");

            botoes.forEach(function (botao) {
                botao.addEventListener("click", function (e) {
                    e.preventDefault();
                    const link = this.getAttribute("href");

                    Swal.fire({
                        title: 'Excluir Pedido',
                        text: "Deseja realmente excluir o Pedido?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sim, excluir!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = link;
                        }
                    });
                });
            });

            // Foco automático
            document.getElementById('numeropedido')?.focus();

            // Remover mensagem após 2 segundos
            setTimeout(() => {
                const el = document.getElementById('mensagem');
                if (el) {
                    el.style.opacity = '0'; 
                    setTimeout(() => el.remove(), 1000); 
                }
            }, 5000); 
        });
    </script>
</body>
</html>
