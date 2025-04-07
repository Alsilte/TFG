<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Partido extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'partidos';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'torneo_id',
        'equipo_local_id',
        'equipo_visitante_id',
        'arbitro_id',
        'fecha',
        'estado',
        'resultado_local',
        'resultado_visitante'
    ];

    // Campos que se deben convertir a tipos nativos
    protected $casts = [
        'fecha' => 'datetime',
        'resultado_local' => 'integer',
        'resultado_visitante' => 'integer'
    ];

    // Relación con el Torneo
    public function torneo()
    {
        return $this->belongsTo(Torneo::class, 'torneo_id');
    }

    // Relación con el Equipo Local
    public function equipoLocal()
    {
        return $this->belongsTo(Equipo::class, 'equipo_local_id');
    }

    // Relación con el Equipo Visitante
    public function equipoVisitante()
    {
        return $this->belongsTo(Equipo::class, 'equipo_visitante_id');
    }

    // Relación con el Árbitro
    public function arbitro()
    {
        return $this->belongsTo(Arbitro::class, 'arbitro_id');
    }

    // Relación con los Eventos del Partido
    public function eventos()
    {
        return $this->hasMany(Evento::class, 'partido_id');
    }

    // Método para obtener los goles de un equipo
    public function getGolesEquipo($equipoId)
    {
        return $this->eventos()
            ->where('tipo', 'gol')
            ->whereHas('jugador', function($query) use ($equipoId) {
                $query->where('equipo_id', $equipoId);
            })
            ->count();
    }

    // Método para determinar el resultado
    public function getResultadoAttribute()
    {
        if ($this->resultado_local > $this->resultado_visitante) {
            return 'Victoria Local';
        } elseif ($this->resultado_local < $this->resultado_visitante) {
            return 'Victoria Visitante';
        } else {
            return 'Empate';
        }
    }

    // Método para verificar si el partido está próximo
    public function getEsProximoAttribute()
    {
        return $this->estado === 'programado' && $this->fecha > now();
    }

    // Método para obtener los eventos por tipo
    public function getEventosPorTipo($tipo)
    {
        return $this->eventos()->where('tipo', $tipo)->get();
    }

    // Método para calcular la duración del partido
    public function getDuracionAttribute()
    {
        // Implementación básica, ajustar según las reglas del deporte
        return $this->estado === 'finalizado' 
            ? Carbon::parse($this->fecha)->diffForHumans(
                Carbon::parse($this->fecha)->addMinutes(90), 
                true
            )
            : null;
    }

    // Método para obtener los jugadores que participaron
    public function getJugadoresParticipantesAttribute()
    {
        return Jugador::whereIn('equipo_id', [
            $this->equipo_local_id, 
            $this->equipo_visitante_id
        ])->get();
    }
}