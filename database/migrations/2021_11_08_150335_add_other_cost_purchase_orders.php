<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherCostPurchaseOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->after('discount', function (Blueprint $table) {
                $table->tinyInteger('ppn')->nullable()->default(0);
                $table->tinyInteger('ppn_value')->nullable()->default(0);
                $table->integer('ppn_amount')->nullable()->default(0);
                $table->integer('shipping_cost')->nullable()->default(0);
                $table->integer('other_cost')->nullable()->default(0);
                $table->string('other_cost_description', 255)->nullable();
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
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn(['ppn', 'ppn_value', 'ppn_amount', 'shipping_cost', 'other_cost', 'other_cost_description']);
        });
    }
}
