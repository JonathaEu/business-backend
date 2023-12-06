<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('emprestimos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao_emprestimo');
            $table->float('valor_emprestimo');
            $table->date('data_emprestimo');
            $table->date('previsao_pagamento')->nullable();
            $table->foreignId('cliente_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('emprestimos');
    }
};
