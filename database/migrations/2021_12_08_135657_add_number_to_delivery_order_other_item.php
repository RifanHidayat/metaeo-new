<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumberToDeliveryOrderOtherItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_order_other_quotation_items', function (Blueprint $table) {
            //
            $table->string('number');
            $table->renameColumn('kts','frequency')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_order_other_quotation_items', function (Blueprint $table) {
            //
        });
    }
}
