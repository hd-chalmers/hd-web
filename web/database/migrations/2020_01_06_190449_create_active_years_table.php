<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_years', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('year');
            $table->text('description')->nullable();
            $table->longText('group_photo')->nullable();
            $table->longText('front_image')->nullable();
            $table->longText('christmas_image')->nullable();
            $table->longText('background_image')->nullable();
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
        Schema::dropIfExists('active_years');
    }
}
