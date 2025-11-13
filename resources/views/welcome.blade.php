<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambasa - Login</title>

    <!-- Fonts e CSS -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: rgb(212, 230, 249);
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            margin-top: 10vh;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 576px) {
            .login-container {
                margin-top: 5vh;
                padding: 20px;
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="text-center">
            <h1 class="h5 text-gray-900 mb-4"><strong>Almoxarifado Tambasa</strong></h1>
        </div>
        <form method="POST" class="user">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control form-control-user" id="login" name="login" placeholder="Login" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control form-control-user" id="senha" name="senha" placeholder="Senha" required>
            </div>
            <input type="submit" value="Login" class="btn btn-primary btn-user btn-block">
            <hr>
        </form>
        <div class="text-center">
            <font color="red">{{ session('mensagem') }}</font>
        </div>
        <div class="text-center mt-2">
            <span style="color: black;">Acesso com as credenciais do Corporativo</span>
        </div>
    </div>
</body>

</html>
