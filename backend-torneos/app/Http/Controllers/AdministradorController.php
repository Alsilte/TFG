<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function index()
    {
        return Administrador::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id|unique:administradores',
            'nivel_acceso' => 'required|in:super_admin,admin'
        ]);

        $administrador = Administrador::create($validatedData);
        return response()->json($administrador, 201);
    }

    public function show($id)
    {
        return Administrador::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $administrador = Administrador::findOrFail($id);
        $administrador->update($request->all());
        return $administrador;
    }

    public function destroy($id)
    {
        $administrador = Administrador::findOrFail($id);
        $administrador->delete();
        return response()->json(null, 204);
    }

    public function crearTorneo(Request $request)
    {
        $administrador = $request->user()->administrador;
        
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'formato' => 'required|in:liga,copa,grupos'
        ]);

        $torneo = $administrador->crearTorneo($validatedData);
        return response()->json($torneo, 201);
    }

    public function estadisticas()
    {
        // Lógica para obtener estadísticas generales
        return response()->json([
            'total_torneos' => Administrador::count(),
            'torneos_activos' => Administrador::whereHas('torneos', function($query) {
                $query->where('estado', 'en_curso');
            })->count()
        ]);
    }
}