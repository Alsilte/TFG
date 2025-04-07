<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'email', 
        'password', 
        'tipo_usuario', 
        'email_verificado'
    ];

    protected $hidden = [
        'password'
    ];

    // Relaciones
    public function perfil()
    {
        return $this->hasOne(Perfil::class, 'usuario_id');
    }

    public function administrador()
    {
        return $this->hasOne(Administrador::class, 'usuario_id');
    }

    public function jugador()
    {
        return $this->hasOne(Jugador::class, 'usuario_id');
    }

    public function arbitro()
    {
        return $this->hasOne(Arbitro::class, 'usuario_id');
    }
}