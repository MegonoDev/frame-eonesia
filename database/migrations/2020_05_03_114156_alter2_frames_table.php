<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Alter2FramesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('frames', function (Blueprint $table) {
            $table->bigInteger('id_bg')->after('link_frame')->unsigned();
            $table->foreign('id_bg')->references('id')->on('backgrounds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frames', function (Blueprint $table) {
            //
        });
    }
}
