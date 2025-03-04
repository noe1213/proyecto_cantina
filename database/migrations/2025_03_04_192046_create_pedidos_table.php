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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigInteger('id_pedido', true);
            $table->integer('cliente_ci')->index('cliente_ci');
            $table->string('metodo_pago', 45);
            $table->integer('hora_pedido');
            $table->integer('minutos_pedido');
            $table->integer('dia_pedido');
            $table->integer('mes_pedido');
            $table->integer('anio_pedido');
            $table->integer('estado_pedido');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
