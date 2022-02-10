<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesOrderEventQuotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_order_event_quotation', function (Blueprint $table) {
            $table->id();
            $table->integer('sales_order_id')->default(0);
            $table->integer('event_quotation_id')->default(0);
            $table->integer('pic_event_id')->default(0);
            $table->bigInteger('total')->default(0);
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
        Schema::dropIfExists('sales_order_event_quotation');
    }
}
