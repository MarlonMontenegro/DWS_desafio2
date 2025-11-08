<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Finanzas')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #0f172a;
            color: #e5e7eb;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .navbar {
            background: linear-gradient(90deg, #4b6cb7 0%, #0f172a 60%, #111827 100%);
        }

        .navbar-brand {
            font-weight: 600;
        }

        .layout-wrapper {
            display: flex;
            min-height: calc(100vh - 56px);
        }

        .sidebar {
            width: 230px;
            background-color: #020817;
            border-right: 1px solid #111827;
            padding: 1.5rem 1rem;
        }

        .sidebar-title {
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: #6b7280;
            margin-bottom: .75rem;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: .5rem;
            padding: .55rem .85rem;
            border-radius: .75rem;
            margin-bottom: .25rem;
            color: #9ca3af;
            text-decoration: none;
            font-size: .9rem;
        }

        .nav-link-custom span.icon {
            font-size: 1.1rem;
        }

        .nav-link-custom.active,
        .nav-link-custom:hover {
            background: linear-gradient(90deg, rgba(79,70,229,.22), rgba(56,189,248,.14));
            color: #e5e7eb;
        }

        .content {
            flex: 1;
            padding: 1.75rem 2rem;
        }

        .card {
            background-color: #020817;
            border: 1px solid #111827;
            border-radius: 1rem;
        }

        .table {
            color: #e5e7eb;
        }

        .table thead {
            background-color: #111827;
        }

        .table tbody tr:nth-child(even) {
            background-color: #020817;
        }

        footer {
            border-top: 1px solid #111827;
            padding: .75rem;
            font-size: .75rem;
            text-align: center;
            color: #6b7280;
            background-color: #020817;
        }

        .alert {
            border-radius: .75rem;
        }
    </style>

    @yield('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark px-3">
    <a class="navbar-brand" href="{{ route('entradas.index') }}">
         Finanzas
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav"
            aria-controls="topNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="topNav">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
            @if(session()->has('user'))
                <li class="nav-item me-2">
                    <span class="text-light small">
                        Sesión: <strong>{{ session('user.email') }}</strong>
                    </span>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-light">
                        Cerrar sesión
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>

<div class="layout-wrapper">
    {{-- Sidebar --}}
    <aside class="sidebar d-none d-md-block">
        <div class="sidebar-title">Navegación</div>

        <a href="{{ route('entradas.index') }}"
           class="nav-link-custom {{ request()->routeIs('entradas.*') ? 'active' : '' }}">
            <span class="icon">📥</span>
            <span>Entradas</span>
        </a>

        <a href="{{ route('salidas.index') }}"
           class="nav-link-custom {{ request()->routeIs('salidas.*') ? 'active' : '' }}">
            <span class="icon">📤</span>
            <span>Salidas</span>
        </a>

        @if(Route::has('balance.index'))
            <a href="{{ route('balance.index') }}"
               class="nav-link-custom {{ request()->routeIs('balance.*') ? 'active' : '' }}">
                <span class="icon"></span>
                <span>Balance</span>
            </a>
        @endif
    </aside>

    {{-- Contenido principal --}}
    <main class="content">
        {{-- Mensajes de éxito --}}
        @if(session('success'))
            <div class="alert alert-success py-2 px-3 mb-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- Errores generales (sin tocar el mensaje específico de login) --}}
        @if($errors->any())
            @php
                $nonLoginErrors = $errors->all();
            @endphp
            @if(count($nonLoginErrors) > 0)
                <div class="alert alert-danger py-2 px-3 mb-3">
                    <ul class="mb-0">
                        @foreach($nonLoginErrors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
