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
        Schema::create('licitacao_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('licitacao_id')
                  ->constrained('licitacoes')
                  ->onDelete('cascade');

            $table->string('descricao');
            $table->string('tratamento_diferenciado');
            $table->boolean('tem_aplicabilidade_decreto_7174')->default(false);
            $table->boolean('tem_aplicabilidade_margem_preferencial')->default(false);
            $table->integer('quantidade');
            $table->string('unidade_fornecimento');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licitacao_itens');
    }
};
