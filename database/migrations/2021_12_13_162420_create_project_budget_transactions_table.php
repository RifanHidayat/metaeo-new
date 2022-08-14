<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectBudgetTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('project_budget_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('amount')->default(0);
            $table->string('description')->nullable();
            $table->string('note')->nullable();
            $table->string('type',10);
            $table->string('status');
            $table->integer('account_id')->default(0);
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('transfer_to')->nullable();
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
        Schema::dropIfExists('project_budget_transactions');
    }
}
