<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePhotoFieldFromProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn('logo');
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
            $table->string('photo')->after('phone');
        });
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->string('logo')->after('country_id');
        });
    }
}
