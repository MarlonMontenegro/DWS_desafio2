<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Reporte de Balance</title>
  <style>
    body{font-family: DejaVu Sans, Arial, sans-serif; font-size:12px}
    table{width:100%; border-collapse:collapse; margin-bottom:14px}
    th,td{border:1px solid #ccc; padding:6px; text-align:left}
    h2,h3{margin:6px 0}
  </style>
</head>
<body>
  <h2>Reporte de Balance @if($from || $to) ({{ $from ?? 'inicio' }} → {{ $to ?? 'hoy' }}) @endif</h2>
  <p><strong>Total Entradas:</strong> ${{ number_format($totalEntradas,2) }} |
     <strong>Total Salidas:</strong> ${{ number_format($totalSalidas,2) }} |
     <strong>Balance:</strong> ${{ number_format($balance,2) }}</p>

  <h3>Entradas</h3>
  <table>
    <thead><tr><th>Tipo</th><th>Monto</th><th>Fecha</th></tr></thead>
    <tbody>
      @forelse($entradas as $e)
        <tr><td>{{ $e->tipo_entrada }}</td><td>${{ number_format($e->monto,2) }}</td><td>{{ $e->fecha }}</td></tr>
      @empty <tr><td colspan="3">Sin entradas</td></tr> @endforelse
    </tbody>
  </table>

  <h3>Salidas</h3>
  <table>
    <thead><tr><th>Tipo</th><th>Monto</th><th>Fecha</th></tr></thead>
    <tbody>
      @forelse($salidas as $s)
        <tr><td>{{ $s->tipo_salida }}</td><td>${{ number_format($s->monto,2) }}</td><td>{{ $s->fecha }}</td></tr>
      @empty <tr><td colspan="3">Sin salidas</td></tr> @endforelse
    </tbody>
  </table>
</body>
</html>
