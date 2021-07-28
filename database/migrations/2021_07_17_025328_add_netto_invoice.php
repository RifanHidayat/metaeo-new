<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNettoInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->after('note', function ($table) {
                $table->bigInteger('netto')->nullable()->default(0);
                $table->integer('ppn')->nullable()->default(0);
                $table->integer('pph')->nullable()->default(0);
                $table->bigInteger('total')->nullable()->default(0);
                $table->text('terbilang')->nullable();
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
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['netto', 'ppn', 'pph', 'total', 'terbilang']);
        });
    }
}
