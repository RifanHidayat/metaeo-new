<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SaleOrderQuotationProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::create('sales_order_quotation_projects', function (Blueprint $table) {
            $table->id();
            $table->integer('event_quotation_id');
            $table->integer('sales_order_id');
            $table->integer('project_id');
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
         Schema::dropIfExists('sales_order_quotation_project');
        //
    }
}
