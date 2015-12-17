<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateVimeoTableRemovePosterField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vimeo', function (Blueprint $table) {
            $table->dropColumn('poster');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vimeo', function (Blueprint $table) {
            $table->string('poster')->after('trailerVideo');
        });
    }
}
