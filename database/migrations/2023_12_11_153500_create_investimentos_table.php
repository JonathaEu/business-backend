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
        Schema::create('investimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_investimento');
            $table->double('valor_investimento', 11, 2);
            $table->string('descricao_investimento');
            $table->date('data_aporte');
            $table->foreignId('categoria_investimentos_id')->constrained();
            $table->foreignId('users_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investimentos');
    }
};
