<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToEventQuotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_quotations', function (Blueprint $table) {
            //
            $table->string('type')->default('event')->nullable()->after('pic_event_id');
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
            //
            $table->dropColumn('type');
        });
    }
}
