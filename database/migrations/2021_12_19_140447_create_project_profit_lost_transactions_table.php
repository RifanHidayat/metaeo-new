<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectProfitLostTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_profit_lost_transactions', function (Blueprint $table) {
             $table->id();
            $table->date('date');
            $table->string('description')->nullable();
            $table->string('note')->nullable();
            $table->integer('amount')->default(0);
            $table->integer('account_id')->default(0);
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->integer('project_id')->default(0);
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
        Schema::dropIfExists('project_profit_lost_transactions');
    }
}
