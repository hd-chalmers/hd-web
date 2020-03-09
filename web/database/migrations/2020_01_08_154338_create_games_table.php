<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('bgg_id')->nullable();
            $table->bigInteger('game_platform_id');
            $table->unsignedInteger('min_players')->nullable();
            $table->unsignedInteger('max_players')->nullable();
            $table->string('published_year')->nullable();
            $table->unsignedInteger('min_playtime')->nullable();
            $table->unsignedInteger('max_playtime')->nullable();
            $table->bigInteger('expansion_to')->nullable();
            $table->bigInteger('game_owner_id')->nullable();
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
        Schema::dropIfExists('games');
    }
}
