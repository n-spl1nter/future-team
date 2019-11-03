<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('phone');
            $table->string('photo');
            $table->smallInteger('age');
            $table->smallInteger('language_exchange_agreement')->default(0);
            $table->integer('city_id');
            $table->unsignedBigInteger('activity_field_id');
            $table->text('motivation');
            $table->timestamps();

            $table->foreign('activity_field_id')
                ->references('id')
                ->on('activity_fields');
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
            $table->dropForeign(['activity_field_id']);
        });
        Schema::dropIfExists('profiles');
    }
}
