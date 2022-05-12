<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deck_id');
            $table->unsignedBigInteger('dono_id')->nullable();
            $table->string('nome', 64);
            $table->integer('quantidade');
            $table->string('id_scryfall', 36);
            $table->string('url_imagem', 255);
            $table->string('url_art_crop', 255);

            $table->foreign('deck_id')->references('id')->on('decks')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('dono_id')->references('id')->on('usuarios')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cartas');
    }
}
