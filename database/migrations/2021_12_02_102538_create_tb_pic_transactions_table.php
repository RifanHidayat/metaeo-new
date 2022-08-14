<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPicTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pic_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->text('desctiption');
            $table->bigInteger('amount');
            $table->string('type',20);
            $table->integer('pic_tb_id');
            $table->integer('po_quotation');
            $table->bigInteger('table_id');
            $table->string('table_name');
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
        Schema::dropIfExists('tb_pic_transactions');
    }
}
