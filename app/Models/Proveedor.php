<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Compra;
use App\Models\Inventario;

class Proveedor extends Model
{   
    use SoftDeletes;

    protected $table = 'proveedores';
    protected $primaryKey = 'id_proveedor';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'direccion',
        'estado',
    ];

    protected $dates = ['deleted_at'];

    // Compras realizadas a este proveedor
    public function compras()
    {
        return $this->hasMany(
            Compra::class,
            'proveedor_id',
            'id_proveedor'
        );
    }

    // Registros de inventario asociados al proveedor
    public function inventarios()
    {
        return $this->hasMany(
            Inventario::class,
            'proveedor_id',
            'id_proveedor'
        );
    }   

    public function getRouteKeyName()
    {
        return 'id_proveedor';
    }
}
