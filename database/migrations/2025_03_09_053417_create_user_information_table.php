<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('restrict')->onUpdate('cascade');
            $table->string('gender');
            $table->string('age');
            $table->date('birthday');
            $table->string('phone_number')->nullable();
            $table->foreignId('indigenous_group_id')->nullable()->constrained('indigenous_groups')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('region_id')->constrained('regions')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('province_id')->constrained('provinces')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('city_id')->constrained('cities')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('barangay_id')->constrained('barangays')->onDelete('restrict')->onUpdate('cascade');
            $table->longText('address1')->nullable();
            $table->longText('address2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_information');
    }
}
