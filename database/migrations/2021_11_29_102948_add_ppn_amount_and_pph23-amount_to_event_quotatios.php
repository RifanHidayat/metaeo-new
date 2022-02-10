<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPpnAmountAndPph23AmountToEventQuotatios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_quotations', function (Blueprint $table) {
            $table->integer('ppn_amount')->after('ppn');
            $table->integer('pph23_amount')->after('pph');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_quotations', function (Blueprint $table) {
            //\
        $table->dropColumn(['ppn_amount','pph23_amount']);
        });
    }
}
