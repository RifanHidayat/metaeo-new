<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumberColumnsQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->after('note', function ($table) {
                $table->integer('quantity')->nullable()->default(0);
                $table->integer('price_per_unit')->nullable()->default(0);
                $table->integer('ppn')->nullable()->default(0);
                $table->integer('pph')->nullable()->default(0);
                $table->bigInteger('total_bill')->nullable()->default(0);
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
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'price_per_unit', 'ppn', 'pph', 'total_bill']);
        });
    }
}
