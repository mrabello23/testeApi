<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token', 150);
            $table->enum('status', [
                'AUTORIZADO',
                'RECUSADO',
                'GERADO_TOKEN',
                'GERADO_CARTAO_AUTORIZADO',
                'GERADO_CARTAO_RECUSADO',
                'GERADO_CARTAO_RANDOM'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transacoes');
    }
}
