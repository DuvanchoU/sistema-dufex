<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemCarrito extends Model
{
    protected $table = 'items_carrito';
    protected $primaryKey = 'id_item';
    public $timestamps = true;

    protected $fillable = [
        'carrito_id',
        'producto_id',
        'cantidad',
        'precio_unitario'
    ];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id_producto');
    }

    public function carrito(): BelongsTo
    {
        return $this->belongsTo(Carrito::class, 'carrito_id', 'id_carrito');
    }

    public function getTotalLineaAttribute()
    {
        return $this->cantidad * $this->precio_unitario;
    }
}