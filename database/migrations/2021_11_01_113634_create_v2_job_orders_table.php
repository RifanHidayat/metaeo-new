<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateV2JobOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v2_job_orders', function (Blueprint $table) {
            $table->id();
            $table->string('number', 50);
            $table->date('date');
            $table->string('estimation_number', 50)->nullable();
            $table->string('title', 255)->nullable();
            $table->integer('order_amount');
            $table->date('delivery_date')->nullable();
            $table->string('print_type', 50)->nullable();
            $table->string('dummy', 50)->nullable();
            $table->tinyInteger('okl')->nullable();
            $table->integer('okl_nth')->nullable();
            $table->string('designer', 255)->nullable();
            $table->string('preparer', 255)->nullable();
            $table->string('examiner', 255)->nullable();
            $table->string('production', 255)->nullable();
            $table->string('finishing', 255)->nullable();
            $table->string('warehouse', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->foreignId('v2_sales_order_id')->nullable();
            $table->foreignId('cpo_item_id')->nullable();
            $table->foreignId('v2_quotation_item_id')->nullable();
            $table->foreignId('customer_id')->nullable();
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
        Schema::dropIfExists('v2_job_orders');
    }
}
