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
        Schema::create('trabajador_proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('telefono', 9)->nullable();
            $table->foreignId('proveedor_id')->constrained('proveedores')->onUpdate('restrict')->onDelete('restrict');
            $table->boolean('estado')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajador_proveedores');
    }
};
