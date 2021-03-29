<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimationDigitalItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimation_digital_items', function (Blueprint $table) {
            $table->id();
            $table->string('item', 255);
            $table->foreignId('paper_id');
            $table->foreignId('print_type_id');
            $table->integer('color_1');
            $table->integer('color_2');
            $table->integer('price');
            $table->integer('quantity');
            $table->bigInteger('total');
            $table->string('finishing_item', 255)->nullable();
            $table->integer('finishing_qty')->nullable();
            $table->bigInteger('finishing_unit_price')->nullable();
            $table->bigInteger('finishing_total')->nullable();
            $table->foreignId('estimation_id')->constrained('pic_pos')
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
        Schema::dropIfExists('estimation_digital_items');
    }
}
