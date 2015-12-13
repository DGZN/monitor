<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVimeosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vimeo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('description');
            $table->string('content_rating');
            $table->string('rentActive');
            $table->string('rentPeriod');
            $table->string('rentPrice');
            $table->string('buyActive');
            $table->string('buyPrice');
            $table->string('mainVideo');
            $table->string('trailerVideo');
            $table->string('poster');
            $table->string('genres');
            $table->string('tags');
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
        Schema::drop('vimeo');
    }
}
