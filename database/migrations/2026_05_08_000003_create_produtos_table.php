<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * MIGRATION - Tabela "produtos" (vendidos no bar).
 *
 * IMPORTANTE: este timestamp foi colocado em 000003 logicamente,
 * mas o nome do arquivo permanece como 000000 por restrição do ambiente.
 * No seu projeto Laravel, renomeie para 2026_05_08_000003_create_produtos_table.php
 * para que rode DEPOIS da migration de bars (FK).
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bar_id')->nullable()->constrained('bars')->nullOnDelete();
            $table->string('nome');
            $table->decimal('preco', 10, 2);
            $table->integer('estoque')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
