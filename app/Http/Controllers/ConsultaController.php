<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public function store(Request $request)
    {
        $consulta = new Consulta();
        $consulta->pais = $request->country;
        $consulta->ciudad = $request->city;
        $consulta->presupuesto = $request->budget;
        $consulta->clima = $request->weather;
        $consulta->monedaLocal = $request->convertedBudget;
        $consulta->tasaCambio = $request->tasa;

        $consulta->save();

        // Imprimir el JSON response en la consola
        $response = ['message' => 'Consulta guardada'];


        return response()->json($response, 201);
    }


    public function destroy($id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->delete();

        return response()->json(['message' => 'Consulta eliminada'], 200);
    }
}
