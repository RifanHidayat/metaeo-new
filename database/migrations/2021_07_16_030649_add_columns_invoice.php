<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->string('number');
                $table->date('date');
                $table->string('tax_invoice_series', 255)->nullable();
                $table->string('terms_of_payment', 255)->nullable();
                $table->string('pic_po', 255)->nullable();
                $table->string('pic_po_position', 255)->nullable();
                $table->string('note', 255)->nullable();
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
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['number', 'date', 'tax_invoice_series', 'terms_of_payment', 'pic_po', 'pic_po_position', 'note', 'deleted_at']);
        });
    }
}
