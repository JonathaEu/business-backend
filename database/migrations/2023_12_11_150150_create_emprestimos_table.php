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
        Schema::create('emprestimos', function (Blueprint $table) {
            $table->id();
            $table->date('data_emprestimo');
            $table->date('previsa_pagamento');
            $table->boolean('pago');
            $table->string('descricao_emprestimo');
            $table->enum('metodo_emprestimo', ['cartão de crédito', 'cartão de débito', 'dinheiro', 'pix']);
            $table->foreignId('clientes_id')->constrained();
            $table->foreignId('users_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprestimos');
    }
};
