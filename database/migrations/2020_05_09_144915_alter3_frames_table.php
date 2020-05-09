<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Alter3FramesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('frames', function (Blueprint $table) {
            $table->dropForeign(['id_bg']);
            $table->foreign('id_bg')
                ->references('id')->on('backgrounds')
                ->onDelete('set null');
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
