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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id(); 

            $table->String('Nombres');
            $table->String('Apellidos');
            $table->String('Documento')->nullable();;
            $table->text('Correo');
            $table->String('Rol');
            $table->integer('edad');
            $table->String('Foto') -> default('default.jpg');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
