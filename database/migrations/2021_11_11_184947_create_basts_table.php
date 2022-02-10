<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basts', function (Blueprint $table) {
            $table->id();
            $table->string('number',255);
            $table->string('gr_number',255);
            $table->date('date');
            $table->string('pic_event');
            $table->string('pic_event_position');
            $table->string('pic_magenta');
            $table->string('pic_magenta_position');
            $table->string('po_file',255);
            $table->string('gr_file',255);
            $table->bigInteger('total');
            $table->foreignId('quotation_event_id');
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
        Schema::dropIfExists('basts');
    }
}
