<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerIdEstimations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estimations', function (Blueprint $table) {
            $table->after('date', function ($table) {
                $table->foreignId('customer_id');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estimations', function (Blueprint $table) {
            $table->dropColumn(['customer_id']);
        });
    }
}
