<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Gestão de Obras • Financeiro</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background:#f4f6f8; font-family: 'Segoe UI', sans-serif; }

/* SIDEBAR DESKTOP */
.sidebar {
    background:#1f2933;
    width:240px;
    min-height:100vh;
    color:#fff;
    position: fixed;
    top:0;
    left:0;
    padding-top:20px;
}
.sidebar h4 { padding:0 20px 20px; border-bottom:1px solid #2f3b47; }
.sidebar a {
    color:#cfd8dc; display:block; padding:12px 20px; text-decoration:none;
}
.sidebar a:hover { background:#2f3b47; color:#fff; }

/* CONTEUDO */
main {
    margin-left:240px;
}

/* TIMELINE */
.timeline { position: relative; margin-left: 20px; }
.timeline::before { content:''; position:absolute; left:18px; top:0; bottom:0; width:4px; background:#dee2e6; }
.timeline-item { position:relative; margin-bottom:30px; padding-left:60px; }
.timeline-item::before { content:''; position:absolute; left:8px; top:15px; width:24px; height:24px; background:#0d6efd; border-radius:50%; }
.card-financeiro { border-left:5px solid #0d6efd; }
.valor-principal { font-size:1.5rem; font-weight:600; }
.pago { color:#198754; font-weight:600; }
.nao-pago { color:#dc3545; font-weight:600; }

/* MOBILE */
#menuToggle{
    position: fixed;
    top:8px;
    left:8px;
    z-index:1100;
    width:44px;
    height:44px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#1f2933;
    color:#fff;
    border:none;
    box-shadow:0 4px 10px rgba(0,0,0,0.25);
}
#menuToggle.hide{ display:none; }
#menuToggle:hover{ background:#2f3b47; }
#menuToggle:hover{ background:#2f3b47; }

@media(max-width:768px){
    .sidebar{
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        z-index:1050;
    }
    .sidebar.active{ transform: translateX(0); }
    main{ margin-left:0; padding-top:60px !important; }
}
</style>
</head>
<body>
<div class="container-fluid">
<div class="row">
    <!-- MENU LATERAL -->
    <nav class="sidebar" id="sidebar">
    <h4>Obra Alpha</h4>
    <a href="#"><i class="bi bi-cash-stack"></i> Financeiro</a>
    <a href="#"><i class="bi bi-people"></i> Participantes</a>
    <a href="#"><i class="bi bi-file-earmark-text"></i> Relatórios</a>
    <a href="#"><i class="bi bi-gear"></i> Configurações</a>
</nav>

    <!-- CONTEÚDO -->
    <button class="btn btn-outline-secondary d-md-none position-fixed" id="menuToggle" style="top:12px; left:12px; z-index:1100;"><i class="bi bi-list"></i></button>
    <main style="padding-top:80px;" style="padding-top:20px;" class="col-md-9 col-lg-10 p-4">
        <h2 class="mb-4">Demonstrativo Financeiro</h2>

        <div class="timeline">
            <!-- MÊS -->
            <div class="timeline-item">
                <div class="card card-financeiro shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>Janeiro / 2026</h5>
                            <span class="pago"><i class="bi bi-check-circle"></i> Pago</span>
                        </div>
                        <hr>
                        <div class="valor-principal mb-3">Boleto: R$ 8.000,00</div>
                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Pessoa</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>Pessoa 01</td><td>R$ 1.000,00</td><td class="pago">Pago</td></tr>
                                    <tr><td>Pessoa 02</td><td>R$ 1.000,00</td><td class="pago">Pago</td></tr>
                                    <tr><td>Pessoa 03</td><td>R$ 1.000,00</td><td class="pago">Pago</td></tr>
                                    <tr><td>Pessoa 04</td><td>R$ 1.000,00</td><td class="pago">Pago</td></tr>
                                    <tr><td>Pessoa 05</td><td>R$ 1.000,00</td><td class="pago">Pago</td></tr>
                                    <tr><td>Pessoa 06</td><td>R$ 1.000,00</td><td class="pago">Pago</td></tr>
                                    <tr><td>Pessoa 07</td><td>R$ 1.000,00</td><td class="pago">Pago</td></tr>
                                    <tr><td>Pessoa 08</td><td>R$ 1.000,00</td><td class="pago">Pago</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- OUTRO MÊS -->
            <div class="timeline-item">
                <div class="card card-financeiro shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>Fevereiro / 2026</h5>
                            <span class="nao-pago"><i class="bi bi-exclamation-circle"></i> Em aberto</span>
                        </div>
                        <hr>
                        <div class="valor-principal mb-3">Boleto: R$ 7.600,00</div>
                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Pessoa</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>Pessoa 01</td><td>R$ 950,00</td><td class="nao-pago">Pendente</td></tr>
                                    <tr><td>Pessoa 02</td><td>R$ 950,00</td><td class="nao-pago">Pendente</td></tr>
                                    <tr><td>Pessoa 03</td><td>R$ 950,00</td><td class="nao-pago">Pendente</td></tr>
                                    <tr><td>Pessoa 04</td><td>R$ 950,00</td><td class="nao-pago">Pendente</td></tr>
                                    <tr><td>Pessoa 05</td><td>R$ 950,00</td><td class="nao-pago">Pendente</td></tr>
                                    <tr><td>Pessoa 06</td><td>R$ 950,00</td><td class="nao-pago">Pendente</td></tr>
                                    <tr><td>Pessoa 07</td><td>R$ 950,00</td><td class="nao-pago">Pendente</td></tr>
                                    <tr><td>Pessoa 08</td><td>R$ 950,00</td><td class="nao-pago">Pendente</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</div>
<script>
const toggle = document.getElementById('menuToggle');
const sidebar = document.getElementById('sidebar');
const toggleBtn = document.getElementById('menuToggle');

toggle?.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    toggleBtn.classList.toggle('hide');
});
</script>
</body>
</html>
