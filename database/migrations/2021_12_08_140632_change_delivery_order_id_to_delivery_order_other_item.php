<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDeliveryOrderIdToDeliveryOrderOtherItem extends Migration
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
            $table->renameColumn("deliver_order_id",'delivery_order_id')->after('unit')->change();
            $table->string("number")->after('id')->change();
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
