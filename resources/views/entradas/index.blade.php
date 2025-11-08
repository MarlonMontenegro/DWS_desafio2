@extends('layouts.app')

@section('title', 'Entradas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="mb-0"> Entradas</h2>
        <small class="text-muted">Listado de ingresos registrados en el sistema.</small>
    </div>
    <a href="{{ route('entradas.create') }}" class="btn btn-success">
         Registrar entrada
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
                    @forelse($entradas as $e)
                        <tr>
                            <td>{{ $e->tipo_entrada }}</td>
                            <td>${{ number_format($e->monto, 2) }}</td>
                            <td>{{ $e->fecha }}</td>
                            <td>
                                @if($e->factura)
                                    <a
                                        target="_blank"
                                        href="{{ asset('storage/'.$e->factura) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        Ver factura
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Sin registros de entradas todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
