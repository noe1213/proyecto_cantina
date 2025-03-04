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
        Schema::create('productos', function (Blueprint $table) {
            $table->bigInteger('id_producto', true);
            $table->string('nombre_producto', 100);
            $table->decimal('precio_producto', 10, 0);
            $table->string('categoria_producto', 45);
            $table->integer('stock_producto');
            $table->integer('stock_minimo');
            $table->longText('imagen')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
