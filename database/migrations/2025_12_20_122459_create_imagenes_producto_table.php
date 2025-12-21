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
        Schema::create('imagenes_producto', function (Blueprint $table) {
            $table->integer('id_imagen')->autoIncrement();
            $table->integer('producto_id')->index();
            $table->string('ruta_imagen');
            $table->string('descripcion')->nullable(); // Ej: "Vista frontal"
            $table->boolean('es_principal')->default(false);
            $table->timestamps();

            $table->foreign('producto_id')->references('id_producto')->on('producto')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagenes_producto');
    }
};
