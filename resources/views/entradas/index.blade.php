@extends('layouts.app')

@section('content')
<h2>Entradas</h2>
<p><a href="{{ route('entradas.create') }}">+ Registrar entrada</a></p>
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
