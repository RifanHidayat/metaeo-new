<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_orders', function (Blueprint $table) {
            $table->id();
            $table->string('number', 50);
            $table->date('date');
            $table->date('finish_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('designer', 255)->nullable();
            $table->string('preparer', 255)->nullable();
            $table->string('examiner', 255)->nullable();
            $table->string('production', 255)->nullable();
            $table->string('finishing', 255)->nullable();
            $table->string('warehouse', 255)->nullable();
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
        Schema::dropIfExists('job_orders');
    }
}
