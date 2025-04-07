<?php

namespace App\Http\Controllers;

use App\Models\Invitacion;
use App\Models\Torneo;
use App\Models\Equipo;
use Illuminate\Http\Request;

class InvitacionController extends Controller
{
    public function index()
    {
        return Invitacion::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'tipo_invitacion' => 'required|in:jugador,equipo',
            'torneo_id' => 'nullable|exists:torneos,id',
            'equipo_id' => 'nullable|exists:equipos,id'
        ]);

        $invitacion = Invitacion::crearInvitacion(
            $validatedData['email'], 
            $validatedData['tipo_invitacion'], 
            $request->has('torneo_id') ? Torneo::find($validatedData['torneo_id']) : null,
            $request->has('equipo_id') ? Equipo::find($validatedData['equipo_id']) : null
        );

        return response()->json($invitacion, 201);
    }

    public function show($id)
    {
        return Invitacion::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $invitacion = Invitacion::findOrFail($id);
        $invitacion->update($request->all());
        return $invitacion;
    }

    public function destroy($id)
    {
        $invitacion = Invitacion::findOrFail($id);
        $invitacion->delete();
        return response()->json(null, 204);
    }

    public function enviar(Request $request)
    {
        // Lógica para enviar invitación por correo
        return response()->json(['message' => 'Invitación enviada']);
    }

    public function aceptar($id)
    {
        $invitacion = Invitacion::findOrFail($id);
        $invitacion->aceptar();
        return response()->json($invitacion);
    }

    public function rechazar($id)
    {
        $invitacion = Invitacion::findOrFail($id);
        $invitacion->rechazar();
        return response()->json($invitacion);
    }
}