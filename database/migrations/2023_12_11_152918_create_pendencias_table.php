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
        Schema::create('pendencias', function (Blueprint $table) {
            $table->id();
            $table->double('valor_pendencia', 11, 2);
            $table->string('quem_recebe');
            $table->date('data_pendencia');
            $table->string('descricao_pendencia');
            $table->int('parcelas');
            $table->foreignId('users_id')->constrained();
            $table->foreignId('categoria_gastos_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendencias');
    }
};
