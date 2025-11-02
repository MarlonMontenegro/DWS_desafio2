@extends('layouts.app')

@section('content')
<h2>Reporte de Balance</h2>

<form method="get" action="{{ route('balance.index') }}" class="grid">
  <label>Desde
    <input type="date" name="from" value="{{ $from }}">
  </label>
  <label>Hasta
    <input type="date" name="to" value="{{ $to }}">
  </label>
  <button type="submit">Filtrar</button>
  <a href="{{ route('balance.index') }}">Limpiar</a>
  <a href="{{ route('balance.pdf', ['from'=>$from,'to'=>$to]) }}" target="_blank">Exportar PDF</a>
</form>

<article>
  <strong>Total Entradas:</strong> ${{ number_format($totalEntradas,2) }}<br>
  <strong>Total Salidas:</strong> ${{ number_format($totalSalidas,2) }}<br>
  <strong>Balance:</strong> ${{ number_format($balance,2) }}
</article>

<h3>Gráfico Entradas vs Salidas</h3>
<canvas id="pie" width="400" height="400"></canvas>

<h3>Entradas</h3>
<table role="grid">
  <thead><tr><th>Tipo</th><th>Monto</th><th>Fecha</th><th>Factura</th></tr></thead>
  <tbody>
  @forelse($entradas as $e)
    <tr>
      <td>{{ $e->tipo_entrada }}</td>
      <td>${{ number_format($e->monto,2) }}</td>
      <td>{{ $e->fecha }}</td>
      <td>
        @if($e->factura)
          <a target="_blank" href="{{ asset('storage/'.$e->factura) }}">Ver</a>
        @else — @endif
      </td>
    </tr>
  @empty
    <tr><td colspan="4">Sin entradas</td></tr>
  @endforelse
  </tbody>
</table>

<h3>Salidas</h3>
<table role="grid">
  <thead><tr><th>Tipo</th><th>Monto</th><th>Fecha</th><th>Factura</th></tr></thead>
  <tbody>
  @forelse($salidas as $s)
    <tr>
      <td>{{ $s->tipo_salida }}</td>
      <td>${{ number_format($s->monto,2) }}</td>
      <td>{{ $s->fecha }}</td>
      <td>
        @if($s->factura)
          <a target="_blank" href="{{ asset('storage/'.$s->factura) }}">Ver</a>
        @else — @endif
      </td>
    </tr>
  @empty
    <tr><td colspan="4">Sin salidas</td></tr>
  @endforelse
  </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('pie').getContext('2d');
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Entradas', 'Salidas'],
      datasets: [{ data: [{{ $totalEntradas }}, {{ $totalSalidas }}] }]
    }
  });
</script>
@endsection
