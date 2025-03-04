<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->integer('ci')->primary();
            $table->string('correo', 100);
            $table->text('nombre');
            $table->text('apellido');
            $table->string('telefono', 45);
            $table->string('contrasena', 8);
            $table->string('confir_contra', 8);
            $table->string('respuesta_secreta', 45);
            $table->integer('dia_n');
            $table->integer('mes_n');
            $table->integer('anio_n');
            $table->string('municipio', 45);
            $table->string('parroquia', 45);
            $table->string('calle', 45);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
