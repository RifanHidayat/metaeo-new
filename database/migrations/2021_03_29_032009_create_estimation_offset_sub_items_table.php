<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimationOffsetSubItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimation_offset_sub_items', function (Blueprint $table) {
            $table->id();
            $table->string('finishing_item', 255);
            $table->integer('finishing_qty');
            $table->bigInteger('finishing_unit_price');
            $table->bigInteger('finishing_total');
            $table->foreignId('estimation_offset_item_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('estimation_offset_sub_items');
    }
}
