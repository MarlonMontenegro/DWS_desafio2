<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Salida;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReporteBalanceController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->input('from');
        $to   = $request->input('to');

        $qEntradas = Entrada::query();
        $qSalidas  = Salida::query();

        if ($from) $qEntradas->whereDate('fecha', '>=', $from);
        if ($to)   $qEntradas->whereDate('fecha', '<=', $to);
        if ($from) $qSalidas->whereDate('fecha', '>=', $from);
        if ($to)   $qSalidas->whereDate('fecha', '<=', $to);

        $entradas = $qEntradas->orderBy('fecha','desc')->get();
        $salidas  = $qSalidas->orderBy('fecha','desc')->get();

        $totalEntradas = $entradas->sum('monto');
        $totalSalidas  = $salidas->sum('monto');
        $balance       = $totalEntradas - $totalSalidas;

        return view('balance.index', compact(
            'entradas','salidas','totalEntradas','totalSalidas','balance','from','to'
        ));
    }

public function pdf(Request $request)
{
    $from = $request->input('from');
    $to   = $request->input('to');

    $qEntradas = Entrada::query();
    $qSalidas  = Salida::query();

    if ($from) $qEntradas->whereDate('fecha', '>=', $from);
    if ($to)   $qEntradas->whereDate('fecha', '<=', $to);
    if ($from) $qSalidas->whereDate('fecha', '>=', $from);
    if ($to)   $qSalidas->whereDate('fecha', '<=', $to);

    $entradas = $qEntradas->orderBy('fecha','desc')->get();
    $salidas  = $qSalidas->orderBy('fecha','desc')->get();

    $totalEntradas = $entradas->sum('monto');
    $totalSalidas  = $salidas->sum('monto');
    $balance       = $totalEntradas - $totalSalidas;

    $pdf = Pdf::loadView('balance.pdf', compact(
        'entradas','salidas','totalEntradas','totalSalidas','balance','from','to'
    ))->setPaper('a4', 'portrait');

    $userId    = auth()->id() ?: 'guest';
    $timestamp = now()->format('Ymd_His'); 
    $fileName  = "balance_{$userId}_{$timestamp}.pdf";

    return $pdf->download($fileName);
}
}
