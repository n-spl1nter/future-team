<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersToGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_to_goals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('goal_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('goal_id')
                ->references('id')
                ->on('goals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_to_goals', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['goal_id']);
        });
        Schema::dropIfExists('users_to_goals');
    }
}
