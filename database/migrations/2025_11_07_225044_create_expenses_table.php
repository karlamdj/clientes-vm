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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // "Renta Oficina", "Luz", etc.
            $table->decimal('amount', 8, 2);           // El monto a pagar
            $table->integer('payment_day');            // El día del mes que vence (ej. 1, 15, 30)
            $table->string('status')->default('pendiente'); // "pendiente" o "pagado"
            $table->date('next_due_date');             // La fecha exacta del próximo vencimiento
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};