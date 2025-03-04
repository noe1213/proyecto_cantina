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
        Schema::create('productos_contornos', function (Blueprint $table) {
            $table->bigInteger('id_producto');
            $table->integer('id_contorno')->index('fk_contorno');

            $table->primary(['id_producto', 'id_contorno']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_contornos');
    }
};
