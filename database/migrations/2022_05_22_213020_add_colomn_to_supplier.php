<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnToSupplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            //
            $table->string("npwp_number")->nullable()->after('email');
            $table->string("npwp_address")->nullable()->after('npwp_number');
            $table->string("contact_name")->nullable()->after('npwp_address');
            $table->string("contact_number")->nullable()->after('npwp_person');
            $table->string("contact_position")->nullable()->after('npwp_address');
            $table->string("contact_email")->nullable()->after('npwp_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            //
        });
    }
}
