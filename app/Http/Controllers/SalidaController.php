<?php

namespace App\Http\Controllers;

use App\Models\Salida;
use Illuminate\Http\Request;

class SalidaController extends Controller
{
    public function index()
    {
        $salidas = Salida::latest()->get();
        return view('salidas.index', compact('salidas'));
    }

    public function create()
    {
        return view('salidas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_salida' => 'required|string|max:100',
            'monto'       => 'required|numeric',
            'fecha'       => 'required|date',
            'factura'     => 'nullable|image|max:4096'
        ]);

        $ruta = $request->hasFile('factura')
            ? $request->file('factura')->store('facturas', 'public')
            : null;

        Salida::create([
            'tipo_salida' => $request->tipo_salida,
            'monto'       => $request->monto,
            'fecha'       => $request->fecha,
            'factura'     => $ruta,
        ]);

        return redirect()->route('salidas.index')->with('success', 'Salida registrada.');
    }
}
