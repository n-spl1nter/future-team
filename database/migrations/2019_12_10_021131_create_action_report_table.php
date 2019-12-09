<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('action_id');
            $table->text('video_links')->nullable();
            $table->timestamps();

            $table->foreign('action_id')
                ->references('id')
                ->on('actions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('action_reports', function (Blueprint $table) {
            $table->dropForeign(['action_id']);
        });
        Schema::dropIfExists('action_reports');
    }
}
