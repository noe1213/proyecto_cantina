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
        Schema::table('productos_contornos', function (Blueprint $table) {
            $table->foreign(['id_contorno'], 'fk_contorno')->references(['id_contorno'])->on('contornos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_producto'], 'fk_producto')->references(['id_producto'])->on('productos')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos_contornos', function (Blueprint $table) {
            $table->dropForeign('fk_contorno');
            $table->dropForeign('fk_producto');
        });
    }
};
