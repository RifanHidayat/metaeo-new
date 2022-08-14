<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnBastRemainingAndNettoToV2SalesOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('v2_sales_orders', function (Blueprint $table) {
            //
            $table->string('bast_remaining')->nullable()->default(0)->after('description');
            $table->string('netto')->nullable()->default(0)->after('bast_remaining');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('v2_sales_orders', function (Blueprint $table) {
            //
        });
    }
}
