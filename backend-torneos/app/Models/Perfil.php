<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'perfiles';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'usuario_id',
        'nombre', 
        'apellidos', 
        'foto_perfil', 
        'telefono', 
        'fecha_nacimiento', 
        'direccion'
    ];

    // Campos que se deben ocultar en las conversiones a array/JSON
    protected $hidden = [];

    // Campos que se deben convertir a tipos nativos
    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    // Relación con el Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Método para obtener el nombre completo
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellidos}";
    }

    // Método para obtener la edad
    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento ? $this->fecha_nacimiento->age : null;
    }
}