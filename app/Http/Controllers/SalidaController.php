<?php

namespace App\Http\Controllers;

use App\Models\Salida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        DB::beginTransaction();

        try {
            $salida = Salida::create([
                'tipo_salida' => $request->tipo_salida,
                'monto'       => $request->monto,
                'fecha'       => $request->fecha,
                'factura'     => null,
            ]);

            if ($request->hasFile('factura')) {
                $file = $request->file('factura');
                $timestamp = now()->format('Ymd_His');
                $extension = $file->getClientOriginalExtension();
                $fileName = "{$salida->id}_{$timestamp}.{$extension}";
                $path = $file->storeAs('facturas', $fileName, 'public');


                $salida->update(['factura' => $path]);
            }

            DB::commit();
            return redirect()->route('salidas.index')->with('success', 'Salida registrada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al registrar la salida: ' . $e->getMessage()]);
        }
    }

    public function edit(Salida $salida)
    {
        return view('salidas.edit', compact('salida'));
    }

    public function update(Request $request, Salida $salida)
    {
        $request->validate([
            'tipo_salida' => 'required|string|max:100',
            'monto'       => 'required|numeric',
            'fecha'       => 'required|date',
            'factura'     => 'nullable|image|max:4096'
        ]);

        DB::beginTransaction();

        try {
            $data = [
                'tipo_salida' => $request->tipo_salida,
                'monto'       => $request->monto,
                'fecha'       => $request->fecha,
            ];

            if ($request->hasFile('factura')) {
                if ($salida->factura && Storage::disk('public')->exists($salida->factura)) {
                    Storage::disk('public')->delete($salida->factura);
                }
            
                $file = $request->file('factura');
                $timestamp = now()->format('Ymd_His');
                $extension = $file->getClientOriginalExtension();
                $fileName = "{$salida->id}_{$timestamp}.{$extension}";
                $path = $file->storeAs('facturas', $fileName, 'public');
                $data['factura'] = $path;
            }

            $salida->update($data);
            DB::commit();

            return redirect()->route('salidas.index')->with('success', 'Salida actualizada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    public function destroy(Salida $salida)
    {
        DB::beginTransaction();

        try {
            if ($salida->factura && Storage::disk('public')->exists($salida->factura)) {
                Storage::disk('public')->delete($salida->factura);
            }

            $salida->delete();
            DB::commit();

            return redirect()->route('salidas.index')->with('success', 'Salida eliminada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al eliminar: ' . $e->getMessage()]);
        }
    }
}
