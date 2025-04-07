<?php

namespace App\Http\Controllers;

use App\Models\Jugador;
use Illuminate\Http\Request;

class JugadorController extends Controller
{
    public function index()
    {
        return Jugador::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id|unique:jugadores',
            'equipo_id' => 'required|exists:equipos,id',
            'numero_camiseta' => 'nullable|string',
            'posicion' => 'nullable|string'
        ]);

        $jugador = Jugador::create($validatedData);
        return response()->json($jugador, 201);
    }

    public function show($id)
    {
        return Jugador::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $jugador = Jugador::findOrFail($id);
        $jugador->update($request->all());
        return $jugador;
    }

    public function destroy($id)
    {
        $jugador = Jugador::findOrFail($id);
        $jugador->delete();
        return response()->json(null, 204);
    }

    public function eventos($id)
    {
        $jugador = Jugador::findOrFail($id);
        return $jugador->eventos;
    }
}