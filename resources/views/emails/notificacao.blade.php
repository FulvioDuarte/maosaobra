<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            background-color: #f2f2f2;
            padding: 10px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 8px 12px;
            border: 1px solid #cccccc;
            text-align: left;
        }

        th {
            background-color: #eeeeee;
        }

        .barcode {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Aqui está seu Pedido #{{ $dados['numeropedido'] }}</h2>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Descrição</th>
                <th>Rua</th>
                <th>Quantidade</th>
                <th>Código de Barras</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dados['itens'] as $item)
                <tr>
                    <td>{{ $item['codigo'] }}</td>
                    <td>{{ $item['descricao'] }}</td>
                    <td>{{ $item['rua'] }}</td>
                    <td>{{ $item['qtde'] }}</td>
                    <td class="barcode">
                        <img src="data:image/png;base64,{{ base64_encode((new \Picqer\Barcode\BarcodeGeneratorPNG())->getBarcode($item['codigo'], \Picqer\Barcode\BarcodeGeneratorPNG::TYPE_CODE_128)) }}">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
