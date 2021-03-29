<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimations', function (Blueprint $table) {
            $table->id();
            $table->string('number', 30);
            $table->date('date');
            // $table->foreignId('pic_po_id')->constrained()
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');
            $table->string('work', 255);
            $table->integer('quantity');
            $table->bigInteger('production');
            $table->bigInteger('hpp');
            $table->bigInteger('hpp_per_unit');
            $table->bigInteger('price_per_unit');
            $table->integer('margin');
            $table->bigInteger('total_price');
            $table->bigInteger('ppn');
            $table->bigInteger('pph');
            $table->bigInteger('total_bill');
            $table->date('delivery_date');
            $table->string('file', 255)->nullable();
            $table->string('status', 255)->default('open');
            $table->tinyInteger('final')->default(0);
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
        Schema::dropIfExists('estimations');
    }
}
