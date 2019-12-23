<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsMainNewsFieldToActionsAndEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->integer('is_main')->default(0);
        });
        Schema::table('events', function (Blueprint $table) {
            $table->integer('is_main')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->dropColumn('is_main');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('is_main');
        });
    }
}
