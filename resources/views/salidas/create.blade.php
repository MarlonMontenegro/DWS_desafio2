@extends('layouts.app')

@section('title', 'Registrar salida')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="mb-0 text-danger"> Registrar salida</h2>
        <small class="text-muted">Registra una nueva salida con su respectiva información.</small>
    </div>
    <a href="{{ route('salidas.index') }}" class="btn btn-outline-secondary">
         Volver al listado
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="POST"
              action="{{ route('salidas.store') }}"
              enctype="multipart/form-data"
              class="row g-3">
            @csrf

            <div class="col-12">
                <label for="tipo_salida" class="form-label">Tipo de salida</label>
                <input
                    type="text"
                    id="tipo_salida"
                    name="tipo_salida"
                    class="form-control @error('tipo_salida') is-invalid @enderror"
                    value="{{ old('tipo_salida') }}"
                    placeholder="Ejemplo: Pago de servicios, Nómina, Compra de insumos..."
                    required
                >
                @error('tipo_salida')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="monto" class="form-label">Monto</label>
                <input
                    type="number"
                    step="0.01"
                    id="monto"
                    name="monto"
                    class="form-control @error('monto') is-invalid @enderror"
                    value="{{ old('monto') }}"
                    placeholder="0.00"
                    required
                >
                @error('monto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="fecha" class="form-label">Fecha</label>
                <input
                    type="date"
                    id="fecha"
                    name="fecha"
                    class="form-control @error('fecha') is-invalid @enderror"
                    value="{{ old('fecha') }}"
                    required
                >
                @error('fecha')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="factura" class="form-label">Factura (imagen opcional)</label>
                <input
                    type="file"
                    id="factura"
                    name="factura"
                    class="form-control @error('factura') is-invalid @enderror"
                    accept="image/*"
                >
                @error('factura')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted d-block mt-1">
                    Adjunta una imagen de la factura si aplica.
                </small>
            </div>

            <div class="col-12 d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-danger">
                     Guardar salida
                </button>
                <a href="{{ route('salidas.index') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
