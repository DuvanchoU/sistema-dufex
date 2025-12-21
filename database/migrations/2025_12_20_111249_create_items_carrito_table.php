<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('items_carrito', function (Blueprint $table) {
            $table->integer('id_item')->autoIncrement();
            $table->integer('carrito_id')->index();
            $table->integer('producto_id')->index(); // FK a producto.id_producto
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 15, 2);
            $table->timestamps();

            // Relaciones
            $table->foreign('carrito_id')->references('id_carrito')->on('carritos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id_producto')->on('producto')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('items_carrito'); // Primero elimina la tabla hija
    }
};
