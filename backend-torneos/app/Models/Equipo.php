<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'equipos';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'logo',
        'club',
        'fecha_fundacion',
        'torneo_id'
    ];

    // Campos que se deben convertir a tipos nativos
    protected $casts = [
        'fecha_fundacion' => 'date'
    ];

    // Relación con el Torneo
    public function torneo()
    {
        return $this->belongsTo(Torneo::class, 'torneo_id');
    }

    // Relación con los Jugadores
    public function jugadores()
    {
        return $this->hasMany(Jugador::class, 'equipo_id');
    }

    // Relación con los Partidos como equipo local
    public function partidosLocales()
    {
        return $this->hasMany(Partido::class, 'equipo_local_id');
    }

    // Relación con los Partidos como equipo visitante
    public function partidosVisitantes()
    {
        return $this->hasMany(Partido::class, 'equipo_visitante_id');
    }

    // Método para obtener todos los partidos del equipo
    public function getPartidosAttribute()
    {
        return $this->partidosLocales->merge($this->partidosVisitantes);
    }

    // Método para obtener la clasificación del equipo
    public function clasificacion()
    {
        return $this->hasOne(Clasificacion::class, 'equipo_id');
    }

    // Método para obtener estadísticas del equipo
    public function getEstadisticasAttribute()
    {
        $clasificacion = $this->clasificacion;
        return [
            'puntos' => $clasificacion->puntos ?? 0,
            'partidos_jugados' => $clasificacion->partidos_jugados ?? 0,
            'partidos_ganados' => $clasificacion->partidos_ganados ?? 0,
            'partidos_empatados' => $clasificacion->partidos_empatados ?? 0,
            'partidos_perdidos' => $clasificacion->partidos_perdidos ?? 0,
            'goles_favor' => $clasificacion->goles_favor ?? 0,
            'goles_contra' => $clasificacion->goles_contra ?? 0,
        ];
    }

    // Método para obtener los goleadores del equipo
    public function getGoleadoresAttribute()
    {
        return $this->jugadores()
            ->withCount(['eventos' => function($query) {
                $query->where('tipo', 'gol');
            }])
            ->orderBy('eventos_count', 'desc')
            ->take(5)
            ->get();
    }

    // Método para verificar si el equipo está activo en el torneo
    public function getEstaActivoAttribute()
    {
        return $this->torneo->estado !== 'finalizado';
    }

    // Método para obtener la edad promedio de los jugadores
    public function getEdadPromedioAttribute()
    {
        $edades = $this->jugadores->map(function($jugador) {
            return optional($jugador->usuario->perfil)->fecha_nacimiento 
                ? $jugador->usuario->perfil->fecha_nacimiento->age 
                : null;
        })->filter();

        return $edades->count() > 0 
            ? round($edades->avg(), 1) 
            : null;
    }
}