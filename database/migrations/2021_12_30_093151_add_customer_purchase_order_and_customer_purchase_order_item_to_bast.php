<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerPurchaseOrderAndCustomerPurchaseOrderItemToBast extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('basts', function (Blueprint $table) {
            //
            $table->string('v2_sales_order_id')->default(0)->after('event_quotation_id');
            $table->integer('v2_sales_order_item_id')->default(0)->after('v2_sales_order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('basts', function (Blueprint $table) {
            //
        });
    }
}
