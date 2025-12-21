<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenProducto extends Model
{
    protected $table = 'imagenes_producto';
    protected $primaryKey = 'id_imagen';
    public $timestamps = true;

    protected $fillable = [
        'producto_id',
        'ruta_imagen',
        'descripcion',
        'es_principal'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id_producto');
    }
}