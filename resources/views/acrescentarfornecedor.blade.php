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
                <span class="h5 mb-0">Gestão de Compras Consumo - ACRESCENTAR FORNECEDOR - Pedido #{{ $pedido->numero_pedido }}</span>
            </div>

            @if (session('msg'))
                <div id="mensagem" style=" background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center; margin: 10px 0;transition: opacity 1s ease;">
                    {{ session('msg') }}
                </div>
            @endif

            <div class="p-1 mb-1" style="background: #fff; border: 1px solid #dee2e6; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <form method="POST" action="{{ route('gravarcotacaofornec') }}" style="display: inline;">
                @csrf
                    <input type="hidden" name="pedido_id" value="{{ $pedido->id }}">
                    <div class="table-responsive">
                        <table class="table w-100">
                            <thead>
                                <tr>
                                    <th>Opção</th>
                                    <th onclick="sortTable(1)" style="cursor:pointer;">Fornecedor ▲▼</th>
                                    <th>Telefone</th>
                                    <th>Contato</th>
                                    <th onclick="sortTable(4)" style="cursor:pointer;">Ramo ▲▼</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($fornecedores as $fornecedor)
                                    <tr>
                                        <td><input type="checkbox" name="fornecedores[]" value="{{ $fornecedor->id }}" class="chk-fornecedor"></td>
                                        <td>{{ $fornecedor->nome }}</td>
                                        <td>
                                            {{ $fornecedor->telefone1 }} 
                                            @if (!empty($fornecedor->telefone2))
                                                / {{ $fornecedor->telefone2 }}
                                            @endif
                                        </td>
                                        <td>{{ $fornecedor->contato }}</td>
                                        <td>{{ $fornecedor->descricao }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-success">Nenhum fornecedor cadastrado</td>
                                    </tr>   
                                @endforelse 
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" id="btnSalvar" class="btn btn-success mx-1" disabled>Salvar</button>    
                </form>
            </div>

            <br>
            <br>
            <a href="{{ route('visualizacotacaofornec', ['pedido_id'=>$pedido->id]) }}">⬅️ Voltar</a>
        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Alternar sidebar
            document.getElementById('toggleSidebar')?.addEventListener('click', function () {
                document.getElementById('sidebar')?.classList.toggle('hidden');
            });
        });

        function sortTable(colIndex) {
            const table = document.querySelector("table");
            let rows = Array.from(table.rows).slice(1); // ignora cabeçalho
            let asc = table.getAttribute("data-sort-dir") !== "asc"; // alterna asc/desc
            rows.sort((a, b) => {
                let cellA = a.cells[colIndex].innerText.trim().toLowerCase();
                let cellB = b.cells[colIndex].innerText.trim().toLowerCase();
                return asc ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
            });
            rows.forEach(row => table.tBodies[0].appendChild(row));
            table.setAttribute("data-sort-dir", asc ? "asc" : "desc");
        }

        // Pega todos os checkboxes e o botão
        const checkboxes = document.querySelectorAll('.chk-fornecedor');
        const btnSalvar = document.getElementById('btnSalvar');

        // Função para verificar se algum está marcado
        function verificarCheckbox() {
            const algumMarcado = Array.from(checkboxes).some(chk => chk.checked);
            btnSalvar.disabled = !algumMarcado;
        }

        // Adiciona o evento em cada checkbox
        checkboxes.forEach(chk => {
            chk.addEventListener('change', verificarCheckbox);
        });

    </script>
</body>
</html>
