<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInitToProjectProfitLostTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_profit_lost_transactions', function (Blueprint $table) {
            //
            $table->integer('init');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_profit_lost_transactions', function (Blueprint $table) {
            // d
            $table->dropColumn('init');
        });
    }
}
