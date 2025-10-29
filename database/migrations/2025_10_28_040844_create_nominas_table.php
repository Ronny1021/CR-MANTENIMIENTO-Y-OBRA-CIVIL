<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nominas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('cascade');
            $table->string('lugar');
            $table->date('fecha');
            $table->time('hora_entrada');
            $table->time('hora_salida');
            $table->decimal('horas_trabajadas', 5, 2)->nullable(); // Calculada en el controlador
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nominas');
    }
};

