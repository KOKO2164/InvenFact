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
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('trabajador_id')->constrained('trabajadores')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('estado_id')->constrained('estados')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->dateTime('fecha', 0)->useCurrent();
            $table->integer('plazo')->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->integer('cantidadProductos')->default(0);
            $table->timestamps();
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
