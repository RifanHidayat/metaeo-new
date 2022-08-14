<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBudgetProjectIdToBudgetProjectTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_budget_transactions', function (Blueprint $table) {
            //
             $table->integer('project_budget_id')->default(0)->after('init');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_budget_transactions', function (Blueprint $table) {
            //
        });
    }
}
