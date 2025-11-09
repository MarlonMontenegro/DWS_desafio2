<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Finanzas')</title>
  <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">

  @vite(['resources/css/app.css','resources/js/app.js'])
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #0f172a;
      color: #f1f5f9; /* texto más claro */
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
    }

    .navbar {
      background: linear-gradient(90deg, #4b6cb7 0%, #0f172a 60%, #111827 100%);
    }

    .navbar-brand { font-weight: 600; }

    .layout-wrapper {
      display: flex;
      min-height: calc(100vh - 56px);
    }

    .sidebar {
      width: 230px;
      background-color: #020817;
      border-right: 1px solid #111827;
      padding: 1.5rem 1rem;
      display: flex;             /* para llevar el botón al fondo */
      flex-direction: column;
    }

    .sidebar-title {
      font-size: .8rem;
      text-transform: uppercase;
      letter-spacing: .12em;
      color: #9ca3af;
      margin-bottom: .75rem;
    }

    .nav-link-custom {
      display: flex;
      align-items: center;
      gap: .5rem;
      padding: .55rem .85rem;
      border-radius: .75rem;
      margin-bottom: .25rem;
      color: #cbd5e1;
      text-decoration: none;
      font-size: .9rem;
      border: 1px solid transparent;
    }

    .nav-link-custom:hover,
    .nav-link-custom.active {
      background: linear-gradient(90deg, rgba(79,70,229,.22), rgba(56,189,248,.14));
      color: #fff;
      border-color: #1e2a44;
    }

    .nav-link-custom i {
      font-size: 1rem;
      color: #60a5fa;
    }

    .content { flex: 1; padding: 1.75rem 2rem; }

    .card {
      background-color: #1e293b;
      border: 1px solid #334155;
      border-radius: 1rem;
      color: #f8fafc;
    }

    .table { color: #f8fafc; }
    .table thead { background-color: #111827; }
    .table tbody tr:nth-child(even) { background-color: #1e293b; }

    footer {
      border-top: 1px solid #111827;
      padding: .75rem;
      font-size: .75rem;
      text-align: center;
      color: #9ca3af;
      background-color: #020817;
    }

    .alert { border-radius: .75rem; }

    .user-info { color: #e2e8f0; font-weight: 500; }

    /* botón logout del sidebar */
    .sidebar form button { transition: all .2s ease; }
    .sidebar form button:hover { background-color: #1e293b; border-color: #1e293b; }
  </style>

  @yield('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark px-3">
  <a class="navbar-brand" href="{{ route('entradas.index') }}">
    <i class="bi bi-pie-chart-fill me-1"></i> Finanzas
  </a>

  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav"
          aria-controls="topNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="topNav">
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
      @auth
        <li class="nav-item me-3 user-info">
          <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name ?? Auth::user()->email }}
        </li>
      @endauth

      @guest
        <li class="nav-item">
          <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">
            <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar sesión
          </a>
        </li>
      @endguest
    </ul>
  </div>
</nav>

<div class="layout-wrapper">
  {{-- Sidebar --}}
  <aside class="sidebar d-none d-md-flex">
    <div>
      <div class="sidebar-title">Navegación</div>

      <a href="{{ route('entradas.index') }}"
         class="nav-link-custom {{ request()->routeIs('entradas.*') ? 'active' : '' }}">
        <i class="bi bi-clipboard2-data"></i><span>Entradas</span>
      </a>

      <a href="{{ route('salidas.index') }}"
         class="nav-link-custom {{ request()->routeIs('salidas.*') ? 'active' : '' }}">
        <i class="bi bi-cash-stack"></i><span>Salidas</span>
      </a>

      @if(Route::has('balance.index'))
        <a href="{{ route('balance.index') }}"
           class="nav-link-custom {{ request()->routeIs('balance.*') ? 'active' : '' }}">
          <i class="bi bi-bar-chart-line"></i><span>Balance</span>
        </a>
      @endif
    </div>

    {{-- Footer del sidebar con usuario + logout --}}
    @auth
    <div class="mt-auto pt-3 border-top border-secondary text-center">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-sm btn-outline-light w-100 d-flex align-items-center justify-content-center gap-2 mt-2">
          <i class="bi bi-box-arrow-right"></i>
          <span>Cerrar sesión</span>
        </button>
      </form>
    </div>
    @endauth
  </aside>

  {{-- Contenido principal --}}
  <main class="content">
    @if(session('success'))
      <div class="alert alert-success py-2 px-3 mb-3">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger py-2 px-3 mb-3">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </main>
</div>

<footer>
  © {{ date('Y') }} Finanzas — Desafío DWS
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
