<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherQuotationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_quotation_items', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->integer('quantity')->default(0);
            $table->integer('frequency')->default(0);
            $table->bigInteger('price')->default(0);
            $table->bigInteger('amount')->default(0);
            $table->integer('is_stock')->default(0);
            $table->integer('stock')->default(0);
            $table->integer('event_quotation_id')->default(0);
            $table->integer('goods_id')->default(0)->nullable();
            $table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('other_quotation_items');
    }
}
