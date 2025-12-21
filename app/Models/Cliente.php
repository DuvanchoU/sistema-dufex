<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use SoftDeletes;

    protected $table = 'clientes';
    protected $primaryKey = 'id_cliente';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'email',
        'direccion',
        'fecha_registro',
        'estado',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relaciones
    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'cliente_id', 'id_cliente');
    }

    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class, 'cliente_id', 'id_cliente');
    }

    // Carrito actual del cliente
    public function carrito(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Carrito::class, 'cliente_id', 'id_cliente');
    }
}
