<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddI18ToActivityFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_fields', function (Blueprint $table) {
            $table->renameColumn('value','value_ru');
            $table->renameColumn('description','description_ru');
            $table->string('value_en');
            $table->string('description_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_fields', function (Blueprint $table) {
            $table->renameColumn('value_ru', 'value');
            $table->renameColumn('description_ru', 'description');
            $table->dropColumn('value_en');
            $table->dropColumn('description_en');
        });
    }
}
