<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('number', 50);
            $table->date('date');
            $table->foreignId('supplier_id');
            $table->string('delivery_address', 510);
            $table->date('delivery_date');
            $table->foreignId('shipment_id');
            $table->string('payment_term', 50);
            $table->foreignId('fob_item_id');
            $table->string('description', 255)->nullable();
            $table->bigInteger('subtotal');
            $table->integer('discount');
            $table->bigInteger('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
}
