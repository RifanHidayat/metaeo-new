<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateV2SalesorderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v2_salesorder_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('total')->default(0);
            $table->bigInteger('total_bast')->default(0);
            $table->integer('pic_event')->default(0);
            $table->integer('v2_sales_order')->default(0);
           
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
        Schema::dropIfExists('v2_salesorder_items');
    }
}
