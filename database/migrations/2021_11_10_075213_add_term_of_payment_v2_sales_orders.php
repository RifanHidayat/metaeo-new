<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTermOfPaymentV2SalesOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('v2_sales_orders', function (Blueprint $table) {
            $table->after('customer_purchase_order_date', function (Blueprint $table) {
                $table->string('term_of_payment', 255)->nullable();
                $table->date('due_date')->nullable();
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
        Schema::table('v2_sales_orders', function (Blueprint $table) {
            $table->dropColumn(['term_of_payment', 'due_date']);
        });
    }
}
