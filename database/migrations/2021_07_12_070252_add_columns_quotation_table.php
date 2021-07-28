<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->string('number', 255);
                $table->date('date');
                $table->foreignId('up');
                $table->string('title', 255);
                $table->text('description')->nullable();
                $table->text('note')->nullable();
                $table->softDeletes();
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
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn(['number', 'date', 'up', 'title', 'description', 'note', 'deleted_at']);
        });
    }
}
