<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFkAssinaturaPlano extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assinaturas', function (Blueprint $table) {
             $table->foreign('id_plano', 'fk_assinatura_plano')->references('id')->on('planos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assinaturas', function (Blueprint $table) {
            $table->dropForeign('fk_assinatura_plano');
        });
    }
}
