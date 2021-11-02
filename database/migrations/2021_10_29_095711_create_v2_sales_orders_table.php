<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateV2SalesOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v2_sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('number', 50);
            $table->date('date');
            $table->foreignId('v2_quotation_id')->nullable();
            $table->string('quotation_number', 50)->nullable();
            $table->date('quotation_date')->nullable();
            $table->foreignId('purchase_order_id')->nullable();
            $table->string('purchase_order_number', 50)->nullable();
            $table->date('purchase_order_date')->nullable();
            $table->string('file', 255)->nullable();
            $table->string('description', 255)->nullable();
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
        Schema::dropIfExists('v2_sales_orders');
    }
}
