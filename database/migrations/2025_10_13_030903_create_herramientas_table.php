<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('tipo_herramienta', 100);
            $table->string('categoria', 100)->nullable();
            $table->string('unidad_medida', 50);
            $table->integer('cantidad');
            $table->string('estado', 100)->nullable();
            $table->enum('disponibilidad', ['Disponible', 'En uso', 'Dañado'])->default('Disponible');
            $table->dateTime('fecha_registro')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};