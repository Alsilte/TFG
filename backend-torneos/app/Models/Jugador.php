<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'jugadores';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'usuario_id',
        'equipo_id',
        'numero_camiseta',
        'posicion',
        'fecha_ingreso'
    ];

    // Campos que se deben convertir a tipos nativos
    protected $casts = [
        'fecha_ingreso' => 'date'
    ];

    // Relación con el Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Relación con el Equipo
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }

    // Relación con Eventos (goles, tarjetas, etc.)
    public function eventos()
    {
        return $this->hasMany(Evento::class, 'jugador_id');
    }

    // Método para obtener los goles del jugador
    public function getGolesAttribute()
    {
        return $this->eventos()->where('tipo', 'gol')->count();
    }

    // Método para obtener las tarjetas amarillas
    public function getTarjetasAmarillasAttribute()
    {
        return $this->eventos()->where('tipo', 'tarjeta_amarilla')->count();
    }

    // Método para obtener las tarjetas rojas
    public function getTarjetasRojasAttribute()
    {
        return $this->eventos()->where('tipo', 'tarjeta_roja')->count();
    }

    // Método para verificar si es titular o suplente
    public function getTipoJugadorAttribute()
    {
        // Lógica para determinar si es titular o suplente
        // Puede depender de la configuración del equipo o historial de partidos
        return 'titular'; // O 'suplente'
    }
}