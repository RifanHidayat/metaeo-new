<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDeliveryOrderEventQuotaions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_order_event_quotaions', function (Blueprint $table) {
            
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->integer('quantity');
            $table->integer('kts');
            $table->string('unit');
            $table->string('description')->nullable();
            $table->integer('delivery_order_id');
            $table->integer('event_quotations');

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
        Schema::dropIfExists('delivery_order_event_quotaions');
    }
}
