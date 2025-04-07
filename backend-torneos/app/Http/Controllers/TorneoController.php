<?php

namespace App\Http\Controllers;

use App\Models\Torneo;
use Illuminate\Http\Request;

class TorneoController extends Controller
{
    public function index()
    {
        return Torneo::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'formato' => 'required|in:liga,copa,grupos',
            'administrador_id' => 'required|exists:administradores,id'
        ]);

        $torneo = Torneo::create($validatedData);
        return response()->json($torneo, 201);
    }

    public function show($id)
    {
        return Torneo::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $torneo = Torneo::findOrFail($id);
        $torneo->update($request->all());
        return $torneo;
    }

    public function destroy($id)
    {
        $torneo = Torneo::findOrFail($id);
        $torneo->delete();
        return response()->json(null, 204);
    }

    // Métodos personalizados
    public function equipos($id)
    {
        $torneo = Torneo::findOrFail($id);
        return $torneo->equipos;
    }

    public function partidos($id)
    {
        $torneo = Torneo::findOrFail($id);
        return $torneo->partidos;
    }

    public function clasificacion($id)
    {
        $torneo = Torneo::findOrFail($id);
        return $torneo->clasificaciones()->orderBy('puntos', 'desc')->get();
    }
}