<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    {
        return Equipo::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'torneo_id' => 'required|exists:torneos,id'
        ]);

        $equipo = Equipo::create($validatedData);
        return response()->json($equipo, 201);
    }

    public function show($id)
    {
        return Equipo::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $equipo = Equipo::findOrFail($id);
        $equipo->update($request->all());
        return $equipo;
    }

    public function destroy($id)
    {
        $equipo = Equipo::findOrFail($id);
        $equipo->delete();
        return response()->json(null, 204);
    }

    public function jugadores($id)
    {
        $equipo = Equipo::findOrFail($id);
        return $equipo->jugadores;
    }

    public function partidos($id)
    {
        $equipo = Equipo::findOrFail($id);
        return $equipo->partidosLocales->merge($equipo->partidosVisitantes);
    }
}