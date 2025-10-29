<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    if (Schema::hasColumn('inventario', 'registrado_por')) {
        Schema::table('inventario', function (Blueprint $table) {
            $table->dropColumn('registrado_por');
        });
    }
}
    public function down()
    {
        Schema::table('inventario', function (Blueprint $table) {
            $table->unsignedBigInteger('registrado_por')->nullable();
        });
    }
};
