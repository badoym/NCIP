<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCancelledByOnPool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_services_pools', function (Blueprint $table) {
            $table->boolean('cancelled')->default(0);
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_services_pools', function (Blueprint $table) {
            $table->dropForeign('program_services_pools_cancelled_by_foreign');
            $table->dropColumn('cancelled_by');
            $table->dropColumn('cancelled');
        });
    }
}
