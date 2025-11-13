<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: system-ui, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            width: 100%;
            padding: 1rem;
        }
        h2 {
            font-size: 2.8rem;
            margin-bottom: 2rem;
            text-align: center;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0.5rem;
        }
        .col-md-3 {
            width: 100%;
            padding: 0.5rem;
        }
        @media (min-width: 768px) {
            .col-md-3 {
                width: 20%;
            }
        }
        .card {
            border-radius: 0.8rem;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            background-color: white;
        }
        .card-body {
            padding: 1rem;
        }
        .card-title {
            margin-bottom: 0.5rem;
            font-weight: bold;
            font-size: 24px;
        }
        .card-text {
            font-size: 2rem;
            font-weight: bold;
        }
        .bg-primary { background-color: #0d6efd; color: white; }
        .bg-success { background-color: #198754; color: white; }
        .bg-warning { background-color: #ffc107; color: black; }
        .bg-danger { background-color: #dc3545; color: white; }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table thead {
            background-color: #f1f1f1;
        }
        .table th, .table td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            text-align: left;
        }
        .badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            border-radius: 0.25rem;
        }
        .bg-success { background-color: #198754 !important; color: #fff; }
        .bg-warning { background-color:rgb(250, 228, 169) !important; color: #212529; }
        .bg-danger { background-color: #dc3545 !important; color: #fff; }
        .bg-info { background-color:rgb(121, 129, 105) !important; color: #fff; }

        .card-usuario {
            background-color:rgb(130, 195, 248); /* cinza escuro */
            color: black;
            border-radius: 0.8rem;
            box-shadow: 0 2px 4px rgba(165, 144, 144, 0.15);
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            font-size: 1rem;
        }

        .card-usuario h5 {
            font-size: 24px;
            margin: 0;
            font-weight: 600;
        }

        .card-usuario p {
            font-size: 1.4rem;
            margin: 0;
            font-weight: bold;
        }

        .titulo-usuarios {
        margin: 3rem 0 1rem;
        font-size: 2rem;
        text-align: center;
        color: #333;
    }
        .col-user {
            width: 100%;
            padding: 0.5rem;
        }
        @media (min-width: 768px) {
            .col-user {
                width: 50%;
            }
        }
    </style>
       
</head>
<body>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-4">Painel de Controle
                <span style="font-size: 36px; color:#198754"> - {{ $pedidos['periodo'] }}</span>
                <div style="font-size: 12px;"> 
                    <a href="{{ route('configpainel', ['desc'=>'DIÁRIO']) }}" class="btn btn-primary">DIÁRIO</a>
                    <a href="{{ route('configpainel', ['desc'=>'SEMANAL']) }}" class="btn btn-primary"> SEMANAL</a>
                    <a href="{{ route('configpainel', ['desc'=>'MENSAL']) }}" class="btn btn-primary"> MENSAL</a>
                </div>
            </h2> 
        </div>

        <button onclick="window.close()" style="position: fixed; top: 10px; right: 10px; font-size: 20px;" title="Fechar Janela">x</button>
        
        <!-- Cards -->
        <div class="row mb-5">
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-warning h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total Pedidos </h5>
                        <p id="output-total" class="card-text fs-4">{{ $pedidos['total'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-success h-100">
                    <div class="card-body">
                        <h5 class="card-title">Novos</h5>
                        <p id="output-novos" class="card-text fs-4">{{ $pedidos['novos'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-info h-100">
                    <div class="card-body">
                        <h5 class="card-title">Não Associados</h5>
                        <p id="output-semassoc" class="card-text fs-4">{{ $pedidos['semassoc'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-danger h-100">
                    <div class="card-body">
                        <h5 class="card-title">Em Separação</h5>
                        <p id="output-separando" class="card-text fs-4">{{ $pedidos['separando'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title">Finalizados</h5>
                        <p id="output-finalizados" class="card-text fs-4">{{ $pedidos['finalizados'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <h2 class="mb-4">Pedidos por Usuário</h2>

        <div class="row row-user" id="row-usuarios">
            @forelse ($userAssociados as $usuario)
                <div class="col-user" id="card-user-{{ $usuario['user_associado'] }}">
                    <div class="card-usuario">
                        <h5 id="output-usernome-{{ $usuario['user_associado'] }}" class="card-title">{{ $usuario['name'] }}</h5>
                        <p id="output-usertotal-{{ $usuario['user_associado'] }}" class="card-text fs-4">Pedidos: {{ $usuario['total'] }}</p>
                    </div>
                </div>
            @empty
            @endforelse
        </div>

         
    </div>
</body>

    <script src="{{ asset('js/pusher.min.js') }}"></script>
    <script src="{{ asset('js/echo.iife.js') }}"></script>

    <script>
        // Requerido para Echo funcionar
        window.Pusher = Pusher;

        window.Echo = new Echo.default({
            broadcaster: 'pusher',
            key: 'localkey',
            //wsHost: '192.168.19.34',
            wsHost: window.location.hostname,
            wsPort: 6001,
            forceTLS: false,    
            disableStats: false,
            encrypted: false  
        });

        window.Echo.channel('canal-pedidos')
            .listen('.evento-pedidos', (e) => {
                document.getElementById('output-total').innerText = e.total;
                document.getElementById('output-novos').innerText = e.novos;
                document.getElementById('output-separando').innerText = e.separando;
                document.getElementById('output-finalizados').innerText = e.finalizados;
                document.getElementById('output-semassoc').innerText = e.semassoc;
            })
            .listen('.evento-userAssociado', (e) => {
                const container = document.getElementById('row-usuarios');


            // Remove todos os cards de usuário (aqueles que começam com 'card-user-')
            document.querySelectorAll('[id^="card-user-"]').forEach(card => {
                card.remove();
            });

            // Recria todos os cards recebidos no evento
            e.forEach((u) => {
                const userId = u.user_associado;

                // Verifica se o card já existe
                let card = document.getElementById(`card-user-${userId}`);

                if (!card) {
                    // Cria o card
                    card = document.createElement('div');
                    card.className = 'col-user';
                    card.id = `card-user-${userId}`;
                    card.innerHTML = `
                        <div class="card text-white bg-primary h-100">
                            <div class="card-usuario">
                                <h5 id="output-usernome-${userId}" class="card-title">${u.name}</h5>
                                <p id="output-usertotal-${userId}" class="card-text fs-4">associado: ${u.total}</p>
                            </div>
                        </div>
                    `;
                    container.appendChild(card);
                } else {
                    // Atualiza os dados
                    document.getElementById(`output-usernome-${userId}`).innerText = u.name;
                    document.getElementById(`output-usertotal-${userId}`).innerText = u.total;
                }
            });
        });
    </script>

</html>
