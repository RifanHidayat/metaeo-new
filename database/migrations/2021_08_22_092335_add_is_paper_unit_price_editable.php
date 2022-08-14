<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsPaperUnitPriceEditable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estimation_offset_items', function (Blueprint $table) {
            $table->tinyInteger('paper_unit_price_editable')->nullable()->default(0)->after('paper_quantity');
            $table->tinyInteger('print_quantity_editable')->nullable()->default(0)->after('print_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estimation_offset_items', function (Blueprint $table) {
            $table->dropColumn(['paper_unit_price_editable', 'print_quantity_editable']);
        });
    }
}
