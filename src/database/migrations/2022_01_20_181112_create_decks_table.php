<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('decks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('formato_id');
            $table->string('nome', 64);
            $table->unsignedBigInteger('carta_referencia_id')->nullable();
            $table->unsignedBigInteger('comandante_id')->nullable();

            $table->foreign('usuario_id')->references('id')->on('usuarios')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('formato_id')->references('id')->on('formatos')
                ->onUpdate('no action')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('decks');
    }
}
