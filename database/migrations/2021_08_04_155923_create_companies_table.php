<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable()->default('PT. Magenta Mediatama');
            $table->string('phone', 255)->nullable()->default('(021) 53660077 - 88');
            $table->string('fax', 255)->nullable()->default('( 021 ) 53660099');
            $table->string('head', 255)->nullable()->default('Yo Tinco');
            $table->string('address', 255)->nullable()->default('Jl. Raya Kebayoran Lama No. 15 RT.04 RW.03 Grpgpl Utara, Kebayoran Lama, Jakarta Selatan DKI Jakarta-12210');
            $table->string('logo', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
