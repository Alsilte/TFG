<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Torneo extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'torneos';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'administrador_id',
        'fecha_inicio',
        'fecha_fin',
        'formato',
        'estado',
        'reglas'
    ];

    // Campos que se deben convertir a tipos nativos
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'reglas' => 'array',
        'created_at' => 'datetime'
    ];

    // Relación con el Administrador
    public function administrador()
    {
        return $this->belongsTo(Administrador::class, 'administrador_id');
    }

    // Relación con los Equipos
    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'torneo_id');
    }

    // Relación con los Partidos
    public function partidos()
    {
        return $this->hasMany(Partido::class, 'torneo_id');
    }

    // Relación con las Clasificaciones
    public function clasificaciones()
    {
        return $this->hasMany(Clasificacion::class, 'torneo_id');
    }

    // Método para obtener partidos próximos
    public function getPartidosProximosAttribute()
    {
        return $this->partidos()
            ->where('fecha', '>', now())
            ->where('estado', 'programado')
            ->orderBy('fecha')
            ->get();
    }

    // Método para obtener partidos en curso
    public function getPartidosEnCursoAttribute()
    {
        return $this->partidos()
            ->where('estado', 'en_curso')
            ->get();
    }

    // Método para obtener el equipo líder
    public function getEquipoLiderAttribute()
    {
        return $this->clasificaciones()
            ->orderBy('puntos', 'desc')
            ->first()?->equipo;
    }

    // Método para verificar si el torneo está activo
    public function getEstaActivoAttribute()
    {
        return $this->estado === 'en_curso';
    }

    // Método para calcular la duración del torneo
    public function getDuracionAttribute()
    {
        return $this->fecha_inicio->diffInDays($this->fecha_fin);
    }

    // Método para obtener estadísticas generales
    public function getEstadisticasAttribute()
    {
        return [
            'total_equipos' => $this->equipos()->count(),
            'total_partidos' => $this->partidos()->count(),
            'partidos_jugados' => $this->partidos()->where('estado', 'finalizado')->count(),
            'total_goles' => $this->partidos()->sum('resultado_local') + 
                             $this->partidos()->sum('resultado_visitante')
        ];
    }

    // Método para generar calendario de partidos
    public function generarCalendario()
    {
        // Lógica para generar el calendario de partidos
        // Dependerá del formato del torneo (liga, copa, grupos)
        // Esta es una implementación básica
        $equipos = $this->equipos;
        
        if ($equipos->count() < 2) {
            return collect(); // No hay suficientes equipos
        }

        $calendario = collect();

        // Ejemplo simple para un torneo de todos contra todos
        foreach ($equipos as $equipoLocal) {
            foreach ($equipos as $equipoVisitante) {
                if ($equipoLocal->id !== $equipoVisitante->id) {
                    $partido = Partido::create([
                        'torneo_id' => $this->id,
                        'equipo_local_id' => $equipoLocal->id,
                        'equipo_visitante_id' => $equipoVisitante->id,
                        'arbitro_id' => Arbitro::inRandomOrder()->first()->id,
                        'fecha' => $this->generarFechaPartido(),
                        'estado' => 'programado'
                    ]);
                    $calendario->push($partido);
                }
            }
        }

        return $calendario;
    }

    // Método auxiliar para generar fecha de partido
    private function generarFechaPartido()
    {
        return Carbon::parse($this->fecha_inicio)
            ->addDays(rand(0, $this->duracion))
            ->setHour(rand(10, 20))
            ->setMinute(rand(0, 59));
    }

    // Método para finalizar el torneo
    public function finalizar()
    {
        $this->estado = 'finalizado';
        $this->save();

        // Lógica adicional como premiar al ganador, etc.
        return $this;
    }
}