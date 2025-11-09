<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        DB::beginTransaction();

        try {
            $entrada = Entrada::create([
                'tipo_entrada' => $request->tipo_entrada,
                'monto'        => $request->monto,
                'fecha'        => $request->fecha,
                'factura'      => null,
            ]);

            if ($request->hasFile('factura')) {
                $file = $request->file('factura');
                $timestamp = now()->format('Ymd_His');
                $extension = $file->getClientOriginalExtension();
                $fileName = "{$entrada->id}_{$timestamp}.{$extension}";
                $path = $file->storeAs('facturas', $fileName, 'public');
                $entrada->update(['factura' => $path]);
            }

            DB::commit();
            return redirect()->route('entradas.index')->with('success', 'Entrada registrada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al registrar la entrada: ' . $e->getMessage()]);
        }
    }

    public function edit(Entrada $entrada)
    {
        return view('entradas.edit', compact('entrada'));
    }

    public function update(Request $request, Entrada $entrada)
    {
        $request->validate([
            'tipo_entrada' => 'required|string|max:100',
            'monto'        => 'required|numeric',
            'fecha'        => 'required|date',
            'factura'      => 'nullable|image|max:4096'
        ]);

        DB::beginTransaction();

        try {
            $data = [
                'tipo_entrada' => $request->tipo_entrada,
                'monto'        => $request->monto,
                'fecha'        => $request->fecha,
            ];

            if ($request->hasFile('factura')) {
                if ($entrada->factura && Storage::disk('public')->exists($entrada->factura)) {
                    Storage::disk('public')->delete($entrada->factura);
                }

                $file = $request->file('factura');
                $timestamp = now()->format('Ymd_His');
                $extension = $file->getClientOriginalExtension();
                $fileName = "{$entrada->id}_{$timestamp}.{$extension}";
                $path = $file->storeAs('facturas', $fileName, 'public');
                $data['factura'] = $path;
            }

            $entrada->update($data);
            DB::commit();

            return redirect()->route('entradas.index')->with('success', 'Entrada actualizada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    public function destroy(Entrada $entrada)
    {
        DB::beginTransaction();

        try {
            if ($entrada->factura && Storage::disk('public')->exists($entrada->factura)) {
                Storage::disk('public')->delete($entrada->factura);
            }

            $entrada->delete();
            DB::commit();

            return redirect()->route('entradas.index')->with('success', 'Entrada eliminada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al eliminar: ' . $e->getMessage()]);
        }
    }
}
