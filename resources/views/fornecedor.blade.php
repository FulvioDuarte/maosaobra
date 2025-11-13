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
                <span class="h5 mb-0">Gestão de Compras Consumo - FORNECEDORES</span>
            </div>

            <!-- Formulário de filtros -->
            <form action="pesquisafornecedor" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="pesquisarnome" value="{{ request('pesquisarnome') }}" placeholder="Pesquisar fornecedor">

                    <select class="form-control mx-1" name="filtroramos">
                        <option value="">Pesquisar Ramo</option>
                        @foreach ($ramos as $ramo)
                            <option value="{{ $ramo->id }}" {{ request('filtroramos') == $ramo->id ? 'selected' : '' }}>
                                {{ $ramo->descricao }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-info mx-1">🔍</button>
                </div>
            </form>

            @if (session('msg'))
                <div id="mensagem" style=" background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0;transition: opacity 1s ease;">
                    {{ session('msg') }}
                </div>
            @endif

            <a href="{{ route('criafornecedor') }}" class="btn btn-success btn">➕ Criar Fornecedor</a>
            
            <div class="table-responsive">
                <div class="p-2 mb-1" style="background: #fff; border: 1px solid #dee2e6; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>Contato</th>
                                <th>Email</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($fornecedores as $fornecedor)
                                <tr>
                                    <td>{{ $fornecedor->id }}</td>
                                    <td>{{ $fornecedor->nome }}</td>
                                    <td>
                                        {{ $fornecedor->telefone1 }} 
                                        @if (!empty($fornecedor->telefone2))
                                            / {{ $fornecedor->telefone2 }}
                                        @endif
                                    </td>
                                    <td>{{ $fornecedor->contato }}</td>
                                    <td>{{ $fornecedor->email }}</td>
                                    <td>
                                        <!-- Editar -->
                                        <form method="POST" action="{{ route('editafornecedor') }}" style="display: inline;">
                                        @csrf
                                            <input type="hidden" name="fornecedor_id" value="{{ $fornecedor->id }}">
                                            <span onclick="this.closest('form').submit()" style="cursor: pointer; margin: 0 10px" title="Editar fornecedor">✏️</span>
                                        </form>

                                        <!-- Excluir -->
                                        <form method="POST" action="{{ ('excluifornecedor') }}" style="display: inline;" onsubmit="return false;">
                                        @csrf
                                        <input type="hidden" name="fornecedor_id" value="{{ $fornecedor->id }}">
                                            <span onclick="confirmarExclusao(this)" style="cursor: pointer; margin: 0 10px" title="Excluir fornecedor">🗑️</span>
                                        </form>      
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-success">Nenhum fornecedor cadastrado</td>
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
                text: "Esta ação excluirá o fornecedor!",
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
