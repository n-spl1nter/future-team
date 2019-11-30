<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityFieldsArrayField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->text('activity_fields')->nullable();
            $table->dropForeign(['activity_field_id']);
            $table->dropColumn('activity_field_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('activity_fields');
            $table->unsignedBigInteger('activity_field_id');
            $table->foreign('activity_field_id')
                ->references('id')
                ->on('activity_fields');
        });
    }
}
