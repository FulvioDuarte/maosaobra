<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Ícones Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fc;
      font-family: 'Segoe UI', sans-serif;
    }

    /* Sidebar */
    .sidebar {
      height: 100vh;
      background-color: #1e1e2d;
      color: #fff;
      position: fixed;
      width: 230px;
      padding-top: 20px;
    }

    .sidebar a {
      color: #cfcfe0;
      text-decoration: none;
      display: block;
      padding: 10px 20px;
      transition: all 0.3s;
    }

    .sidebar a:hover, .sidebar a.active {
      background-color: #2f2f45;
      color: #fff;
    }

    .main-content {
      margin-left: 230px;
      padding: 30px;
    }

    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .card-icon {
      font-size: 2rem;
      color: #fff;
      border-radius: 0.75rem;
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
    }

    .btn-manage {
      background-color: #e7f1ff;
      color: #0d6efd;
      border: none;
    }

    .btn-manage:hover {
      background-color: #d0e4ff;
    }
  </style>
</head>

<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h5 class="text-center mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h5>
    <a href="#" class="active"><i class="bi bi-house-door me-2"></i> Dashboard</a>
    <a href="#"><i class="bi bi-box me-2"></i> Base</a>
    <a href="#"><i class="bi bi-layout-sidebar me-2"></i> Sidebar Layouts</a>
    <a href="#"><i class="bi bi-ui-checks me-2"></i> Forms</a>
  </div>

  <!-- Conteúdo principal -->
  <div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3>Dashboard</h3>
        <p class="text-muted">Free Bootstrap 5 Admin Dashboard</p>
      </div>
      <div>
        <button class="btn btn-manage me-2">Manage</button>
        <button class="btn btn-primary">Add Customer</button>
      </div>
    </div>

    <div class="row g-4">
      <!-- Visitors -->
      <div class="col-md-3">
        <div class="card p-3 d-flex flex-row align-items-center">
          <div class="card-icon bg-primary">
            <i class="bi bi-people"></i>
          </div>
          <div>
            <p class="mb-0 text-muted">Visitors</p>
            <h5 class="mb-0 fw-bold">1,294</h5>
          </div>
        </div>
      </div>

      <!-- Subscribers -->
      <div class="col-md-3">
        <div class="card p-3 d-flex flex-row align-items-center">
          <div class="card-icon bg-info">
            <i class="bi bi-person-check"></i>
          </div>
          <div>
            <p class="mb-0 text-muted">Subscribers</p>
            <h5 class="mb-0 fw-bold">1,303</h5>
          </div>
        </div>
      </div>

      <!-- Sales -->
      <div class="col-md-3">
        <div class="card p-3 d-flex flex-row align-items-center">
          <div class="card-icon bg-success">
            <i class="bi bi-bag-check"></i>
          </div>
          <div>
            <p class="mb-0 text-muted">Sales</p>
            <h5 class="mb-0 fw-bold">$1,345</h5>
          </div>
        </div>
      </div>

      <!-- Orders -->
      <div class="col-md-3">
        <div class="card p-3 d-flex flex-row align-items-center">
          <div class="card-icon bg-purple" style="background-color: #6f42c1;">
            <i class="bi bi-check-circle"></i>
          </div>
          <div>
            <p class="mb-0 text-muted">Order</p>
            <h5 class="mb-0 fw-bold">576</h5>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
