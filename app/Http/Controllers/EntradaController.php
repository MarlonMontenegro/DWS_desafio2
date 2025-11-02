<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use Illuminate\Http\Request;

class EntradaController extends Controller
{
    public function index()
    {
        $entradas = Entrada::latest()->get();
        return view('entradas.index', compact('entradas'));
    }

    public function create()
    {
        return view('entradas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_entrada' => 'required|string|max:100',
            'monto'        => 'required|numeric',
            'fecha'        => 'required|date',
            'factura'      => 'nullable|image|max:4096'
        ]);

        $ruta = $request->hasFile('factura')
            ? $request->file('factura')->store('facturas', 'public')
            : null;

        Entrada::create([
            'tipo_entrada' => $request->tipo_entrada,
            'monto'        => $request->monto,
            'fecha'        => $request->fecha,
            'factura'      => $ruta,
        ]);

        return redirect()->route('entradas.index')->with('success', 'Entrada registrada.');
    }
}
