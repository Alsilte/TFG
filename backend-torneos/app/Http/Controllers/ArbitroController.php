<?php

namespace App\Http\Controllers;

use App\Models\Arbitro;
use Illuminate\Http\Request;

class ArbitroController extends Controller
{
    public function index()
    {
        return Arbitro::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id|unique:arbitros',
            'licencia' => 'required|unique:arbitros',
            'especialidad' => 'nullable|string'
        ]);

        $arbitro = Arbitro::create($validatedData);
        return response()->json($arbitro, 201);
    }

    public function show($id)
    {
        return Arbitro::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $arbitro = Arbitro::findOrFail($id);
        $arbitro->update($request->all());
        return $arbitro;
    }

    public function destroy($id)
    {
        $arbitro = Arbitro::findOrFail($id);
        $arbitro->delete();
        return response()->json(null, 204);
    }

    public function partidos($id)
    {
        $arbitro = Arbitro::findOrFail($id);
        return $arbitro->partidos;
    }
}