<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Ejecutar las migraciones.
    public function up(): void
    {
        Schema::table('produccion', function (Blueprint $table) {
            $table->timestamps();
            $table->softDeletes();
        });
    }

    // Revertir las migraciones.
    public function down(): void
    {
        Schema::table('produccion', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropTimestamps();
        });
    }
};
