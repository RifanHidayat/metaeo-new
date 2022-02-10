<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationOthersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_others', function (Blueprint $table) {
            $table->id();
            $table->string('number',255);
            $table->date('date');
            $table->date('expired_date');
            $table->string('title',255);
            $table->string('note',255);
            $table->string('subtotal',255);
            $table->bigInteger('asf');
            $table->integer('discount');
            $table->bigInteger('netto');
            $table->integer('ppn');
            $table->integer('pph');
            $table->bigInteger('total');
            $table->string('file');
            $table->foreignId('pic_po_id');
            $table->foreignId('pic_event_id');
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
        Schema::dropIfExists('quotation_others');
    }
}
