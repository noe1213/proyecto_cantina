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
        Schema::create('productos_by_pedidos', function (Blueprint $table) {
            $table->bigInteger('id_producto_by_pedido', true);
            $table->bigInteger('id_pedido')->index('id_pedido');
            $table->bigInteger('id_producto')->index('id_producto');
            $table->integer('cantidad');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_by_pedidos');
    }
};
