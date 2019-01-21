<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssinaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('assinaturas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo');
            $table->string('cartao');
            $table->string('vencimento', 10);
            $table->smallInteger('cod_cartao');
            $table->enum('status', ['AUTORIZADO','RECUSADO']);
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_plano');
            $table->foreign('id_usuario')->references('id')->on('usuarios');
            $table->foreign('id_plano')->references('id')->on('planos');
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
        Schema::dropIfExists('assinaturas');
    }
}
