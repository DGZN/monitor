<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateVimeoTableWithFeatureThumbTrailerThumbCaptionsRegionsAvailDateFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vimeo', function (Blueprint $table) {
            $table->string('featureThumb')->after('trailerVideo');
            $table->string('trailerThumb');
            $table->string('captions');
            $table->string('regions');
            $table->string('availDate');
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
          $table->dropColumn('featureThumb');
          $table->dropColumn('trailerThumb');
          $table->dropColumn('captions');
          $table->dropColumn('regions');
          $table->dropColumn('availDate');
        });
    }
}
