<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Invitacion extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'invitaciones';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'email',
        'tipo_invitacion',
        'torneo_id',
        'equipo_id',
        'token',
        'estado',
        'fecha_expiracion'
    ];

    // Campos que se deben convertir a tipos nativos
    protected $casts = [
        'fecha_expiracion' => 'datetime',
        'created_at' => 'datetime'
    ];

    // Tipos de invitación
    const TIPOS = [
        'jugador' => 'Invitación a Jugador',
        'equipo' => 'Invitación a Equipo'
    ];

    // Estados de invitación
    const ESTADOS = [
        'pendiente' => 'Pendiente',
        'aceptada' => 'Aceptada',
        'rechazada' => 'Rechazada'
    ];

    // Relación con el Torneo (opcional)
    public function torneo()
    {
        return $this->belongsTo(Torneo::class, 'torneo_id');
    }

    // Relación con el Equipo (opcional)
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }

    // Método para generar un token único
    public static function generarToken()
    {
        return Str::random(60);
    }

    // Método de creación de invitación
    public static function crearInvitacion($email, $tipoInvitacion, $torneo = null, $equipo = null)
    {
        return self::create([
            'email' => $email,
            'tipo_invitacion' => $tipoInvitacion,
            'torneo_id' => $torneo ? $torneo->id : null,
            'equipo_id' => $equipo ? $equipo->id : null,
            'token' => self::generarToken(),
            'estado' => 'pendiente',
            'fecha_expiracion' => now()->addDays(7) // Válido por 7 días
        ]);
    }

    // Método para verificar si la invitación está vigente
    public function getEstaVigenteAttribute()
    {
        return $this->estado === 'pendiente' && 
               $this->fecha_expiracion > now();
    }

    // Método para obtener la descripción del tipo de invitación
    public function getTipoDescripcionAttribute()
    {
        return self::TIPOS[$this->tipo_invitacion] ?? $this->tipo_invitacion;
    }

    // Método para obtener la descripción del estado
    public function getEstadoDescripcionAttribute()
    {
        return self::ESTADOS[$this->estado] ?? $this->estado;
    }

    // Método para aceptar la invitación
    public function aceptar()
    {
        if (!$this->esta_vigente) {
            throw new \Exception('La invitación ha expirado.');
        }

        $this->estado = 'aceptada';
        $this->save();

        // Lógica adicional según el tipo de invitación
        switch ($this->tipo_invitacion) {
            case 'jugador':
                $this->registrarJugador();
                break;
            case 'equipo':
                $this->registrarEquipo();
                break;
        }

        return $this;
    }

    // Método para rechazar la invitación
    public function rechazar()
    {
        $this->estado = 'rechazada';
        $this->save();
        return $this;
    }

    // Método privado para registrar un jugador
    private function registrarJugador()
    {
        // Crear usuario
        $usuario = Usuario::create([
            'email' => $this->email,
            'tipo_usuario' => 'jugador',
            'email_verificado' => true
        ]);

        // Asociar a un equipo si está especificado
        if ($this->equipo_id) {
            Jugador::create([
                'usuario_id' => $usuario->id,
                'equipo_id' => $this->equipo_id
            ]);
        }

        return $usuario;
    }

    // Método privado para registrar un equipo
    private function registrarEquipo()
    {
        // Lógica para registrar un equipo
        // Puede implicar crear un usuario de club, etc.
        return null;
    }

    // Método de ámbito para filtrar por estado
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    // Método de ámbito para filtrar por tipo de invitación
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_invitacion', $tipo);
    }
}