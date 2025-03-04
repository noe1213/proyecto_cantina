<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->integer('ci')->unique();
            $table->string('correo')->unique();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('telefono')->unique();
            $table->string('contrasena');
            $table->string('respuesta_secreta');
            $table->integer('dia_n');
            $table->integer('mes_n');
            $table->integer('anio_n');
            $table->string('municipio');
            $table->string('parroquia');
            $table->string('calle');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
