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

        .table th,
            .table td {
                font-size: 12px;          /* fonte menor */
                padding: 4px 8px;         /* menos espaço interno */
                white-space: nowrap;      /* impede quebra de linha */
            }

            .table thead th {
                background-color: #343a40;
                color: #000;
                text-align: center;
            }
    </style>
</head>

<body>
    <div class="container-fluid container-custom">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('menu.index') }}" class="btn btn-primary">☰ Menu</a>    
            <a href="{{ route('pedidoassociar') }}">⬅️ Voltar</a>
        </div>

        <form action="migrar" method="POST" class="d-flex align-items-center">
        @csrf
            <input type="hidden" name="numero_pedido" value="{{ $numeropedido }}">
            <div class="container">
                <h4 class="mb-3">📦 Reservas do Almoxarifado - {{ $numeropedido }}</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Reserva</th>
                                <th>Endereço</th>
                                <th>Material</th>
                                <th>Descrição</th>
                                <th>Item</th>
                                <th>Qtde</th>
                                <th>Unid.</th>
                                <th>Unid.</th>
                                <th>UMR</th>
                                <th>Check List</th>
                                <th>Elm.</th>
                                <th>Aprov.</th>
                                <th>Concl.</th>
                                <th>Data nec.</th>
                                <th>Cen.</th>
                                <th>Dep.</th>
                                <th>Criado</th>
                                <th>Aprovador</th>
                                <th>Data aprov.</th>
                                <th>Hora</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($dados as $index => $item)
                                <tr>
                                    <td>{{ (int) $item['RSNUM'] }}</td>
                                    <td>{{ $item['LGPBE'] }}</td>
                                    <td>{{ number_format((int) ltrim($item['MATNR'], '0'), 0, ',', '.') }}</td>
                                    <td>{{ $item['MAKTX'] }}</td>
                                    <td>{{ $item['RSPOS'] }}</td>
                                    <td>{{ $item['ERFMG'] }}</td>
                                    <td>{{ $item['ERFME'] }}</td>
                                    <td>{{ $item['MEINS'] }}</td>
                                    <td></td>
                                    <td>{{ $item['SCHGT'] }}</td>
                                    <td>{{ $item['XLOEK'] }}</td>
                                    <td>{{ $item['XWAOK'] }}</td>
                                    <td>{{ $item['KZEAR'] }}</td>
                                    <td>{{ $item['BDTER'] }}</td>
                                    <td>{{ $item['WERKS'] }}</td>
                                    <td>{{ $item['LGORT'] }}</td>
                                    <td>{{ $item['USNAM'] }}</td>
                                    <td>{{ $item['USUARIO'] }}</td>
                                    <td>{{ $item['DATA'] }}</td>
                                    <td>{{ $item['HORA'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br>
               
                <!-- ITENS DUPLICADOS -->
                @if (count($dados) <> count($duplicados) && count($duplicados) > 0)
                    <br>
                    <h4 class="mb-3">ATENÇÃO! Há itens IGUAIS que tiveram suas quantidades somadas. Favor verificar.</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Reserva</th>
                                    <th>Endereço</th>
                                    <th>Material</th>
                                    <th>Descrição</th>
                                    <th>Item</th>
                                    <th>Qtde</th>
                                    <th>Unid.</th>
                                    <th>Unid.</th>
                                    <th>UMR</th>
                                    <th>Check List</th>
                                    <th>Elm.</th>
                                    <th>Aprov.</th>
                                    <th>Concl.</th>
                                    <th>Data nec.</th>
                                    <th>Cen.</th>
                                    <th>Dep.</th>
                                    <th>Criado</th>
                                    <th>Aprovador</th>
                                    <th>Data aprov.</th>
                                    <th>Hora</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($duplicados as $index => $item)
                                    <tr>
                                        <td>{{ (int) $item['RSNUM'] }}</td>
                                        <td>{{ $item['LGPBE'] }}</td>
                                        <td>{{ number_format((int) ltrim($item['MATNR'], '0'), 0, ',', '.') }}</td>
                                        <td>{{ $item['MAKTX'] }}</td>
                                        <td>{{ $index }}</td>
                                        <td>{{ $item['ERFMG'] }}</td>
                                        <td>{{ $item['ERFME'] }}</td>
                                        <td>{{ $item['MEINS'] }}</td>
                                        <td></td>
                                        <td>{{ $item['SCHGT'] }}</td>
                                        <td>{{ $item['XLOEK'] }}</td>
                                        <td>{{ $item['XWAOK'] }}</td>
                                        <td>{{ $item['KZEAR'] }}</td>
                                        <td>{{ $item['BDTER'] }}</td>
                                        <td>{{ $item['WERKS'] }}</td>
                                        <td>{{ $item['LGORT'] }}</td>
                                        <td>{{ $item['USNAM'] }}</td>
                                        <td>{{ $item['USUARIO'] }}</td>
                                        <td>{{ $item['DATA'] }}</td>
                                        <td>{{ $item['HORA'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <br>
                @if (count($dados) > 0)
                    <button type="submit" class="btn btn-success">MIGRAR A RESERVA</button>
                @endif

                
            </div>
        </form>
    </div>

    <script src="{{ asset('vendors/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>

    <script>

    </script>
</body>
</html>
