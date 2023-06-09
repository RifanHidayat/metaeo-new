<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSourceToCustomerPurchaseOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_purchase_orders', function (Blueprint $table) {
            //
            $table->string('source')->default('cpo')->after("customer_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_purchase_orders', function (Blueprint $table) {
            //
            $table->dropColumn('source');
        });
    }
}
