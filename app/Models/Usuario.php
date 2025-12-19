<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Roles;
use App\Models\Venta;
use App\Models\Compra;
use App\Models\Pedido;

class Usuario extends Authenticatable
{   
    use SoftDeletes;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = true;

    protected $email = 'correo_usuario';
    
    protected $fillable = [
        'nombres',
        'apellidos',
        'documento',
        'correo_usuario',
        'contrasena_usuario',
        'genero',
        'telefono',
        'estado',
        'id_rol'
    ];

    protected $hidden = [
        'contrasena_usuario',
        'remember_token',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relaciones
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'usuario_id', 'id_usuario');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'usuario_id', 'id_usuario');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'usuario_id', 'id_usuario');
    }

    public function rol()
    {
        return $this->belongsTo(Roles::class, 'id_rol', 'id_rol');
    }

    public function getEmailForPasswordReset()
    {
        return $this->correo_usuario;
    }

    public function getAuthPassword()
    {
        return $this->contrasena_usuario;
    }

    // Para que Auth::user() funcione correctamente
    public function getAuthIdentifierName()
    {
        return 'id_usuario';
    }
}