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
        Schema::create('licitacoes', function (Blueprint $table) {
            $table->id();
            $table->string('orgao');
            $table->string('uasg');
            $table->string('lei')->nullable();
            $table->string('pregao');
            $table->text('objeto');
            $table->string('edital');
            $table->string('endereco')->nullable();
            $table->string('telefone')->nullable();
            $table->string('fax')->nullable();
            $table->string('entrega');
            $table->string('link_hist_eventos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licitacoes');
    }
};
