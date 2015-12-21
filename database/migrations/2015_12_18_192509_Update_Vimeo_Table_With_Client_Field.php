<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateVimeoTableWithClientField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vimeo', function (Blueprint $table) {
            $table->string('client')->after('deliveryID');
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
            $table->dropColumn('client');
        });
    }
}
