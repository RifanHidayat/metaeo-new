<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerIdToBast extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('basts', function (Blueprint $table) {
            //
            $table->integer('customer_id')->default(0);
            $table->string('po_file')->nullable()->change();
            $table->string('gr_file')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('basts', function (Blueprint $table) {
            //
            $table->dropColumn('customer_id');
        });
    }
}
