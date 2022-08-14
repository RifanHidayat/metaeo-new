<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateV2JobOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v2_job_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('v2_job_order_id');
            $table->string('item', 255)->nullable();
            $table->foreignId('paper')->nullable();
            $table->string('plano_size')->nullable();
            $table->string('plano_amount')->nullable();
            $table->string('cutting_size')->nullable();
            $table->string('cutting_amount')->nullable();
            $table->string('order_amount')->nullable();
            $table->string('print_amount')->nullable();
            $table->string('color')->nullable();
            $table->string('film_set')->nullable();
            $table->string('film_total')->nullable();
            $table->string('print_type')->nullable();
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
        Schema::dropIfExists('v2_job_order_items');
    }
}
