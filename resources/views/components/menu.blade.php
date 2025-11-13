<div id="sidebar" class="d-none d-md-block p-3">
    <h4 class="text-white">Menu</h4>

    <ul class="nav flex-column">
        @if (Auth::user()->acesso_almox == 1 && Auth::user()->acesso_compras == 1)
            <li class="nav-item mb-2">
                <a href="{{ route('menuprincipal') }}" class="nav-link text-white">☰ Menu Principal</a>
            </li>
        @endif

        <li class="nav-item mb-2">
            <a href="{{ route('dashboard') }}" class="nav-link text-white">🛒 Dashboard</a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('cotacaoalmox') }}" class="nav-link text-white">🛒 Cotações</a>
        </li>

        <li class="nav-item mb-2">
            <!-- Botão para abrir submenu -->
            <a class="nav-link text-white" data-bs-toggle="collapse" href="#submenuCadastros" role="button" aria-expanded="false" aria-controls="submenuCadastros">
                ✍️ Cadastros
            </a>

            <!-- Submenu oculto -->
            <ul class="collapse ps-3" id="submenuCadastros">
                <li class="nav-item mb-1">
                    <a href="{{ route('ramos') }}" class="nav-link text-white">💅 Ramo</a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('fornecedor') }}" class="nav-link text-white">🚚 Fornecedor</a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('produtoalmox') }}" class="nav-link text-white">📦 Produtos</a>
                </li>
            </ul>
        </li>

        <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white">📄 Relatório</a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('welcome') }}" class="nav-link text-white">🔓 Sair</a>
        </li>
    </ul>

</div>

<script src="{{ asset('vendors/js/bootstrap/bundle.min.js') }}"></script>