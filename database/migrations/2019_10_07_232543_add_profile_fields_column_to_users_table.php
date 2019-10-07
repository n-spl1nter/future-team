<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('company_profile')->nullable();
            $table->unsignedBigInteger('user_profile')->nullable();

            $table->foreign('company_profile')
                ->references('id')
                ->on('company_profiles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('user_profile')
                ->references('id')
                ->on('profiles')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['user_profile']);
            $table->dropForeign(['company_profile']);
            $table->dropColumn('company_profile');
            $table->dropColumn('user_profile');
        });
    }
}
