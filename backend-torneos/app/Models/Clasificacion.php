<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clasificacion extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'clasificaciones';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'torneo_id',
        'equipo_id',
        'puntos',
        'partidos_jugados',
        'partidos_ganados',
        'partidos_empatados',
        'partidos_perdidos',
        'goles_favor',
        'goles_contra'
    ];

    // Campos que se deben convertir a tipos nativos
    protected $casts = [
        'puntos' => 'integer',
        'partidos_jugados' => 'integer',
        'partidos_ganados' => 'integer',
        'partidos_empatados' => 'integer',
        'partidos_perdidos' => 'integer',
        'goles_favor' => 'integer',
        'goles_contra' => 'integer'
    ];

    // Relación con el Torneo
    public function torneo()
    {
        return $this->belongsTo(Torneo::class, 'torneo_id');
    }

    // Relación con el Equipo
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }

    // Método para calcular la diferencia de goles
    public function getDiferenciaGolesAttribute()
    {
        return $this->goles_favor - $this->goles_contra;
    }

    // Método para obtener la posición en la clasificación
    public function getPosicionAttribute()
    {
        return $this->torneo->clasificaciones()
            ->where('puntos', '>', $this->puntos)
            ->count() + 1;
    }

    // Método para actualizar la clasificación después de un partido
    public function actualizarClasificacion(Partido $partido)
    {
        $esLocal = $partido->equipo_local_id === $this->equipo_id;
        $golesPropio = $esLocal ? $partido->resultado_local : $partido->resultado_visitante;
        $golesRival = $esLocal ? $partido->resultado_visitante : $partido->resultado_local;

        $this->partidos_jugados++;
        $this->goles_favor += $golesPropio;
        $this->goles_contra += $golesRival;

        if ($golesPropio > $golesRival) {
            $this->partidos_ganados++;
            $this->puntos += 3;
        } elseif ($golesPropio == $golesRival) {
            $this->partidos_empatados++;
            $this->puntos += 1;
        } else {
            $this->partidos_perdidos++;
        }

        $this->save();
        return $this;
    }

    // Método de ámbito para obtener la clasificación ordenada
    public function scopeOrdenadaPorPuntos($query)
    {
        return $query->orderBy('puntos', 'desc')
            ->orderBy('diferencia_goles', 'desc')
            ->orderBy('goles_favor', 'desc');
    }

    // Método para reiniciar la clasificación
    public function reiniciar()
    {
        $this->puntos = 0;
        $this->partidos_jugados = 0;
        $this->partidos_ganados = 0;
        $this->partidos_empatados = 0;
        $this->partidos_perdidos = 0;
        $this->goles_favor = 0;
        $this->goles_contra = 0;
        $this->save();
        return $this;
    }
}