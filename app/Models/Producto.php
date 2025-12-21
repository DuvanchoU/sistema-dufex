<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Categoria;

class Producto extends Model
{
    use SoftDeletes;

    protected $table = 'producto';
    protected $primaryKey = 'id_producto';
    public $timestamps = true;

    protected $fillable = [
        'codigo_producto',
        'referencia_producto',
        'categoria_id',
        'tipo_madera',
        'color_producto',
        'precio_actual',
    ];
    
    protected $dates = ['deleted_at'];
    
    // Un producto PERTENECE A una categoría
    public function categoria()
    {
        return $this->belongsTo(
            Categoria::class,
            'categoria_id',
            'id_categorias'
        );
    }

    // Un producto TIENE MUCHOS detalles de compra
    public function detallesCompra()
    {
        return $this->hasMany(
            DetalleCompra::class,
            'producto_id',
            'id_producto'
        );
    }

    //Un producto TIENE MUCHOS detalles de venta
    public function detallesVenta()
    {
        return $this->hasMany(
            DetalleVenta::class,
            'producto_id',
            'id_producto'
        );
    }

    // Un producto TIENE MUCHOS inventarios
    public function inventarios()
    {
        return $this->hasMany(
            Inventario::class,
            'producto_id',
            'id_producto'
        );
    }

    public function producciones()
    {
        return $this->hasMany(
            Produccion::class,
            'producto_id',
            'id_producto'
        );
    }

    // Obtener la clave de ruta para el modelo.    
    public function getRouteKeyName()
    {
        return 'id_producto';
    }

    // Si usas múltiples imágenes
    public function imagenes()
    {
        return $this->hasMany(ImagenProducto::class, 'producto_id', 'id_producto');
    }

    // Accesor para obtener la URL de la imagen principal
    public function getImagenPrincipalAttribute()
    {
        $principal = $this->imagenes()->where('es_principal', true)->first();
        if ($principal) {
            return asset('storage/' . $principal->ruta_imagen);
        }
        $primera = $this->imagenes()->first();
        if ($primera) {
            return asset('storage/' . $primera->ruta_imagen);
        }
        return asset('images/default-product.jpg');
    }
}
