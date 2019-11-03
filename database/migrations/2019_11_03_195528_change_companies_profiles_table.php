<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCompaniesProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->string('organization_type')->nullable();
            $table->text('cooperation_type');
            $table->string('contact_person_name');
            $table->string('contact_person_email');
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
            $table->dropColumn('organization_type');
            $table->dropColumn('cooperation_type');
            $table->dropColumn('contact_person_name');
            $table->dropColumn('contact_person_email');
        });
    }
}
