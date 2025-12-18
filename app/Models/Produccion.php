<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Producto;

class Produccion extends Model
{   
    use SoftDeletes;

    protected $table = 'produccion';
    protected $primaryKey = 'id_produccion';
    public $timestamps = true;

    protected $fillable = [
        'producto_id',
        'cantidad_producida',
        'fecha_inicio',
        'fecha_fin',
        'estado_produccion',
        'observaciones',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
        'deleted_at'   => 'datetime',
    ];

    // Producción pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(
            Producto::class,
            'producto_id',
            'id_producto'
        );
    }
}
