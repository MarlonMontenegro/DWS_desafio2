@extends('layouts.app')

@section('content')
<h2>Registrar salida</h2>
<form method="post" action="{{ route('salidas.store') }}" enctype="multipart/form-data">
  @csrf
  <label>Tipo de salida
    <input name="tipo_salida" required>
  </label>
  <label>Monto
    <input type="number" step="0.01" name="monto" required>
  </label>
  <label>Fecha
    <input type="date" name="fecha" required>
  </label>
  <label>Factura (imagen)
    <input type="file" name="factura" accept="image/*">
  </label>
  <button type="submit">Guardar</button>
</form>
@endsection
