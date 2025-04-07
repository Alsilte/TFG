<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'eventos';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'partido_id',
        'jugador_id',
        'tipo',
        'minuto',
        'descripcion'
    ];

    // Definir los tipos de eventos posibles
    const TIPOS = [
        'gol' => 'Gol',
        'tarjeta_amarilla' => 'Tarjeta Amarilla',
        'tarjeta_roja' => 'Tarjeta Roja',
        'sustitucion' => 'Sustitución',
        'tiempo_extra' => 'Tiempo Extra'
    ];

    // Relación con el Partido
    public function partido()
    {
        return $this->belongsTo(Partido::class, 'partido_id');
    }

    // Relación con el Jugador
    public function jugador()
    {
        return $this->belongsTo(Jugador::class, 'jugador_id');
    }

    // Método para obtener el equipo del jugador
    public function getEquipoAttribute()
    {
        return $this->jugador->equipo;
    }

    // Método para obtener la descripción legible del tipo de evento
    public function getTipoDescripcionAttribute()
    {
        return self::TIPOS[$this->tipo] ?? $this->tipo;
    }

    // Método para verificar si es un evento de gol
    public function getEsGolAttribute()
    {
        return $this->tipo === 'gol';
    }

    // Método para verificar si es un evento de tarjeta
    public function getEsTarjetaAttribute()
    {
        return in_array($this->tipo, ['tarjeta_amarilla', 'tarjeta_roja']);
    }

    // Método para obtener el color de la tarjeta (si aplica)
    public function getColorTarjetaAttribute()
    {
        return $this->tipo === 'tarjeta_amarilla' ? 'amarillo' : 
               ($this->tipo === 'tarjeta_roja' ? 'rojo' : null);
    }

    // Método de ámbito para filtrar por tipo de evento
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    // Método para crear un evento de gol
    public static function registrarGol($partidoId, $jugadorId, $descripcion = null)
    {
        return self::create([
            'partido_id' => $partidoId,
            'jugador_id' => $jugadorId,
            'tipo' => 'gol',
            'minuto' => now()->minute,
            'descripcion' => $descripcion
        ]);
    }

    // Método para crear un evento de tarjeta
    public static function registrarTarjeta($partidoId, $jugadorId, $tipoTarjeta, $descripcion = null)
    {
        return self::create([
            'partido_id' => $partidoId,
            'jugador_id' => $jugadorId,
            'tipo' => $tipoTarjeta,
            'minuto' => now()->minute,
            'descripcion' => $descripcion
        ]);
    }
}