<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('number',150);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('customer');
            $table->string('pic_event');
            $table->text('description');
            $table->text('address');
            $table->bigInteger('amount')->default(0);
            $table->string('source')->nullable();
            $table->integer('customer_id')->default(0);
            $table->integer('pic_event_id')->default(0);
           
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
        Schema::dropIfExists('projects');
    }
}
