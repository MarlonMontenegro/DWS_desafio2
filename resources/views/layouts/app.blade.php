<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Finanzas</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
  <main class="container">
    <nav>
      <ul><li><strong>Finanzas</strong></li></ul>
      <ul>
        <li><a href="{{ route('entradas.index') }}">Entradas</a></li>
        <li><a href="{{ route('salidas.index') }}">Salidas</a></li>
      </ul>
    </nav>
    @if(session('success')) <article class="success">{{ session('success') }}</article> @endif
    @yield('content')
  </main>
</body>
</html>
