@extends('layouts.app')

@section('content')
<h2>Salidas</h2>
<p><a href="{{ route('salidas.create') }}">+ Registrar salida</a></p>
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
        @else —
        @endif
      </td>
    </tr>
  @empty
    <tr><td colspan="4">Sin registros</td></tr>
  @endforelse
  </tbody>
</table>
@endsection
