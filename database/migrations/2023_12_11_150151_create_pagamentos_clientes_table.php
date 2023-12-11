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
        Schema::create('pagamentos_clientes', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->double('valor_pagamento', 11, 2);
            $table->boolean('debito_total');
            $table->date('data_pagamento');
            $table->enum('metodo_pagamento', ['cartão de crédito', 'cartão de débito', 'pix', 'dinheiro']);
            $table->foreignId('emprestimos_id')->constrained();
            $table->foreignId('users_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagamentos_clientes');
    }
};
