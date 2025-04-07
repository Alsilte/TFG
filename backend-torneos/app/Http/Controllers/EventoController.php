<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        return Evento::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'partido_id' => 'required|exists:partidos,id',
            'jugador_id' => 'required|exists:jugadores,id',
            'tipo' => 'required|in:gol,tarjeta_amarilla,tarjeta_roja,sustitucion,tiempo_extra',
            'minuto' => 'required|integer|min:0|max:120',
            'descripcion' => 'nullable|string'
        ]);

        $evento = Evento::create($validatedData);
        return response()->json($evento, 201);
    }

    public function show($id)
    {
        return Evento::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $evento = Evento::findOrFail($id);
        $evento->update($request->all());
        return $evento;
    }

    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);
        $evento->delete();
        return response()->json(null, 204);
    }

    public function porPartido($partidoId)
    {
        return Evento::where('partido_id', $partidoId)
            ->orderBy('minuto')
            ->get();
    }
}