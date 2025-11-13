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
            <a href="{{ route('pedidoassociar') }}">⬅️ Voltar</a>
        </div>

        <form action="pedidorelatorio" method="POST">
            @csrf
            <div class="d-flex justify-content-end mr-2">
                <div class="mr-2">
                    <input type="date" class="form-control" value="{{ request('datainicio') }}" name="datainicio" style="color: black;" required>
                </div>
                <div class="mr-2">
                    <input type="date" class="form-control" value="{{ request('datafim') }}" name="datafim" style="color: black;" required>
                </div>
                <button type="submit" class="btn btn-info">🔍</button>
            </div>
        </form>

        <form method="POST" action="{{ route('gravarassociacao') }}">
            @csrf
            <div class="table-responsive">
                <table class="table w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Novos</th>
                            <th>Pendentes</th>
                            <th>Finalizados</th>
                            <th>Total Reservas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $dado)
                            <tr>
                                <td style="color: black">{{ $dado['id'] }}</td>
                                <td style="color: black">{{ $dado['usuario'] }}</td>
                                <td style="color: black">{{ $dado['novos'] }}</td>
                                <td style="color: black">{{ $dado['pendentes'] }}</td>
                                <td style="color: black">{{ $dado['finalizados'] }}</td>
                                <td style="color: black">{{ $dado['novos'] + $dado['pendentes'] + $dado['finalizados'] }}</td>
                            </tr> 
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

</body>
</html>
