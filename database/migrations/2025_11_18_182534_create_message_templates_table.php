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
    Schema::create('message_templates', function (Blueprint $table) {
        $table->id();
        $table->string('service_name'); // ej: 'vm_tech', 'vm_eats'
        $table->string('trigger_event'); // ej: '5_days_before', 'due_date'
        $table->text('message_body'); // El texto del mensaje
        $table->timestamps();

        // Clave única para asegurar que no haya duplicados
        $table->unique(['service_name', 'trigger_event']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_templates');
    }
};
