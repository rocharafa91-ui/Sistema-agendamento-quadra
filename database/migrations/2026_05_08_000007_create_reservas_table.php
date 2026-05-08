<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('quadra_id')->nullable()->constrained('quadras')->nullOnDelete();
            $table->foreignId('espaco_lazer_id')->nullable()->constrained('espacos_lazer')->nullOnDelete();
            $table->date('data');
            $table->string('horario', 5); // formato HH:MM
            $table->string('status', 20)->default('pendente'); // pendente | confirmada | cancelada
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
