@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row g-3">
        {{-- Tarjeta de bienvenida --}}
        <div class="col-12">
            <div class="card p-4 shadow-sm border-0 bg-dark text-light">
                <h5 class="mb-2">
                    Bienvenido, <strong>{{ Auth::user()->name }}</strong> 👋
                </h5>
                <p class="text-secondary mb-0">
                    Usa el menú lateral o los accesos rápidos para navegar.
                </p>
            </div>
        </div>

        {{-- Accesos rápidos --}}
        <div class="col-md-4">
            <a href="{{ route('entradas.index') }}" class="text-decoration-none">
                <div class="card p-4 h-100 border-0 shadow-sm hover-card">
                    <h6 class="mb-1">
                        <i class="bi bi-box-arrow-in-down text-success me-1"></i>
                        Entradas
                    </h6>
                    <p class="text-muted mb-0">Ver y registrar ingresos</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('salidas.index') }}" class="text-decoration-none">
                <div class="card p-4 h-100 border-0 shadow-sm hover-card">
                    <h6 class="mb-1">
                        <i class="bi bi-box-arrow-up text-danger me-1"></i>
                        Salidas
                    </h6>
                    <p class="text-muted mb-0">Ver y registrar egresos</p>
                </div>
            </a>
        </div>

        @if(Route::has('balance.index'))
        <div class="col-md-4">
            <a href="{{ route('balance.index') }}" class="text-decoration-none">
                <div class="card p-4 h-100 border-0 shadow-sm hover-card">
                    <h6 class="mb-1">
                        <i class="bi bi-graph-up text-primary me-1"></i>
                        Balance
                    </h6>
                    <p class="text-muted mb-0">Resumen financiero y PDF</p>
                </div>
            </a>
        </div>
        @endif
    </div>
</div>

{{-- Estilos locales --}}
@push('styles')
<style>
    .hover-card {
        background-color: #0f172a;
        color: #e5e7eb;
        transition: all 0.25s ease;
    }
    .hover-card:hover {
        background-color: #1e293b;
        transform: translateY(-4px);
    }
</style>
@endpush
@endsection
