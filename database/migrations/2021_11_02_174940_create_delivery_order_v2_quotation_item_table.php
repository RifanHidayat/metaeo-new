<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryOrderV2QuotationItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_order_v2_quotation_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_order_id');
            $table->foreignId('v2_quotation_item_id');
            $table->string('code', 50)->nullable();
            $table->string('description', 500)->nullable();
            $table->string('information', 500)->nullable();
            $table->string('unit', 255);
            $table->integer('amount');
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
        Schema::dropIfExists('delivery_order_v2_quotation_item');
    }
}
