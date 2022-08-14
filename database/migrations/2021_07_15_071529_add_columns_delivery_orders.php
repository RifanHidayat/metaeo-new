<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsDeliveryOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_orders', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->string('number', 50);
                $table->date('date');
                $table->string('warehouse', 255)->nullable();
                $table->string('shipper', 255)->nullable();
                $table->string('number_of_vehicle', 20)->nullable();
                $table->string('billing_address', 255)->nullable();
                $table->string('shipping_address', 255)->nullable();
                $table->foreignId('sales_order_id');
                $table->softDeletes();
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
        Schema::table('delivery_orders', function (Blueprint $table) {
            $table->dropColumn(['number', 'date', 'shipper', 'number_of_vehicle', 'billing_address', 'shipping_address', 'sales_order_id', 'deleted_at']);
        });
    }
}
