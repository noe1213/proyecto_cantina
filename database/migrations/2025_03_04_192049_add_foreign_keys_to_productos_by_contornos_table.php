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
        Schema::table('productos_by_contornos', function (Blueprint $table) {
            $table->foreign(['id_producto'], 'productos_by_contornos_ibfk_1')->references(['id_producto'])->on('productos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_contorno'], 'productos_by_contornos_ibfk_2')->references(['id_contorno'])->on('contornos')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos_by_contornos', function (Blueprint $table) {
            $table->dropForeign('productos_by_contornos_ibfk_1');
            $table->dropForeign('productos_by_contornos_ibfk_2');
        });
    }
};
