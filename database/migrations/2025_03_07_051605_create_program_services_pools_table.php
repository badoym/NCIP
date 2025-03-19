<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramServicesPoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_services_pools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('government_program_id')->nullable()->constrained('government_programs')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('restrict')->onUpdate('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('program_services_pools');
    }
}
