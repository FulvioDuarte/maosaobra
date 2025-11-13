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
            <input type="hidden" name="numero_pedido" value="{{ $dados[0]['numero'] }}">
            <div class="container">
                <h4 class="mb-3">📦 Reserva - {{ $dados[0]['numero'] }}</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Endereço</th>
                                <th>Material</th>
                                <th>Descrição</th>
                                <th>Reserva</th>
                                <th>Item</th>
                                <th>Qtde</th>
                                <th>Unid.</th>
                                <th>Unid.</th>
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

                            @foreach($dados as $index=>$dado)
                                <tr>
                                    <td>{{ $dado['codigorua'] }}</td>
                                    <td>{{ $dado['codigosap'] }}</td>
                                    <td>{{ $dado['descricao'] }}</td>
                                    <td>{{ $dado['numero'] }}</td>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $dado['qtde'] }}</td>
                                    <td>{{ $dado['unidade'] }}</td>
                                    <td>{{ $dado['unidade1'] }}</td>
                                    <td>{{ $dado['checklist'] }}</td>
                                    <td>{{ $dado['elm'] }}</td>
                                    <td>{{ $dado['aprov'] }}</td>
                                    <td>{{ $dado['concl'] }}</td>
                                    <td>{{ $dado['datanec'] }}</td>
                                    <td>{{ $dado['cen'] }}</td>
                                    <td>{{ $dado['dep'] }}</td>
                                    <td>{{ $dado['criado'] }}</td>
                                    <td>{{ $dado['aprovador'] }}</td>
                                    <td>{{ $dado['dataaprov'] }}</td>
                                    <td>{{ $dado['horaprov'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>

    <script src="{{ asset('vendors/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>

    <script>

    </script>
</body>
</html>
