<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetNullableTrueTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('payment_method', 50)->nullable()->change();
            $table->after('note', function ($table) {
                $table->string('sender_name', 255)->nullable();
                $table->string('sender_number', 255)->nullable();
                $table->string('sender_bank', 255)->nullable();
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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('payment_method', 50)->nullable(false)->change();
            $table->dropColumn(['sender_name', 'sender_number', 'sender_bank']);
        });
    }
}
