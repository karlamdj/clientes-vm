<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // Para el Nombre
            $table->string('company')->nullable();       // Para la Empresa (nullable = puede estar vacío)
            $table->string('phone_number');              // Para el teléfono/WhatsApp
            $table->string('service_type');              // Para el Tipo de servicio
            $table->decimal('payment_amount', 8, 2);   // Para el Monto (8 dígitos total, 2 decimales)
            $table->date('subscription_date');         // Para la Fecha de suscripción
            $table->date('next_payment_date');         // Para la Fecha del próximo pago
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
