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
        Schema::create('productos_by_contornos', function (Blueprint $table) {
            $table->bigInteger('id_producto_by_contorno', true);
            $table->bigInteger('id_producto')->index('id_producto');
            $table->bigInteger('id_contorno')->index('id_contorno');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_by_contornos');
    }
};
