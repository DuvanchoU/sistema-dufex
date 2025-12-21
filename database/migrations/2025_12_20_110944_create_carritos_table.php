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
        Schema::create('carritos', function (Blueprint $table) {
            $table->integer('id_carrito')->autoIncrement();
            $table->integer('cliente_id')->nullable()->index(); // FK a clientes.id_cliente
            $table->string('session_id')->nullable(); // Para no logueados
            $table->timestamps();
            $table->softDeletes();
        });

        // Relación con clientes
        Schema::table('carritos', function (Blueprint $table) {
            $table->foreign('cliente_id')->references('id_cliente')->on('clientes')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('carritos'); // Luego la padre
    }

};
