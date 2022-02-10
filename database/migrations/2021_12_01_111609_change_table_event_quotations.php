<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTableEventQuotations extends Migration
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
            $table->string('venue')->nullable()->change();
            $table->bigInteger('commissionable_cost')->defaul(0)->nullable()->change();
            $table->bigInteger('nonfee_cost')->default(0)->nullable()->change();
            $table->string('file')->nullable()->change();
            
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
        });
    }
}
