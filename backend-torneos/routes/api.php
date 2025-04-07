<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controladores
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TorneoController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\PartidoController;
use App\Http\Controllers\JugadorController;
use App\Http\Controllers\ArbitroController;
use App\Http\Controllers\EventoController;  
use App\Http\Controllers\ClasificacionController;
use App\Http\Controllers\InvitacionController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\PerfilController;

// Rutas de recursos principales
Route::apiResources([
    'usuarios' => UsuarioController::class,
    'torneos' => TorneoController::class,
    'equipos' => EquipoController::class,
    'partidos' => PartidoController::class,
    'jugadores' => JugadorController::class,
    'arbitros' => ArbitroController::class,
    'eventos' => EventoController::class,
    'clasificaciones' => ClasificacionController::class,
    'invitaciones' => InvitacionController::class,
    'administradores' => AdministradorController::class,
    'perfiles' => PerfilController::class
]);

// Rutas personalizadas adicionales
Route::group(['prefix' => 'torneos'], function () {
    Route::get('{torneo}/equipos', [TorneoController::class, 'equipos']);
    Route::get('{torneo}/partidos', [TorneoController::class, 'partidos']);
    Route::get('{torneo}/clasificacion', [TorneoController::class, 'clasificacion']);
});

Route::group(['prefix' => 'equipos'], function () {
    Route::get('{equipo}/jugadores', [EquipoController::class, 'jugadores']);
    Route::get('{equipo}/partidos', [EquipoController::class, 'partidos']);
});

Route::group(['prefix' => 'partidos'], function () {
    Route::get('{partido}/eventos', [PartidoController::class, 'eventos']);
});

// Rutas de autenticación (a implementar)
Route::post('login', [UsuarioController::class, 'login']);
Route::post('registro', [UsuarioController::class, 'registro']);
Route::post('logout', [UsuarioController::class, 'logout']);

// Rutas de invitación
Route::group(['prefix' => 'invitaciones'], function () {
    Route::post('enviar', [InvitacionController::class, 'enviar']);
    Route::post('{invitacion}/aceptar', [InvitacionController::class, 'aceptar']);
    Route::post('{invitacion}/rechazar', [InvitacionController::class, 'rechazar']);
});

// Rutas de administración
Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'admin']], function () {
    Route::post('torneos/crear', [AdministradorController::class, 'crearTorneo']);
    Route::get('estadisticas', [AdministradorController::class, 'estadisticas']);
});

// Ruta de prueba
Route::get('test', function () {
    return response()->json(['message' => 'API funcionando correctamente']);
});