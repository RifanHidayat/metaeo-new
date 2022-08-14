<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEventQuotationGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_quotation_goods', function (Blueprint $table) {
            //
            $table->id();
            $table->integer('event_quotation_id');
            $table->integer('goods_id')->default(0);
            $table->integer('quantitiy')->default(0);
            $table->integer('frequency')->default(0);
            $table->bigInteger('rate')->default(0);

            $table->bigInteger('sub_total')->default(0);
            $table->integer('is_stock')->default(0);

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
        Schema::dropIfExists('event_quotation_goods', function (Blueprint $table) {
            //
        });
    }
}
