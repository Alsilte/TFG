<?php

namespace App\Http\Controllers;

use App\Models\Clasificacion;
use Illuminate\Http\Request;

class ClasificacionController extends Controller
{
    public function index()
    {
        return Clasificacion::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'torneo_id' => 'required|exists:torneos,id',
            'equipo_id' => 'required|exists:equipos,id',
            'puntos' => 'integer|min:0',
            'partidos_jugados' => 'integer|min:0'
        ]);

        $clasificacion = Clasificacion::create($validatedData);
        return response()->json($clasificacion, 201);
    }

    public function show($id)
    {
        return Clasificacion::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $clasificacion = Clasificacion::findOrFail($id);
        $clasificacion->update($request->all());
        return $clasificacion;
    }

    public function destroy($id)
    {
        $clasificacion = Clasificacion::findOrFail($id);
        $clasificacion->delete();
        return response()->json(null, 204);
    }

    public function torneo($torneoId)
    {
        return Clasificacion::where('torneo_id', $torneoId)
            ->orderBy('puntos', 'desc')
            ->orderBy('diferencia_goles', 'desc')
            ->get();
    }
}