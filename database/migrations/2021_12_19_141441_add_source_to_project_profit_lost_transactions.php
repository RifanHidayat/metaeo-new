<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSourceToProjectProfitLostTransactions extends Migration
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
            $table->string('source')->nullable()->after('amount');
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
            //
            $table->dropColumn('source');
        });
    }
}
