<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimationOffsetItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimation_offset_items', function (Blueprint $table) {
            $table->id();
            $table->string('item', 255);
            $table->foreignId('machine_id');
            $table->decimal('size_opened_p', 20, 5);
            $table->decimal('size_opened_l', 20, 5);
            $table->decimal('size_closed_p', 20, 5);
            $table->decimal('size_closed_l', 20, 5);
            $table->integer('color_1');
            $table->integer('color_2');
            $table->foreignId('paper_id');
            $table->decimal('paper_size_plano_p', 20, 5);
            $table->decimal('paper_size_plano_l', 20, 5);
            $table->decimal('paper_gramasi', 20, 5);
            $table->bigInteger('paper_price');
            $table->integer('paper_quantity_plano');
            $table->decimal('paper_cutting_size_p', 20, 5);
            $table->decimal('paper_cutting_size_l', 20, 5);
            $table->decimal('paper_cutting_size_plano_p', 20, 5);
            $table->decimal('paper_cutting_size_plano_l', 20, 5);
            $table->integer('paper_quantity');
            $table->integer('paper_unit_price');
            $table->bigInteger('paper_total');
            $table->integer('plat_film_quantity_set');
            $table->integer('plat_film_unit_price');
            $table->bigInteger('plat_film_total');
            $table->bigInteger('app_set_design');
            $table->foreignId('print_type_id');
            $table->integer('print_quantity');
            $table->integer('print_min_price');
            $table->integer('print_druk_price');
            $table->bigInteger('print_total');
            $table->string('finishing_item', 255)->nullable();
            $table->integer('finishing_qty')->nullable();
            $table->bigInteger('finishing_unit_price')->nullable();
            $table->bigInteger('finishing_total')->nullable();
            $table->foreignId('estimation_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('estimation_offset_items');
    }
}
