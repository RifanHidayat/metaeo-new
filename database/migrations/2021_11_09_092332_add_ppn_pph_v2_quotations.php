<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPpnPphV2Quotations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('v2_quotations', function (Blueprint $table) {
            $table->after('note', function (Blueprint $table) {
                $table->bigInteger('subtotal');
                $table->tinyInteger('ppn')->nullable()->default(0);
                $table->tinyInteger('ppn_value')->nullable()->default(0);
                $table->integer('ppn_amount')->nullable()->default(0);
                $table->tinyInteger('pph23')->nullable()->default(0);
                $table->tinyInteger('pph23_value')->nullable()->default(0);
                $table->integer('pph23_amount')->nullable()->default(0);
                $table->integer('other_cost')->nullable()->default(0);
                $table->string('other_cost_description', 255)->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('v2_quotations', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'ppn', 'ppn_value', 'ppn_amount', 'pph23', 'pph23_value', 'pph23_amount', 'other_cost', 'other_cost_description']);
        });
    }
}
