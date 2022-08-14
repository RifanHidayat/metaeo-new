<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('po_quotations', function (Blueprint $table) {
            $table->id();
            $table->string('number',100);
            $table->date('date');
            $table->string('title');
            $table->bigInteger('amount');
            $table->timestamps();;
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('po_quotations');
    }
}
