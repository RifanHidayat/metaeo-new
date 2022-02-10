<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTitleToCustomerPurchaseOrder extends Migration
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
            $table->string('title')->nullable()->after('pdescription');
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
            $table->dropColumn('title');
        });
    }
}
