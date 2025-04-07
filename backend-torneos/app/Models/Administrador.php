<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'administradores';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'usuario_id',
        'nivel_acceso'
    ];

    // Definir niveles de acceso
    const NIVELES_ACCESO = [
        'super_admin' => 'Administrador Principal',
        'admin' => 'Administrador'
    ];

    // Relación con el Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Relación con los Torneos
    public function torneos()
    {
        return $this->hasMany(Torneo::class, 'administrador_id');
    }

    // Método para obtener el nombre completo del administrador
    public function getNombreCompletoAttribute()
    {
        return optional($this->usuario->perfil)->nombre_completo;
    }

    // Método para obtener la descripción del nivel de acceso
    public function getNivelAccesoDescripcionAttribute()
    {
        return self::NIVELES_ACCESO[$this->nivel_acceso] ?? $this->nivel_acceso;
    }

    // Método para verificar si es super administrador
    public function getEsSuperAdminAttribute()
    {
        return $this->nivel_acceso === 'super_admin';
    }

    // Método para contar torneos gestionados
    public function getTorneosGestionadosAttribute()
    {
        return $this->torneos()->count();
    }

    // Método para obtener torneos activos
    public function getTorneosActivosAttribute()
    {
        return $this->torneos()->where('estado', 'en_curso')->get();
    }

    // Método para crear un nuevo torneo
    public function crearTorneo(array $datos)
    {
        return $this->torneos()->create(array_merge($datos, [
            'administrador_id' => $this->id
        ]));
    }

    // Método de ámbito para filtrar por nivel de acceso
    public function scopePorNivelAcceso($query, $nivel)
    {
        return $query->where('nivel_acceso', $nivel);
    }

    // Método para verificar permisos
    public function tienePermiso($permiso)
    {
        // Lógica de permisos basada en el nivel de acceso
        $permisos = [
            'super_admin' => [
                'crear_torneo', 
                'eliminar_torneo', 
                'gestionar_usuarios'
            ],
            'admin' => [
                'crear_torneo', 
                'editar_torneo'
            ]
        ];

        return in_array($permiso, $permisos[$this->nivel_acceso] ?? []);
    }
}