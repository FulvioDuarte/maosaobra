<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambasa • Login</title>

    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f2a44, #1e3a5f);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 14px;
            padding: 32px 28px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.25);
        }

        .login-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .login-header img {
            height: 70px;
            margin-bottom: 16px;
        }

        .login-header h1 {
            font-size: 20px;
            font-weight: 700;
            color: #0f2a44;
            margin-bottom: 4px;
        }

        .login-header span {
            font-size: 14px;
            color: #6b7280;
        }

        .form-control-user {
            height: 54px;
            font-size: 16px;
            border-radius: 10px;
            padding-left: 16px;
        }

        .btn-login {
            height: 54px;
            font-size: 18px;
            font-weight: 700;
            border-radius: 10px;
            background: #2563eb;
            border: none;
            color: #ffffff;
        }

        .btn-login:hover {
            background: #1d4ed8;
        }

        .mensagem-erro {
            color: #dc2626;
            font-weight: 600;
            margin-top: 12px;
            text-align: center;
        }

        .login-footer {
            margin-top: 20px;
            font-size: 13px;
            color: #374151;
            text-align: center;
        }

        /* AJUSTES PARA COLETOR / MOBILE */
      @media (max-width: 576px) {
        body {
            background: #ffffff;
        }

    .login-container {
        box-shadow: none;
        border-radius: 0;
        height: 100vh;
        padding: 28px 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .login-header {
        margin-bottom: 20px;
    }

    .login-header img {
        height: 64px;
        margin-bottom: 12px;
    }

    .login-header h1 {
        font-size: 18px;
    }

    .login-header span {
        font-size: 13px;
    }

    .form-control-user {
        height: 48px;
        font-size: 15px;
        border-radius: 8px;
    }

    .btn-login {
        height: 48px;
        font-size: 16px;
        border-radius: 8px;
    }

    .login-footer {
        font-size: 12px;
        margin-top: 16px;
    }
}

    </style>
</head>

<body>

    <div class="login-container">

        <div class="login-header">
            <img src="{{ asset('/imgs/tambasalogo.png') }}" alt="Tambasa">
            <h1>MODELO</h1>
            <span>Acesso Corporativo</span>
        </div>

        <form method="POST" class="user">
            @csrf

            <div class="form-group">
                <input type="text"
                       class="form-control form-control-user"
                       id="login"
                       name="login"
                       placeholder="Usuário"
                       required>
            </div>

            <div class="form-group">
                <input type="password"
                       class="form-control form-control-user"
                       id="senha"
                       name="senha"
                       placeholder="Senha"
                       required>
            </div>

            <button type="submit" class="btn btn-login btn-block">
                Entrar
            </button>

        </form>

        @if(session('mensagem'))
            <div class="mensagem-erro">
                {{ session('mensagem') }}
            </div>
        @endif

        <div class="login-footer">
            Utilize suas credenciais do corporativo
        </div>

    </div>

</body>
</html>
