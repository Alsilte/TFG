<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arbitro extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'arbitros';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'usuario_id',
        'licencia',
        'especialidad'
    ];

    // Relación con el Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Relación con los Partidos que ha arbitrado
    public function partidos()
    {
        return $this->hasMany(Partido::class, 'arbitro_id');
    }

    // Método para obtener la cantidad de partidos arbitrados
    public function getPartidosArbitradosAttribute()
    {
        return $this->partidos()->count();
    }

    // Método para obtener los partidos arbitrados en un rango de fechas
    public function getPartidosEntreFechas($fechaInicio, $fechaFin)
    {
        return $this->partidos()
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->get();
    }

    // Método para verificar si el árbitro está disponible en una fecha
    public function estaDisponible($fecha)
    {
        return $this->partidos()
            ->where('fecha', $fecha)
            ->doesntExist();
    }

    // Método para obtener el nombre completo del árbitro
    public function getNombreCompletoAttribute()
    {
        return $this->usuario->perfil->nombre . ' ' . $this->usuario->perfil->apellidos;
    }
}