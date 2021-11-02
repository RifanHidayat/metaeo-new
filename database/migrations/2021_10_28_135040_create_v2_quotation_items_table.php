<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateV2QuotationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v2_quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('v2_quotation_id');
            $table->string('code', 50);
            $table->string('description', 510)->nullable();
            $table->date('delivery_date');
            $table->integer('quantity');
            $table->integer('price');
            $table->bigInteger('amount');
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
        Schema::dropIfExists('v2_quotation_items');
    }
}
