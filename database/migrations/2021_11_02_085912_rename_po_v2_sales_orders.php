<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePoV2SalesOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('v2_sales_orders', function (Blueprint $table) {
            $table->renameColumn('purchase_order_id', 'customer_purchase_order_id');
            $table->renameColumn('purchase_order_number', 'customer_purchase_order_number');
            $table->renameColumn('purchase_order_date', 'customer_purchase_order_date');
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
            $table->renameColumn('customer_purchase_order_id', 'purchase_order_id');
            $table->renameColumn('customer_purchase_order_number', 'purchase_order_number');
            $table->renameColumn('customer_purchase_order_date', 'purchase_order_date');
        });
    }
}
