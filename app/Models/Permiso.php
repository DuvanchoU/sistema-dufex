<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permiso extends Model
{   
    use SoftDeletes;

    protected $table = 'permisos';
    protected $primaryKey = 'id_permiso';
    public $timestamps = true;

    protected $fillable = [
        'nombre_permiso',
        'descripcion',
    ];

    protected $dates = ['deleted_at'];

    // Relación: muchos a muchos con Roles
    public function roles()
    {
        return $this->belongsToMany(
            Roles::class,
            'roles_has_permisos',
            'permiso_id',
            'rol_id'
        );
    }

    // Para route model binding
    public function getRouteKeyName()
    {
        return 'id_permiso';
    }
}
