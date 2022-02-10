<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventQuotationSubItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_quotation_sub_item', function (Blueprint $table) {
           $table->id();
            $table->integer('sub_item_id');
            $table->integer('event_quotation_id');
            $table->integer('is_stock')->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('frequency')->defaukt(0);
            $table->bigInteger('rate')->default(0);
            $table->integer('subtotal')->nullable()->default(0);
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
        Schema::dropIfExists('event_quotation_sub_item');
    }
}
