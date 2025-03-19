<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_information', function (Blueprint $table) {
            $table->string('full_name');
            $table->string('alias')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('numChildren')->default(0);
            $table->string('tribe_name');
            $table->string('ethno_group')->nullable();
            $table->foreignId('ind_region_id')->constrained('regions')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('ind_province_id')->constrained('provinces')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('ind_city_id')->constrained('cities')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('ind_barangay_id')->constrained('barangays')->onDelete('restrict')->onUpdate('cascade');
            $table->string('settlement_name')->nullable();
            $table->string('fatherName');
            $table->boolean('fatherIndigenous')->default(0);
            $table->string('motherName');
            $table->boolean('motherIndigenous')->default(0);
            $table->string('spouseName')->nullable();
            $table->string('communityRole');
            $table->string('livelihood');
            $table->string('education');
            $table->string('skills');
            $table->string('ipOrganization')->nullable();
            $table->string('governmentAssistance')->nullable();
            $table->string('ipmrStatus')->nullable();
            $table->string('organizationAffiliation')->nullable();
            $table->string('traditionalPractices')->nullable();
            $table->string('landmark')->nullable();
            $table->string('email_address')->nullable();
            $table->string('traditional_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_information', function (Blueprint $table) {
            $table->dropColumn('full_name');
            $table->dropColumn('tribe_name');
            $table->dropColumn('ethno_group');
            $table->dropForeign(['ind_region_id']);
            $table->dropColumn('ind_region_id');
            $table->dropForeign(['ind_province_id']);
            $table->dropColumn('ind_province_id');
            $table->dropForeign(['ind_city_id']);
            $table->dropColumn('ind_city_id');
            $table->dropForeign(['ind_barangay_id']);
            $table->dropColumn('ind_barangay_id');
            $table->dropColumn('settlement_name');
            $table->dropColumn('fatherName');
            $table->dropColumn('fatherIndigenous')->default(0);
            $table->dropColumn('motherName');
            $table->dropColumn('motherIndigenous')->default(0);
            $table->dropColumn('spouseName');
            $table->dropColumn('communityRole');
            $table->dropColumn('livelihood');
            $table->dropColumn('education');
            $table->dropColumn('skills');
            $table->dropColumn('email_address');
        });
    }
}
