<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carrito extends Model
{
    use SoftDeletes;

    protected $table = 'carritos';
    protected $primaryKey = 'id_carrito';
    public $timestamps = true;

    protected $fillable = ['cliente_id', 'session_id'];

    // Relaciones
    public function cliente(): HasOne
    {
        return $this->hasOne(Cliente::class, 'id_cliente', 'cliente_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ItemCarrito::class, 'carrito_id', 'id_carrito');
    }

    // Accesor para total
    public function getTotalAttribute()
    {
        return $this->items->sum(fn($item) => $item->cantidad * $item->precio_unitario);
    }
}