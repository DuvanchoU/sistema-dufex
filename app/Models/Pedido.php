<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pedido extends Model
{   
    use SoftDeletes;

    protected $table = 'pedido';
    protected $primaryKey = 'id_pedido';
    public $timestamps = true;

    protected $fillable = [
        'usuario_id',
        'cliente_id',
        'fecha_pedido',
        'fecha_entrega_estimada',
        'total_pedido',
        'estado_pedido',
        'direccion_entrega',
        'asesor_id' // Nuevo campo
    ];

    protected $dates = ['deleted_at'];

    // Relaciones
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id_cliente');
    }

    public function venta(): HasOne
    {
        return $this->hasOne(Venta::class, 'pedido_id', 'id_pedido');
    }

    // Asesor comercial asignado
    public function asesor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'asesor_id', 'id_usuario');
    }
}
