<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConnectTypesWithCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_type_id');

            $table->foreign('organization_type_id')
                ->references('id')
                ->on('organization_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropForeign(['organization_type_id']);
            $table->dropColumn('organization_type_id');
        });
    }
}
