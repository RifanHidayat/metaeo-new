<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationOtherItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_other_items', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->integer('quantity');
            $table->integer('frequency');
            $table->integer('unit_price');
            $table->bigInteger('total');
            $table->foreignId('quotation_other_id');
            $table->softDeletes();
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
        Schema::dropIfExists('quotation_other_items');
    }
}
