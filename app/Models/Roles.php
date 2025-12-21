<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Permiso;
use App\Models\Usuario;

class Roles extends Model
{
    use SoftDeletes;

    protected $table = 'roles';
    protected $primaryKey = 'id_rol';
    public $timestamps = true;

    public function getRouteKeyName()
    {
        return 'id_rol';
    }
    
    protected $fillable = [
        'nombre_rol',
        'descripcion',
    ];

    protected $dates = ['deleted_at'];
    
    // Un rol TIENE MUCHOS permisos
    public function permisos()
    {
        return $this->belongsToMany(
            Permiso::class,
            'roles_has_permisos',
            'rol_id',
            'permiso_id'
        );
    }

    // Usuarios que tienen este rol
    public function usuarios()
    {
        return $this->hasMany(
            Usuario::class,
            'id_rol',
            'id_rol'
        );  
}
}
