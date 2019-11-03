<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddI18nFieldsToOrganizationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organization_types', function (Blueprint $table) {
            $table->string('value_en')->after('value');
            $table->renameColumn('value', 'value_ru');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organization_types', function (Blueprint $table) {
            $table->renameColumn('value_ru', 'value');
            $table->dropColumn('value_en');
        });
    }
}
