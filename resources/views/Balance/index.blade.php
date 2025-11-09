@extends('layouts.app')

@section('title', 'Reporte de Balance')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="mb-0">📊 Reporte de Balance</h2>
        <small class="text-muted">
            Consulta de entradas y salidas con filtro por rango de fechas.
        </small>
    </div>
</div>

{{-- Filtros --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="get"
              action="{{ route('balance.index') }}"
              class="row g-3 align-items-end">

            <div class="col-md-4">
                <label class="form-label">Desde</label>
                <input
                    type="date"
                    name="from"
                    value="{{ $from }}"
                    class="form-control"
                >
            </div>

            <div class="col-md-4">
                <label class="form-label">Hasta</label>
                <input
                    type="date"
                    name="to"
                    value="{{ $to }}"
                    class="form-control"
                >
            </div>

            <div class="col-md-4 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    🔍 Filtrar
                </button>

                <a href="{{ route('balance.index') }}"
                   class="btn btn-outline-secondary flex-fill">
                    🧹 Limpiar
                </a>

                <a href="{{ route('balance.pdf', ['from' => $from, 'to' => $to]) }}"
                   target="_blank"
                   class="btn btn-outline-danger flex-fill">
                    📄 Exportar PDF
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Resumen numérico --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Total Entradas</div>
                <div class="h4 text-success mb-0">
                    ${{ number_format($totalEntradas, 2) }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Total Salidas</div>
                <div class="h4 text-danger mb-0">
                    ${{ number_format($totalSalidas, 2) }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Balance</div>
                <div class="h4 mb-0
                    {{ $balance >= 0 ? 'text-primary' : 'text-warning' }}">
                    ${{ number_format($balance, 2) }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Gráfico --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="mb-3">Gráfico Entradas vs Salidas</h5>
        <div class="d-flex justify-content-center">
            <canvas id="pie" width="280" height="280"></canvas>
        </div>
    </div>
</div>

{{-- Tabla Entradas --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="mb-3">📥 Entradas</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tipo</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Factura</th>
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
                                    <a target="_blank"
                                       href="{{ asset('storage/'.$e->factura) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Ver
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Sin entradas en el período seleccionado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Tabla Salidas --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="mb-3">📤 Salidas</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tipo</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Factura</th>
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
                                    <a target="_blank"
                                       href="{{ asset('storage/'.$s->factura) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Ver
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Sin salidas en el período seleccionado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('pie').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Entradas', 'Salidas'],
            datasets: [{
                data: [{{ $totalEntradas }}, {{ $totalSalidas }}],
                backgroundColor: [
                    'rgba(25, 135, 84, 0.8)', // Entradas
                    'rgba(220, 53, 69, 0.8)'  // Salidas
                ],
                borderColor: [
                    'rgba(25, 135, 84, 1)',
                    'rgba(220, 53, 69, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#6c757d'
                    }
                }
            }
        }
    });
</script>
@endsection
