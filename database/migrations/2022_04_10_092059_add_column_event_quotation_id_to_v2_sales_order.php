<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnEventQuotationIdToV2SalesOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('v2_sales_orders', function (Blueprint $table) {
            //
            $table->integer('event_quotation_id')->nullable()->after('v2_quotation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('v2_sales_orders', function (Blueprint $table) {
            //
        });
    }
}
