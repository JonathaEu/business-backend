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
        Schema::create('pagamentos_usuarios', function (Blueprint $table) {
            $table->id();
            $table->double('valor', 11, 2);
            $table->boolean('debito_total');
            $table->string('descricao_pagamento');
            $table->date('data_pagamento');
            $table->enum('metodo_pagamento', ['cartão de crédito', 'cartão de débito', 'pix', 'dinheiro']);
            $table->double('juros', 11, 2);
            $table->int('numero_parcela');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagamentos_usuarios');
    }
};
