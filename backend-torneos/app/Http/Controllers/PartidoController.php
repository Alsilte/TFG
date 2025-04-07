<?php

namespace App\Http\Controllers;

use App\Models\Partido;
use Illuminate\Http\Request;

class PartidoController extends Controller
{
    public function index()
    {
        return Partido::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'torneo_id' => 'required|exists:torneos,id',
            'equipo_local_id' => 'required|exists:equipos,id',
            'equipo_visitante_id' => 'required|exists:equipos,id',
            'arbitro_id' => 'required|exists:arbitros,id',
            'fecha' => 'required|date',
            'estado' => 'required|in:programado,en_curso,finalizado'
        ]);

        $partido = Partido::create($validatedData);
        return response()->json($partido, 201);
    }

    public function show($id)
    {
        return Partido::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $partido = Partido::findOrFail($id);
        $partido->update($request->all());
        return $partido;
    }

    public function destroy($id)
    {
        $partido = Partido::findOrFail($id);
        $partido->delete();
        return response()->json(null, 204);
    }

    public function eventos($id)
    {
        $partido = Partido::findOrFail($id);
        return $partido->eventos;
    }
}