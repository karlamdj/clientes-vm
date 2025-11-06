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
        Schema::table('clients', function (Blueprint $table) {
           
            $table->string('payment_status')
                  ->default('pendiente') // <-- Valor por defecto
                  ->after('next_payment_date'); // <-- La ponemos después de la fecha
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // 2. Le decimos cómo deshacer el cambio
            $table->dropColumn('payment_status');
        });
    }
};