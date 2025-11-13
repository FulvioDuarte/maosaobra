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
                <span class="h5 mb-0">Gestão de Compras Consumo - RAMOS</span>
            </div>

            <!-- Formulário de filtros -->
            <form action="pesquisaramo" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="pesquisarnome" value="{{ request('pesquisarnome') }}" placeholder="pesquisar ramo">
                    <button type="submit" class="btn btn-info mx-1">🔍</button>
                </div>
            </form>
            
            @if (session('msg'))
                <div id="mensagem" style=" background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0;transition: opacity 1s ease;">
                    {{ session('msg') }}
                </div>
            @endif

            <a href="{{ route('criaramo') }}" class="btn btn-success btn">➕ Criar Ramo</a>

            <div class="table-responsive">
                <div class="p-1 mb-1" style="background: #fff; border: 1px solid #dee2e6; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descrição</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ramos as $ramo)
                                <tr>
                                    <td>{{ $ramo->id }}</td>
                                    <td>{{ $ramo->descricao }}</td>
                                    <td>
                                        <!-- Editar -->
                                        <form method="POST" action="{{ route('editaramo') }}" style="display: inline;">
                                        @csrf
                                            <input type="hidden" name="ramo_id" value="{{ $ramo->id }}">
                                            <span onclick="this.closest('form').submit()" style="cursor: pointer; margin: 0 10px" title="Editar ramo">✏️</span>
                                        </form>

                                        <!-- Excluir -->
                                        <form method="POST" action="{{ route('excluiramo') }}" style="display: inline;" onsubmit="return false;">
                                        @csrf
                                        <input type="hidden" name="ramo_id" value="{{ $ramo->id }}">
                                            <span onclick="confirmarExclusao(this)" style="cursor: pointer; margin: 0 10px" title="Excluir ramo">🗑️</span>
                                        </form>      
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-success">Nenhum ramo cadastrado</td>
                                </tr>   
                            @endforelse 
                        </tbody>
                    </table>
                </div>
            </div>
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
                text: "Esta ação excluirá o ramo!",
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
