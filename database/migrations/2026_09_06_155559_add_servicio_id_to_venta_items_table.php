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
         Schema::table('venta_items', function (Blueprint $table) { 
            $table->foreignId('producto_id')->nullable()->change();
            $table->foreignId('servicio_id')->nullable()->after('producto_id')->constrained('servicios'); 
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venta_items', function (Blueprint $table) {
             $table->dropForeign(['servicio_id']); $table->dropColumn('servicio_id');
             $table->foreignId('producto_id')->nullable(false)->change();
          });
    }
};
