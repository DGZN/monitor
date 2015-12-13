<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateVimeoTableWithDeliverIDField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vimeo', function (Blueprint $table) {
            $table->string('deliveryID')->after('id');
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
            $table->dropColumn('deliveryID');
        });
    }
}
