<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_quotations', function (Blueprint $table) {
            $table->id();
            $table->string('number',255);
            $table->date('date');
            $table->date('expired_date');
            $table->string('title',255);
            $table->string('venue',255);
            $table->string('event_date',100);
            $table->bigInteger('commissionable_cost');
            $table->bigInteger('nonfee_cost');
            $table->integer('asf');
            $table->bigInteger('subtotal');
            $table->integer('discount');
            $table->bigInteger('netto');
            $table->integer('pph');
            $table->integer('ppn');
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
        Schema::dropIfExists('event_quotations');
    }
}
