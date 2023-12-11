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
        Schema::create('rendimentos', function (Blueprint $table) {
            $table->id();
            $table->double('valor_rendimento', 11, 2);
            $table->date('data_rendimento');
            $table->foreignId('investimentos_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendimentos');
    }
};
