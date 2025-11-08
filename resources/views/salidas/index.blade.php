@extends('layouts.app')

@section('title', 'Salidas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="mb-0 text-danger">📤 Salidas</h2>
        <small class="text-muted">Listado de egresos registrados en el sistema.</small>
    </div>
    <a href="{{ route('salidas.create') }}" class="btn btn-danger">
        ➕ Registrar salida
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Tipo</th>
                        <th scope="col">Monto</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Factura</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salidas as $s)
                        <tr>
                            <td>{{ $s->tipo_salida }}</td>
                            <td>${{ number_format($s->monto, 2) }}</td>
                            <td>{{ $s->fecha }}</td>
                            <td>
                                @if($s->factura)
                                    <a
                                        target="_blank"
                                        href="{{ asset('storage/'.$s->factura) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        Ver
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Sin registros de salidas todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
