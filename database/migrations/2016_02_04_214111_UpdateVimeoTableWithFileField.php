<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateVimeoTableWithFileField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vimeo', function (Blueprint $table) {
            $table->string('file')->after('deliveryID');
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
            $table->dropColumn('file');
        });
    }
}
